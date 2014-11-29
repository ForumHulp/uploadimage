<?php
/**
*
* @package Upload Image
* @copyright (c) 2014 John Peskens (http://ForumHulp.com); Estonian translation by www.phpbbeesti.com (c) 11/2014
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_IMAGE_MANAGEMENT'			=> 'Laadi pilte üles',
	'ACP_IMAGE_TITLE'				=> 'Laadi pilte üles',
	'ACP_IMAGE_DELETE_ERRORED'		=> 'Midagi läks valesti',
	'ACP_IMAGE_DELETE_SUCCESS'		=> 'Pilt kustutatud',
	'ACP_IMAGE_DELETED_LOG'			=> '<strong>Pilt kustutatud</strong><br />» %1s',
));
