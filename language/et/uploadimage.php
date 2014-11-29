<?php
/**
*
* @package Upload Image
* @copyright (c) 2014 John Peskens (http://ForumHulp.com); Estonian translation by www.phpbbeesti.com 11/2014
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
	'ACP_UPLOAD_IMAGE_TITLE'				=> 'Laadi pilte üles',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN'		=> 'Laadi pilte üles laiendus lubab sul üles laadida pilte oma foorumi <i>images</i> kausta läbi AJP. UI kausta kasutatakse piltide jaoks, ning luuakse automaatselt kui lubatakse laiendus AJP "Kohanda" -> "Halda laiendusi" vahelehel.<br />
	Kopeeri pildi teekond lihtsalt vajutades ja kasuta seda kleepides kus iganes sa soovid näidata oma pilti.
	Kustutades pilte ole hoolikas, kuna pilte ei kontrollita enne kas pilt on kuskil veel kasutusel.',
	'IMAGE_AVAILABLE'		=> 'Saadaval pildid',
	'IMAGE_LIST'			=> 'Nimekiri piltidest',
	'IMAGE_PATH'			=> 'Pildi teekond',
	'IMAGE_NAME'			=> 'Pildi-nimi',
	'FORMAT'				=> 'Formaat',
	'SIZE'					=> 'Suurus',
	'IMAGE_DELETE'			=> 'Kustuta',
	'ACP_IMAGE_DELETE_CONFIRM' => 'kindel et soovid kustutada pilti?',
	'NO_IMAGE_CATEGORY'		=> 'Pole ühtegi kategooriat',
	'DEVELOPERS'			=> 'Arendaja(d)'
));
