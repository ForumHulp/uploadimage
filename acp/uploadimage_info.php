<?php
/**
*
* @package Upload Image
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\uploadimage\acp;

class uploadimage_info
{
	function module()
	{
		return array(
			'filename'    => 'forumhulp\uploadimage\acp\uploadimage_module',
			'title'        => 'ACP_IMAGE_TITLE',
			'version'    => '1.0.0',
			'modes'        => array(
				'main'		=> array(
					'title'	=> 'ACP_IMAGE_TITLE',
					'auth'	=> 'ext_forumhulp/uploadimage && acl_a_styles',
					'cat'	=> array('ACP_IMAGE_MANAGEMENT')
				),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}
