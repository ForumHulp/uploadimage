<?php
/**
*
* @package Upload Image
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\uploadimage\migrations\v31x;

/**
* Migration stage 1: Initial module
*/
class m1_initial_module extends \phpbb\db\migration\migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	/**
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_CUSTOMISE', 'ACP_IMAGE_MANAGEMENT')),
			array('module.add', array(
				'acp', 'ACP_IMAGE_MANAGEMENT', array(
					'module_basename'	=> '\forumhulp\uploadimage\acp\uploadimage_module',
					'modes'				=> array('main'),
				),
			)),
		);
	}
}
