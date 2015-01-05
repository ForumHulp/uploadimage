<?php
/**
*
* @package Upload Image
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* Swedish translation by Holger (http://www.maskinisten.net)
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_IMAGE_MANAGEMENT'			=> 'Bilduppladdning',
	'ACP_IMAGE_TITLE'				=> 'Ladda upp en bild',

	'ACP_IMAGE_DELETE_ERRORED'		=> 'Något blev fel',
	'ACP_IMAGE_DELETE_SUCCESS'		=> 'Bilden laddades upp',
	'ACP_IMAGE_DELETED_LOG'			=> '<strong>Bilden raderad</strong><br />Â» %1s',
));
