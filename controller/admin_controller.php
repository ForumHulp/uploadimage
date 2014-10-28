<?php
/**
*
* @package Upload Image
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\uploadimage\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Admin controller
*/
class admin_controller
{
	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var ContainerInterface */
	protected $phpbb_container;

	/** @var  \phpbb\cache */
	protected $cache;

	/** @var \phpbb\pagination */
	protected $pagination;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	/** string Custom form action */
	protected $u_action;

	/**
	* Array of allowed image extensions
	* Array is used for setting the allowed extensions in the fileupload class
	* and as a base for a regex of allowed extensions, which will be formed by
	* imploding the array with a "|".
	*
	* @var array
	*/
	protected $allowed_extensions = array(
		'gif',
		'jpg',
		'jpeg',
		'png',
	);

	/**
	* Constructor
	*
	* @param \phpbb\controller\helper             $helper           Controller helper object
	* @param \phpbb\request\request               $request          Request object
	* @param \phpbb\template\template             $template         Template object
	* @param \phpbb\user                          $user             User object
	* @param ContainerInterface                   $phpbb_container  Service container interface
	* @param string                               $root_path        phpBB root path
	* @access public
	*/
	public function __construct(\phpbb\controller\helper $helper, \phpbb\path_helper $path_helper, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, ContainerInterface $phpbb_container, \phpbb\cache\service $cache, \phpbb\pagination $pagination, \phpbb\log\log $log, \phpbb\plupload\plupload $plupload, $root_path, $php_ext)
	{
		$this->helper = $helper;
		$this->path_helper = $path_helper;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->container = $phpbb_container;
		$this->cache = $cache;
		$this->pagination = $pagination;
		$this->log = $log;
		$this->plupload = $plupload;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	* Display the images
	*
	* @return null
	* @access public
	*/
	public function display_images()
	{
		$error = $attachment_data = array();
		$this->user->add_lang('posting');  // For error messages
		$s_action = $this->u_action . '&action=add';
		$form_enctype = (@ini_get('file_uploads') == '0' || strtolower(@ini_get('file_uploads')) == 'off') ? '' : ' enctype="multipart/form-data"';
		$max_filesize = @ini_get("upload_max_filesize");
		if (!empty($max_filesize))
		{
			$unit = strtolower(substr($max_filesize, -1, 1));
			$max_filesize = (int) $max_filesize;

			switch ($unit)
			{
				case 'g':
					$max_filesize *= 1024;
				// no break
				case 'm':
					$max_filesize *= 1024;
				// no break
				case 'k':
					$max_filesize *= 1024;
				// no break
			}
		}
		add_form_key('postform');

		// Start assigning vars for main page ...
		$this->template->assign_vars(array(
			'ERROR'						=> (sizeof($error)) ? implode('<br />', $error) : '',
			'S_FORM_ENCTYPE'			=> $form_enctype,
			'S_POST_ACTION'				=> $s_action,
			'FILESIZE'					=> $max_filesize,
			'S_ATTACH_DATA'				=> json_encode(array() /*$message_parser->attachment_data*/),
		));

		// Show attachment box for adding attachments if true
		if ($form_enctype)
		{
			$this->plupload->configure($this->cache, $this->template, $s_action, 0, 10);
		}

		// Determine board url - we may need it later
		$board_url = generate_board_url() . '/';
		// This path is sent with the base template paths in the assign_vars()
		// call below. We need to correct it in case we are accessing from a
		// controller because the web paths will be incorrect otherwise.
		$phpbb_path_helper = $this->container->get('path_helper');
		$corrected_path = $this->path_helper->get_web_root_path();
		$image_path = ((defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? $board_url : $corrected_path) . 'images/ui/';
		if (!is_dir($image_path))
		{
			$this->recursive_mkdir($image_path, 0775);
		}

		$image_list = array();
		$image_count = 0;
		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($image_path, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS), \RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $file_info)
		{
			$file_path = $file_info->getPath();
			$image = $file_info->getFilename();

			// Match all images in the ui folder
			if (preg_match('#^[^&\'"<>]+\.(?:' . implode('|', $this->allowed_extensions) . ')$#i', $image) && is_file($file_path . '/' . $image))
			{
				if (function_exists('getimagesize'))
				{
					$dims = getimagesize($file_path . '/' . $image);
				}
				else
				{
					$dims = array(0, 0);
				}

				$cat = ($image_path == $file_path) ? $this->user->lang['NO_IMAGE_CATEGORY'] : str_replace("$image_path/", '', $file_path);
				$image_list[] = array(
					'file'      => ($cat != $this->user->lang['NO_IMAGE_CATEGORY']) ? rawurlencode(str_replace($this->root_path, '/' , $cat)) . '/' . rawurlencode($image) : rawurlencode($image),
					'filename'  => rawurlencode($image),
					'name'      => ucfirst(str_replace('_', ' ', preg_replace('#^(.*)\..*$#', '\1', $image))),
					'width'     => $dims[0],
					'height'    => $dims[1],
					'size'		=> filesize($file_path . '/' . $image),
				);
				$image_count++;
			}
		}
		rsort($image_list);

		$start = $this->request->variable('start', 0);
		$per_page = 10;
		$start = $this->pagination->validate_start($start, $per_page, $image_count);
		$base_url = $this->u_action;
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $image_count, $per_page, $start);

		for($i = $start; $i < $image_count && $i < $start + $per_page; $i++)
		{
			$this->template->assign_block_vars('image_list', array(
				'ID'		=> $i + 1,
				'PATH'		=> rawurldecode($image_list[$i]['file']),
				'FILENAME'	=> $image_list[$i]['filename'],
				'NAME'		=> $image_list[$i]['name'],
				'WIDTH'		=> $image_list[$i]['width'],
				'HEIGHT'	=> $image_list[$i]['height'],
				'SIZE'		=> get_formatted_filesize($image_list[$i]['size']),
				'DELLURL'	=> $this->u_action . '&amp;action=delete&amp;image_id=' . rawurldecode($image_list[$i]['file'])
				)
			);
		}

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'U_ACTION'		=> $this->u_action,
			'U_ADD_PAGE'	=> "{$this->u_action}&amp;action=add",
		));
	}

	/**
	* Details
	*
	* @access public
	*/
	public function details()
	{
		global $config, $phpbb_extension_manager;
		$this->user->add_lang(array('install', 'acp/extensions', 'migrator'));
		$ext_name = 'forumhulp/uploadimage';
		$md_manager = new \phpbb\extension\metadata_manager($ext_name, $config, $phpbb_extension_manager, $this->template, $this->user, $this->root_path);
		try
		{
			$this->metadata = $md_manager->get_metadata('all');
		}
		catch(\phpbb\extension\exception $e)
		{
			trigger_error($e, E_USER_WARNING);
		}

		$md_manager->output_template_data();

		try
		{
			$updates_available = $this->version_check($md_manager, $this->request->variable('versioncheck_force', false));

			$this->template->assign_vars(array(
				'S_UP_TO_DATE'		=> empty($updates_available),
				'S_VERSIONCHECK'	=> true,
				'UP_TO_DATE_MSG'	=> $this->user->lang(empty($updates_available) ? 'UP_TO_DATE' : 'NOT_UP_TO_DATE', $md_manager->get_metadata('display-name')),
			));

			foreach ($updates_available as $branch => $version_data)
			{
				$this->template->assign_block_vars('updates_available', $version_data);
			}
		}
		catch (\RuntimeException $e)
		{
			$this->template->assign_vars(array(
				'S_VERSIONCHECK_STATUS'			=> $e->getCode(),
				'VERSIONCHECK_FAIL_REASON'		=> ($e->getMessage() !== $this->user->lang('VERSIONCHECK_FAIL')) ? $e->getMessage() : '',
			));
		}

		$this->template->assign_vars(array(
			'U_BACK'				=> $this->u_action . '&amp;action=list',
		));
	}

	/**
	* Delete a image
	*
	* @param string $image_id The path identifier to delete
	* @return null
	* @access public
	*/
	public function delete_image($image_id)
	{
		// Delete the image
		@unlink($this->root_path . $image_id);

		// Log the action
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_IMAGE_DELETED_LOG', time(), array($image_id));

		// If AJAX was used, show user a result message
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'MESSAGE_TITLE'	=> $this->user->lang['INFORMATION'],
				'MESSAGE_TEXT'	=> $this->user->lang('ACP_IMAGE_DELETE_SUCCESS'),
				'REFRESH_DATA'	=> array(
					'time'	=> 3
				)
			));
		}
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}

	/**
	* Add image
	*
	* @return null
	* @access public
	*/
	function add_image()
	{
		$error = array();
		$this->attachment_data = array();

		$this->user->add_lang('posting');
		include($this->root_path . 'includes/functions_upload.' . $this->php_ext);
		$upload = new \fileupload();
		$upload->set_allowed_extensions(array('jpg', 'gif', 'jpeg', 'png'));
		$upload_dir = $this->root_path . 'images/ui/';

		$file = $upload->form_upload('fileupload');
		$file->clean_filename('real');
		$file->move_file(str_replace($this->root_path, '', $upload_dir), true, true);

		$download_url = $upload_dir . $file->realname;
		$new_entry = array(
			'attach_id'		=> rand(1, 9),
			'is_orphan'		=> 1,
			'real_filename'	=> $file->realname,
			'attach_comment'=> 'comment',
			'filesize'		=> $file->filesize,
		);

		$this->attachment_data = array_merge(array(0 => $new_entry), $this->attachment_data);
		if (isset($this->plupload) && $this->plupload->is_active())
		{
			$json_response = new \phpbb\json_response();
			// Send the client the attachment data to maintain state
			$json_response->send(array('data' => $this->attachment_data, 'download_url' => $download_url));
		}
	}

	/**
	 * @author Michal Nazarewicz (from the php manual)
	 * Creates all non-existant directories in a path
	 * @param $path - path to create
	 * @param $mode - CHMOD the new dir to these permissions
	 * @return bool
	 */
	function recursive_mkdir($path, $mode = false)
	{
		if (!$mode)
		{
			global $config;
			$mode = octdec($config['am_dir_perms']);
		}

		$dirs = explode('/', $path);
		$count = sizeof($dirs);
		$path = '.';
		for ($i = 0; $i < $count; $i++)
		{
			$path .= '/' . $dirs[$i];

			if (!is_dir($path))
			{
				@mkdir($path, $mode);
				@chmod($path, $mode);

				if (!is_dir($path))
				{
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Check the version and return the available updates.
	 *
	 * @param \phpbb\extension\metadata_manager $md_manager The metadata manager for the version to check.
	 * @param bool $force_update Ignores cached data. Defaults to false.
	 * @param bool $force_cache Force the use of the cache. Override $force_update.
	 * @return string
	 * @throws RuntimeException
	 */
	protected function version_check(\phpbb\extension\metadata_manager $md_manager, $force_update = false, $force_cache = false)
	{
		global $cache, $config, $user;
		$meta = $md_manager->get_metadata('all');

		if (!isset($meta['extra']['version-check']))
		{
			throw new \RuntimeException($user->lang('NO_VERSIONCHECK'), 1);
		}

		$version_check = $meta['extra']['version-check'];

		$version_helper = new \phpbb\version_helper($cache, $config, $user);
		$version_helper->set_current_version($meta['version']);
		$version_helper->set_file_location($version_check['host'], $version_check['directory'], $version_check['filename']);
		$version_helper->force_stability($config['extension_force_unstable'] ? 'unstable' : null);

		return $updates = $version_helper->get_suggested_updates($force_update, $force_cache);
	}
}
