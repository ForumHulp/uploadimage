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
use phpbb\config\config;
use phpbb\request\request;
use phpbb\user;
use phpbb\template\template;
use phpbb\path_helper;
use phpbb\cache\service;
use phpbb\pagination;
use phpbb\log\log;
use phpbb\plupload\plupload;

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
	protected $allowed_extensions = array('gif', 'jpg', 'jpeg', 'png');

	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(config $config, request $request, user $user, Container $phpbb_container, template $template, path_helper $path_helper, service $cache, pagination $pagination, log $log, plupload $plupload, $root_path, $php_ext)
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
	*/
	public function display_images()
	{
		$error = $attachment_data = array();
		$this->user->add_lang('posting');
		$s_action = $this->u_action;
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
				case 'm':
					$max_filesize *= 1024;
				case 'k':
					$max_filesize *= 1024;
			}
		}
		add_form_key('postform');

		$this->template->assign_vars(array(
			'ERROR'						=> (sizeof($error)) ? implode('<br />', $error) : '',
			'S_FORM_ENCTYPE_IU'			=> $form_enctype,
			'S_POST_ACTION'				=> $s_action,
			'FILESIZE'					=> $max_filesize,
			'IMG_FOLDER'				=> $this->config['uploadimage_folder'],
			'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN' => $this->user->lang('ACP_UPLOAD_IMAGE_TITLE_EXPLAIN', $this->config['uploadimage_folder']),
			'S_ATTACH_DATA'				=> json_encode(array()),
		));

		if ($form_enctype)
		{
			$this->plupload->configure($this->cache, $this->template, $s_action, 0, 10);
		}

		// Determine board url - we may need it later
		$board_url = generate_board_url() . '/';
		$corrected_path = $this->path_helper->get_web_root_path();
		$image_path = ((defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? $board_url : $corrected_path) . 'images/' . $this->config['uploadimage_folder'] . '/';
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

		uksort($image_list, function($a, $b) use ($sql_sort)
		{
			return $a[$sql_sort] - $b[$sql_sort];
		});

		$image_list = ($sort_dir != 'd') ? array_reverse($image_list) : $image_list;

		$start = $this->request->variable('start', 0);
		$per_page = 10;
		$start = $this->pagination->validate_start($start, $per_page, $image_count);
		$base_url = $this->u_action . '&amp;sk=' . $sort_key . '&amp;sd=' . $sort_dir . (($search) ? '&amp;keywords=' . $search: '');
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $image_count, $per_page, $start);

		for ($i = $start; $i < $image_count && $i < $start + $per_page; $i++)
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
	* Rename image folder
	*
	*/
	public function rename_folder()
	{
		$uploadimage_folder = $this->request->variable('img_folder', 'ui');
		if (strpbrk($uploadimage_folder, "\\/?%*:|\"<>") === false)
		{
			rename ($this->root_path . 'images/' . $this->config['uploadimage_folder'], $this->root_path . 'images/' . $uploadimage_folder);
			chmod($this->root_path . 'images/' . $uploadimage_folder, 0775);
			$this->config->set('uploadimage_folder', $uploadimage_folder);
		}
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
		@unlink($this->root_path . 'images/' . $this->config['uploadimage_folder'] . '/' . $image_id);
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
		$upload_dir = $this->root_path . 'images/' . $this->config['uploadimage_folder'] . '/';

		$file = (version_compare($this->config['version'], '3.2.*', '<')) ? $upload->form_upload('fileupload') : $upload->handle_upload('files.types.form', 'fileupload');
		$file->clean_filename('real');
		$file->move_file(str_replace($this->root_path, '', $upload_dir), true, true, 0775);
	//	chmod($upload_dir . $file->get('realname'), 0775);

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
