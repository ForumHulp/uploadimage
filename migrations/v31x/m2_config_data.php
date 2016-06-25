<?php
/**
*
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\uploadimage\migrations\v31x;

/**
 * Migration stage 3: Config data
 */
class m2_config_data extends \phpbb\db\migration\migration
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
		return array('\forumhulp\uploadimage\migrations\v31x\m1_initial_module');
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
			array('config.add', array('uploadimage_folder', 'ui')),
		);
	}
}
