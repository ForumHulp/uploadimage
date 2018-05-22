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
	'ACP_UPLOAD_IMAGE_TITLE'			=> 'Upload Images',
	'ACP_IMAGE_TITLE'					=> 'Upload Image',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN'	=> 'Upload Images enables you to upload images in your images folder of your board. The %1$s folder is used for the images and is created automatically when enabling this extension.<br />Copy imagepath simply by clicking and use it wherever you want to show your image. Be careful with deleting images as there is no check if the image is still used.',

	'IMAGE_LIST'						=> 'Image map',
	'IMAGE_PATH'						=> 'Imagepath',
	'IMAGE_NAME'						=> 'Image-name',
	'FORMAT'							=> 'Format',
	'SIZE'								=> 'Size',
	'FOLDER_SIZE'						=> 'Foldersize',
	'IMG_FOLDER'						=> 'Change image folder where images are uploaded',
	'ACP_IMAGE_COPY_PATH'				=> 'Copy image path',
	'IMAGE_DELETE'						=> 'Delete',
	'ACP_IMAGE_DELETE_CONFIRM' 			=> 'Sure to delete image?',

	'ACP_IMAGE_DELETE_SUCCESS'			=> 'Image deleted',
	'ACP_IMAGE_DELETED_LOG'				=> '<strong>Image deleted</strong><br />» %1s',

	'UPLOADIMAGE_NOTICE'				=> '<div class="phpinfo"><p class="entry">This extension resides in %1$s » %2$s » %3$s.<br />Upload images of a size you want to use!</p></div>',
	'FH_HELPER_NOTICE'					=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
));

// Description of extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'		=> 'Preview of images',
			'DESCRIPTION_2'		=> 'Upload up to 10 images',
			'DESCRIPTION_3'		=> 'Image information',
			'DESCRIPTION_4'		=> 'Easy path copying',
		),
		'note' => array(
			'NOTICE_1'			=> 'Free formatsize',
			'NOTICE_2'			=> '3.2 ready.',
		)
	)
));
