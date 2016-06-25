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
	'ACP_UPLOAD_IMAGE_TITLE'			=> 'Carica immagine',
	'ACP_IMAGE_TITLE'					=> 'Carica immagine',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN'	=> 'Carica immagine permette di caricare immagini nell\'apposita cartella del proprio sito. La cartella <em>%1$s</em> è la destinazione delle immagini caricate e viene creata automaticamente all\'installazione di quest\'estensione.<br />Il percorso dell\'immagine può essere copiato con un click per essere usato dove serve. Attenzione: nel momento in cui un\'immagine viene rimossa, non viene effettuato un controllo sull\'uso dell\'immagine.',

	'IMAGE_LIST'					=> 'Elenco immagini',
	'IMAGE_PATH'					=> 'Percorso immagine',
	'IMAGE_NAME'					=> 'Nome immagine',
	'FORMAT'						=> 'Formato',
	'SIZE'							=> 'Dimensioni',
	'FOLDER_SIZE'					=> 'Foldersize',
	'IMG_FOLDER'					=> 'Folder images are uploaded',
	'ACP_IMAGE_COPY_PATH'			=> 'Copy image path',
	'IMAGE_DELETE'					=> 'Rimuovi',
	'ACP_IMAGE_DELETE_CONFIRM' 		=> 'Sei sicuro di voler rimuovere l\'immagine?',

	'ACP_IMAGE_DELETE_SUCCESS'		=> 'Immagine rimossa',
	'ACP_IMAGE_DELETED_LOG'			=> '<strong>Immagine rimossa</strong><br />» %1s',


	'UPLOADIMAGE_NOTICE'			=> '<div class="phpinfo"><p class="entry">This extension resides in %1$s » %2$s » %3$s.<br />Upload images of a size you want to use!</p></div>',
	'FH_HELPER_NOTICE'				=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
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
