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
	'ACP_IMAGE_MANAGEMENT'			=> 'Carica immagine',
	'ACP_IMAGE_TITLE'				=> 'Carica immagine',
	'UPLOADIMAGE_NOTICE'			=> '<div style="width:80%%;margin:20px auto;"><p style="text-align:left;">This extension resides in %1$s » %2$s » %3$s.<br />Upload images of a size you want to use!</p></div>',
	'ACP_IMAGE_DELETE_ERRORED'		=> 'Errore',
	'ACP_IMAGE_DELETE_SUCCESS'		=> 'Immagine rimossa',
	'ACP_IMAGE_DELETED_LOG'			=> '<strong>Immagine rimossa</strong><br />» %1s',
));
