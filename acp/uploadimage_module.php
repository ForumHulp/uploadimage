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
		global $cache, $phpbb_container, $request, $user;

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

		// Perform any actions submitted by the user
		switch($action)
		{
			case 'add':
				// Add image handle in the admin controller
				$admin_controller->add_image();
				return;
			break;

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
				// Load the extension detail page
				$this->tpl_name = 'acp_ext_details';
				$admin_controller->details();
				return;
			break;

			default:
				// Display images
				$admin_controller->display_images();
		}
	}
}
