<?php
/**
*
* @package Upload Image
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
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
	'ACP_IMAGE_MANAGEMENT'			=> 'Upload Images',
	'ACP_IMAGE_TITLE'				=> 'Upload Image',
	'UPLOADIMAGE_NOTICE'			=> '<div style="width:80%%;margin:20px auto;"><p style="text-align:left;">Deze extensie vindt je in %1$s » %2$s » %3$s.<br />Upload alleen  images met een formaat wat je op je website wilt laten zien!</p></div>',
	'ACP_IMAGE_DELETE_ERRORED'		=> 'Something went wrong',
	'ACP_IMAGE_DELETE_SUCCESS'		=> 'Image deleted',
	'ACP_IMAGE_DELETED_LOG'			=> '<strong>Image deleted</strong><br />» %1s',
));
