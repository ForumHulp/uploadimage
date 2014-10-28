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

	'ACP_IMAGE_DELETE_ERRORED'		=> 'Something went wrong',
	'ACP_IMAGE_DELETE_SUCCESS'		=> 'Image deleted',
	'ACP_IMAGE_DELETED_LOG'			=> '<strong>Image deleted</strong><br />» %1s',
));
