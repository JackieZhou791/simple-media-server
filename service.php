<?php

define('DS', DIRECTORY_SEPARATOR);
define('MEDIA_AUTH_KEY', '0123456789');

require 'encrypt.php';

// include composer autoload
require 'vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;
$key = isset($_POST['key']) ? addslashes($_POST['key']) : '';
$mediaAuthKey = isset($_POST['media_auth_key']) ? addslashes($_POST['media_auth_key']) : '';
$origName = isset($_POST['origname']) ? addslashes($_POST['origname']) : '';
if($mediaAuthKey != MEDIA_AUTH_KEY ) {
	echo '400';
	exit();
} 

$uploadPath = dirname(__FILE__) . DS . 'public' . DS . 'attachment' . DS . date('Y',time()) . date('m',time()) . DS.date('d',time()) . DS. date('H',time()) . DS;
$thumbPath = $uploadPath . 'thumbnails' . DS;
$baseMedialUrl = 'http://media.local.ve.cn';
$baseMedialPath = '/public/attachment/' . date('Y',time()) . date('m',time()) . '/'.date('d',time()) . '/'. date('H',time()) . '/';

//Save image from post data
if($_FILES['images']['tmp_name'])
{
	$ext = pathinfo($origName, PATHINFO_EXTENSION);

	$filename= date('Y').date('m').date('d').date('H').date('i').date('s').rand(100,999);
	$uploadfile = $uploadPath . $filename .'.'.$ext;

	if(!is_dir($uploadPath)) {
		if(!@mkdir($uploadPath, 0777, true)) {
			echo '401';
			exit();
		}
	}

	if(@move_uploaded_file($_FILES['images']['tmp_name'], $uploadfile))
	{

		$arr['status'] = '1';
		$arr['url'] = $baseMedialUrl . $baseMedialPath . $filename . '.' . $ext;
		$arr['thumb'] = $baseMedialUrl . $baseMedialPath . ve_encrypt($filename . '_200_200.') . '.' . $ext;
		echo json_encode($arr);
		exit();
	}

	echo '402';
	exit();
}
else
{
	echo '403';
	exit(); 
}

