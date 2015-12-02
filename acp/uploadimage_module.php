<?php
/**
*
* @package Upload Image
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\uploadimage\acp;

class uploadimage_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container, $request, $user;

		// Add the ACP lang file
		$user->add_lang_ext('forumhulp/uploadimage', 'uploadimage');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('forumhulp.uploadimage.admin.controller');

		// Requests
		$action = $request->variable('action', '');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'acp_uploadimage';

		// Set the page title for our ACP page
		$this->page_title = $user->lang('ACP_UPLOAD_IMAGE_TITLE');

		if ($request->is_set_post('delete_file'))
		{
			$index =  $request->variable('delete_file', array(0 => 0));

			$files =  $request->variable('attachment_data', array(0 => array('' => '')), true, \phpbb\request\request_interface::POST);
			$file = $files[key($index)];
			$admin_controller->delete_image($file['real_filename']);

			exit();
			$action = '';
		}

		if ($request->is_set_post('add_file'))
		{
			$admin_controller->add_image();
			exit();
		}

		// Perform any actions submitted by the user
		switch($action)
		{
			case 'delete':
				// Use a confirm box routine when deleting a image
				if (confirm_box(true))
				{
					// Delete image on confirmation from the user
					$admin_controller->delete_image($request->variable('image_id', ''));
					$admin_controller->display_images();
				}
				else
				{
					// Request confirmation from the user to delete the page
					confirm_box(false, $user->lang('ACP_IMAGE_DELETE_CONFIRM'), build_hidden_fields(array(
						'page_id'	=> $request->variable('image_id', ''),
						'mode'		=> $mode,
						'action'	=> $action,
					)));
				}
			break;

			case 'details':
				$user->add_lang_ext('forumhulp/uploadimage', 'info_acp_uploadimage');
				$this->tpl_name = 'acp_ext_details';
				$phpbb_container->get('forumhulp.helper')->detail('forumhulp/uploadimage');
				return;
			break;

			default:
				// Display images
				$admin_controller->display_images();
		}
	}
}
