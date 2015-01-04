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
	'ACP_UPLOAD_IMAGE_TITLE'				=> 'رفع الصور',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN'		=> 'هذه الإضافة تعطيك امكانية رفع الصور إلى مجلد الصور في منتداك. سيتم انشاء مجلد بإسم ui تلقائياً عند تفعيل هذه الإضافة وسيحتوي على جميع الصور التي تريد رفعها. <br />تستطيع عرض الصور في المنتدى بواسطة نسخ رابط الصورة بسهولة عند النقر على الرابط. <br />يجب عليك أخذ الحيطة عند حذف الصور لأنه لا يُمكن التأكد من استمرارية استخدام الصورة أو لا.',

	'IMAGE_AVAILABLE'		=> 'الصور المتوفرة',
	'IMAGE_LIST'			=> 'قائمة الصور',
	'IMAGE_PATH'			=> 'رابط الصورة',
	'IMAGE_NAME'			=> 'اسم الصورة',
	'FORMAT'				=> 'الأبعاد',
	'SIZE'					=> 'الحجم',

	'IMAGE_DELETE'			=> 'حذف',
	'ACP_IMAGE_DELETE_CONFIRM' => 'هل أنت متأكد من حذف الصورة ?',
	'NO_IMAGE_CATEGORY'		=> 'الفئة غير موجودة',
	'DEVELOPERS'			=> 'المطور/ ين '

));
