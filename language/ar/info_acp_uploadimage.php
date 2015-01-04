<?php
/**
*
* @package Upload Image
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
* Translated By : Basil Taha Alhitary - www.alhitary.net
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
	'ACP_IMAGE_MANAGEMENT'			=> 'رفع الصور',
	'ACP_IMAGE_TITLE'				=> 'رفع الصور',

	'ACP_IMAGE_DELETE_ERRORED'		=> 'يوجد خطأ',
	'ACP_IMAGE_DELETE_SUCCESS'		=> 'تم حذف الصورة',
	'ACP_IMAGE_DELETED_LOG'			=> '<strong>تم حذف الصورة</strong><br />» %1s',
));
