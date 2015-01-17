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
	'ACP_UPLOAD_IMAGE_TITLE'				=> 'Carica immagine',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN'		=> 'Carica immagine permette di caricare immagini nell\'apposita cartella del proprio sito. La cartella <em>ui</em> è la destinazione delle immagini caricate e viene creata automaticamente all\'installazione di quest\'estensione.<br />Il percorso dell\'immagine può essere copiato con un click per essere usato dove serve. Attenzione: nel momento in cui un\'immagine viene rimossa, non viene effettuato un controllo sull\'uso dell\'immagine.',

	'IMAGE_AVAILABLE'		=> 'Immagini disponibili',
	'IMAGE_LIST'			=> 'Elenco immagini',
	'IMAGE_PATH'			=> 'Percorso immagine',
	'IMAGE_NAME'			=> 'Nome immagine',
	'FORMAT'				=> 'Formato',
	'SIZE'					=> 'Dimensioni',

	'IMAGE_DELETE'			=> 'Rimuovi',
	'ACP_IMAGE_DELETE_CONFIRM' => 'Sei sicuro di voler rimuovere l\'immagine?',
	'NO_IMAGE_CATEGORY'		=> 'Nessuna categoria',
	'DEVELOPERS'			=> 'Sviluppatori'

));
