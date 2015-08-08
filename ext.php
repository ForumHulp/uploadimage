<?php
/**
*
* @package Upload Image
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\uploadimage;

class ext extends \phpbb\extension\base
{
	/**
	 * Overwrite enable_step to enable Badge Award notifications
	 * before any included migrations are installed.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	public function enable_step($old_state)
	{
		if (empty($old_state))
		{
			global $user;
			$user->add_lang_ext('forumhulp/uploadimage', 'info_acp_uploadimage');
			$user->lang['EXTENSION_ENABLE_SUCCESS'] .= (isset($user->lang['UPLOADIMAGE_NOTICE']) ? sprintf($user->lang['UPLOADIMAGE_NOTICE'], $user->lang['ACP_CAT_CUSTOMISE'], $user->lang['ACP_IMAGE_MANAGEMENT'], $user->lang['ACP_IMAGE_TITLE']) : '');
		}
		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
