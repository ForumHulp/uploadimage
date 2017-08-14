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
	'ACP_UPLOAD_IMAGE_TITLE'			=> 'Subir Imágenes',
	'ACP_IMAGE_TITLE'					=> 'Subir Imagen',
	'ACP_UPLOAD_IMAGE_TITLE_EXPLAIN'	=> 'Subir Imágenes le permite la subida de imágenes en su carpeta de imágenes en su foro. La carpeta %1$s se utiliza para las imágenes, y se crea automáticamente al habilitar esta extensión.<br />Copie la ruta de la imagen simplemente haciendo clic, y utilícelo donde quiera mostrar su imagen. Tenga cuidado con el borrado de imágenes, ya que no hay comprobación de si la imagen todavía se utiliza.',

	'IMAGE_LIST'						=> 'Carpeta de la imagen',
	'IMAGE_PATH'						=> 'Ruta de la imagen',
	'IMAGE_NAME'						=> 'Nombre de la imagen',
	'FORMAT'							=> 'Formato',
	'SIZE'								=> 'Tamaño',
	'FOLDER_SIZE'						=> 'Tamaño de la carpeta',
	'IMG_FOLDER'						=> 'Cambiar la carpeta de imágenes donde se suben las imágenes',
	'ACP_IMAGE_COPY_PATH'				=> 'Copiar ruta de la imagen',
	'IMAGE_DELETE'						=> 'Borrar',
	'ACP_IMAGE_DELETE_CONFIRM' 			=> '¿Seguro que desea eliminar la imagen?',

	'ACP_IMAGE_DELETE_SUCCESS'			=> 'Imagen borrada',
	'ACP_IMAGE_DELETED_LOG'				=> '<strong>Imagen borrada</strong><br />» %1s',

	'UPLOADIMAGE_NOTICE'				=> '<div class="phpinfo"><p class="entry">Está extensión reside en %1$s » %2$s » %3$s.<br />¡Suba imágenes del tamaño que quiera usar!</p></div>',
	'FH_HELPER_NOTICE'					=> '¡La aplicación Forumhulp helper no existe!<br />Descargar <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> y copie la carpeta helper dentro de la carpeta de extensión forumhulp.',
));

// Description of extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Descripción',
	'DESCRIPTION_NOTICE'	=> 'Nota de la extensión',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'		=> 'Vista previa de imágenes',
			'DESCRIPTION_2'		=> 'Subir hasta 10 imágenes',
			'DESCRIPTION_3'		=> 'Información de la imagen',
			'DESCRIPTION_4'		=> 'Copia de ruta fácil',
		),
		'note' => array(
			'NOTICE_1'			=> 'Tamaño de formato libre',
			'NOTICE_2'			=> 'Preparado para 3.2',
		)
	)
));
