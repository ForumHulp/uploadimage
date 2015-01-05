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
	'ACP_UPLOAD_IMAGE_TITLE'				=> 'Bilduppladdning',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN'		=> 'Med Bilduppladdningen kan du ladda upp bilder till ditt forums bild-katalog (images). Bilderna sparas i underkatalogen ui som skapas automatiskt när detta tillägg aktiveras.<br />Kopiera bildsökvägen genom att klicka på den och klistra in den där du vill använda bilden. Var försiktig när du raderar bilder eftersom ingen kontroll genomförs om bilden fortfarande används.',

	'IMAGE_AVAILABLE'		=> 'Tillgängliga bilder',
	'IMAGE_LIST'			=> 'Bildlista',
	'IMAGE_PATH'			=> 'Bildsökväg',
	'IMAGE_NAME'			=> 'Bildnamn',
	'FORMAT'				=> 'Format',
	'SIZE'					=> 'Storlek',

	'IMAGE_DELETE'			=> 'Radera',
	'ACP_IMAGE_DELETE_CONFIRM' => 'är du säker på att du vill radera bilden?',
	'NO_IMAGE_CATEGORY'		=> 'Ingen kategori',
	'DEVELOPERS'			=> 'Utvecklare'

));
