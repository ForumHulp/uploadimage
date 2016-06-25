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
	'ACP_UPLOAD_IMAGE_TITLE'			=> 'Laadi pilte üles',
	'ACP_IMAGE_TITLE'					=> 'Laadi pilte üles',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN'	=> 'Laadi pilte üles laiendus lubab sul üles laadida pilte oma foorumi <i>images</i> kausta läbi AJP. %1$s kausta kasutatakse piltide jaoks, ning luuakse automaatselt kui lubatakse laiendus AJP "Kohanda" -> "Halda laiendusi" vahelehel.<br />
	Kopeeri pildi teekond lihtsalt vajutades ja kasuta seda kleepides kus iganes sa soovid näidata oma pilti.
	Kustutades pilte ole hoolikas, kuna pilte ei kontrollita enne kas pilt on kuskil veel kasutusel.',

	'IMAGE_LIST'						=> 'Nimekiri piltidest',
	'IMAGE_PATH'						=> 'Pildi teekond',
	'IMAGE_NAME'						=> 'Pildi-nimi',
	'FORMAT'							=> 'Formaat',
	'SIZE'								=> 'Suurus',
	'FOLDER_SIZE'						=> 'Foldersize',
	'IMG_FOLDER'						=> 'Folder images are uploaded',
	'ACP_IMAGE_COPY_PATH'				=> 'Copy image path',
	'IMAGE_DELETE'						=> 'Kustuta',
	'ACP_IMAGE_DELETE_CONFIRM' 			=> 'kindel et soovid kustutada pilti?',

	'ACP_IMAGE_DELETE_SUCCESS'			=> 'Pilt kustutatud',
	'ACP_IMAGE_DELETED_LOG'				=> '<strong>Pilt kustutatud</strong><br />» %1s',

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
