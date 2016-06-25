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
	'ACP_UPLOAD_IMAGE_TITLE'			=> 'Bilduppladdning',
	'ACP_IMAGE_TITLE'					=> 'Ladda upp en bild',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN'	=> 'Med Bilduppladdningen kan du ladda upp bilder till ditt forums bild-katalog (images). Bilderna sparas i underkatalogen %1$s som skapas automatiskt när detta tillägg aktiveras.<br />Kopiera bildsökvägen genom att klicka på den och klistra in den där du vill använda bilden. Var försiktig när du raderar bilder eftersom ingen kontroll genomförs om bilden fortfarande används.',

	'IMAGE_LIST'						=> 'Bildlista',
	'IMAGE_PATH'						=> 'Bildsökväg',
	'IMAGE_NAME'						=> 'Bildnamn',
	'FORMAT'							=> 'Format',
	'SIZE'								=> 'Storlek',
	'FOLDER_SIZE'						=> 'Foldersize',
	'IMG_FOLDER'						=> 'Folder images are uploaded',
	'ACP_IMAGE_COPY_PATH'				=> 'Copy image path',
	'IMAGE_DELETE'						=> 'Radera',
	'ACP_IMAGE_DELETE_CONFIRM'			=> 'är du säker på att du vill radera bilden?',

	'ACP_IMAGE_DELETE_SUCCESS'			=> 'Bilden laddades upp',
	'ACP_IMAGE_DELETED_LOG'				=> '<strong>Bilden raderad</strong><br />Â» %1s',

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
			'DESCRIPTION_2'		=> 'Upload up to 10 images ',
			'DESCRIPTION_3'		=> 'Image information',
			'DESCRIPTION_4'		=> 'Easy path copying',
		),
		'note' => array(
			'NOTICE_1'			=> 'Free formatsize',
			'NOTICE_2'			=> '3.2 ready.',
		)
	)
));
