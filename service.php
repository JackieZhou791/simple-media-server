<?php
define('DS', DIRECTORY_SEPARATOR);
define('MEDIA_AUTH_KEY', '0123456789');

// include composer autoload
require 'vendor/autoload.php';
use Intervention\Image\ImageManager;

// create an image manager instance with favored driver
$manager = new ImageManager(array('driver' => 'gd'));

$key = isset($_POST['key']) ? addslashes($_POST['key']) : '';
$filename = isset($_POST['filename']) ? addslashes($_POST['filename']) : '';
$mediaAuthKey = isset($_POST['media_auth_key']) ? addslashes($_POST['media_auth_key']) : '';
if($mediaAuthKey != MEDIA_AUTH_KEY ) {
	echo '400';
	exit();
} 

$uploadPath = dirname(__FILE__) . DS . 'public' . DS . 'attachment' . DS;

//Save image from post data
if($_FILES['photo']['tmp_name'])
{
	$uploadfile = $uploadPath . $filename;
	if(move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile))
	{
		//Logic to do the image resize/path/etc.
		echo $uploadfile;
		exit();
	}

	echo '401';
	exit();
}
else
{
	echo '402';
	exit(); 
}

