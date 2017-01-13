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
	'FOLDER_SIZE'						=> 'Katalogstorlek',
	'IMG_FOLDER'						=> 'Katalogbilder har laddats upp',
	'ACP_IMAGE_COPY_PATH'				=> 'Kopiera bildens sökväg',
	'IMAGE_DELETE'						=> 'Radera',
	'ACP_IMAGE_DELETE_CONFIRM'			=> 'är du säker på att du vill radera bilden?',

	'ACP_IMAGE_DELETE_SUCCESS'			=> 'Bilden laddades upp',
	'ACP_IMAGE_DELETED_LOG'				=> '<strong>Bilden raderad</strong><br />Â» %1s',

	'UPLOADIMAGE_NOTICE'				=> '<div class="phpinfo"><p class="entry">Detta tillägg ligger i %1$s » %2$s » %3$s.<br />Ladda upp bilder med den storlek som du behöver!</p></div>',
	'FH_HELPER_NOTICE'					=> 'Applicationen Forumhulp helper existerar ej!<br />Ladda ner <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> och kopiera helper-katalogen till din forumhulp-katalog.',
	));

// Description of extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Beskrivning',
	'DESCRIPTION_NOTICE'	=> 'Notis rörande tillägget',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'		=> 'Förhandsgranskning av bilder',
			'DESCRIPTION_2'		=> 'Ladda upp upp till 10 bilder',
			'DESCRIPTION_3'		=> 'Bildinformation',
			'DESCRIPTION_4'		=> 'Enkel kopiering av sökvägen',
		),
		'note' => array(
			'NOTICE_1'			=> 'Fri formatstorlek',
			'NOTICE_2'			=> 'Redo för 3.2.',
		)
	)
));
