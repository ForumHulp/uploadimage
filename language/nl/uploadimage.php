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
	'ACP_UPLOAD_IMAGE_TITLE'				=> 'Upload Images',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN'		=> 'Upload Images enables you to upload images in your images folder of your board. The ui folder is used for the images and is created automatically when enabling this extension.<br />Copy imagepath simply by clicking and use it wherever you want to show your image. Be careful with deleting images as there is no check if the image is still used.',

	'IMAGE_AVAILABLE'		=> 'Available images',
	'IMAGE_LIST'			=> 'Image list',
	'IMAGE_PATH'			=> 'Imagepath',
	'IMAGE_NAME'			=> 'Image-name',
	'FORMAT'				=> 'Format',
	'SIZE'					=> 'Size',

	'IMAGE_DELETE'			=> 'Delete',
	'ACP_IMAGE_DELETE_CONFIRM' => 'sure to delete image?',
	'NO_IMAGE_CATEGORY'		=> 'No category',
	'DEVELOPERS'			=> 'Developer(s)'

));
