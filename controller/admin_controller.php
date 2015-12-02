<?php
/**
*
* @package Upload Image
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\uploadimage\controller;

use Symfony\Component\DependencyInjection\Container;

/**
* Admin controller
*/
class admin_controller
{
	protected $u_action;

	protected $config;
	protected $request;
	protected $user;
	protected $phpbb_container;
	protected $template;
	protected $path_helper;
	protected $cache;
	protected $pagination;
	protected $log;
	protected $plupload;
	protected $root_path;
	protected $php_ext;

	protected $allowed_extensions = array(
		'gif',
		'jpg',
		'jpeg',
		'png',
	);

	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\request\request $request, \phpbb\user $user, Container $phpbb_container, \phpbb\template\template $template, \phpbb\path_helper $path_helper, \phpbb\cache\service $cache, \phpbb\pagination $pagination, \phpbb\log\log $log, \phpbb\plupload\plupload $plupload, $root_path, $php_ext)
	{
		$this->config = $config;
		$this->request = $request;
		$this->user = $user;
		$this->phpbb_container = $phpbb_container;
		$this->template = $template;
		$this->path_helper = $path_helper;
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
		$s_action = $this->u_action; // . '&action=add';
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
			'S_FORM_ENCTYPE_IU'			=> $form_enctype,
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
		$corrected_path = $this->path_helper->get_web_root_path();
		$image_path = ((defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? $board_url : $corrected_path) . 'images/ui/';
		if (!is_dir($image_path))
		{
			$this->recursive_mkdir($image_path, 0775);
		}

		$image_list = array();
		$image_count = $dir_size = 0;
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
				} else
				{
					$dims = array(0, 0);
				}

				$image_list[] = array(
					'path'      => $file_path,
					'filename'  => rawurlencode($image),
					'name'      => ucfirst(str_replace('_', ' ', preg_replace('#^(.*)\..*$#', '\1', $image))),
					'width'     => $dims[0],
					'height'    => $dims[1],
					'size'		=> filesize($file_path . '/' . $image),
				);
				$dir_size = $dir_size + filesize($file_path . '/' . $image);
				$image_count++;
			}
		}

		$search = $this->request->is_set_post('search') && $this->request->variable('keyword', '') ?  $this->request->variable('keyword', '') : false;
		$keywords = $this->request->variable('keywords', '');
		if ($search || $keywords)
		{
			$search = (!$search) ? $keywords : $search;
			$image_list = $this->searchForId($search, $image_list);
			$image_count = sizeof($image_list);
		}

		// sort keys, direction en sql
		$sort_key	= $this->request->variable('sk', 'n');
		$sort_dir	= $this->request->variable('sd', 'a');
		$sort_by_sql = array('s' => 'size', 'n' => 'name', 'f' => 'width');
		$sql_sort = $sort_by_sql[$sort_key];

		$this->template->assign_vars(array(
			'S_SORT_KEY'		=> $sort_key,
			'S_SORT_DIR'		=> $sort_dir
		));

		usort($image_list, function($a, $b) use ($sql_sort)
		{
			return $a[$sql_sort] - $b[$sql_sort];
		});

		$image_list = ($sort_dir != 'd') ? array_reverse($image_list) : $image_list;

		$start = $this->request->variable('start', 0);
		$per_page = 10;
		$start = $this->pagination->validate_start($start, $per_page, $image_count);
		$base_url = $this->u_action . '&amp;sk=' . $sort_key . '&amp;sd=' . $sort_dir . (($search) ? '&amp;keywords=' . $search: '');
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $image_count, $per_page, $start);

		for($i = $start; $i < $image_count && $i < $start + $per_page; $i++)
		{
			$this->template->assign_block_vars('image_list', array(
				'ID'		=> $i + 1,
				'PATH'		=> str_replace('../', '', $image_list[$i]['path']) . '/' . $image_list[$i]['filename'],
				'IMAGEPATH'	=> $image_list[$i]['path'] . '/' . $image_list[$i]['filename'],
				'FILENAME'	=> $image_list[$i]['filename'],
				'NAME'		=> $image_list[$i]['name'],
				'WIDTH'		=> $image_list[$i]['width'],
				'HEIGHT'	=> $image_list[$i]['height'],
				'SIZE'		=> get_formatted_filesize($image_list[$i]['size']),
				'DELLURL'	=> $this->u_action . '&amp;action=delete&amp;image_id=' . rawurldecode($image_list[$i]['filename'])
				)
			);
		}

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'U_ACTION'		=> $this->u_action,
			'DIR_SIZE'		=> get_formatted_filesize($dir_size),
			'KEYWORD'		=> $search,
			'U_ADD_PAGE'	=> $this->u_action . '&amp;action=add',
		));
	}

	function searchForId($id, $array)
	{
		foreach ($array as $key => $val)
		{
			if (strpos($val['filename'], $id) === false)
			{
				unset($array[$key]);
			}
		}
		return $array;
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
		@unlink($this->root_path . 'images/ui/' . $image_id);

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

		if (version_compare($this->config['version'], '3.2.*', '<'))
		{
			include($this->root_path . 'includes/functions_upload.' . $this->php_ext);
			$upload = new \fileupload();
			$upload->set_allowed_extensions($this->allowed_extensions);
		} else
		{
			$upload = $this->phpbb_container->get('files.factory')->get('upload')
				->set_error_prefix('AVATAR_')
				->set_allowed_extensions($this->allowed_extensions)
				->set_max_filesize(0)
				->set_allowed_dimensions(0,0,0,0)
				->set_disallowed_content((isset($this->config['mime_triggers']) ? explode('|', $this->config['mime_triggers']) : false));
		}

		$this->user->add_lang('posting');
		$upload_dir = $this->root_path . 'images/ui/';

		$file = (version_compare($this->config['version'], '3.2.*', '<')) ? $upload->form_upload('fileupload') : $upload->handle_upload('files.types.form', 'fileupload');
		$file->clean_filename('real');
		$file->move_file(str_replace($this->root_path, '', $upload_dir), true, true, 0775);

		$download_url = $upload_dir . $file->get('realname');
		$new_entry = array(
			'attach_id'		=> rand(1000,10000),
			'is_orphan'		=> 1,
			'real_filename'	=> $file->get('realname'),
			'filesize'		=> $file->get('filesize'),
		);

		$this->attachment_data = array_merge(array($new_entry['attach_id'] => $new_entry), $this->attachment_data);
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
			$mode = 0755;
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
}
