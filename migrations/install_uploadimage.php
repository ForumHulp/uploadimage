<?php
/**
*
* @package Upload Image
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\uploadimage\migrations;

class install_uploadimage extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['uploadimage_version']) && version_compare($this->config['uploadimage_version'], '3.1.0.RC5', '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('uploadimage_version', '3.1.0.RC5')),
			array('module.add', array('acp', 'ACP_CAT_CUSTOMISE', 'ACP_IMAGE_MANAGEMENT')),
			array('module.add', array(
				'acp', 'ACP_IMAGE_MANAGEMENT', array(
					'module_basename'	=> '\forumhulp\uploadimage\acp\uploadimage_module',
					'auth'				=> 'ext_forumhulp/uploadimage && acl_a_styles',
					'modes'				=> array('main'),
				),
			)),
		);
	}
}
