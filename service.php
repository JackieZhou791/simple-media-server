<?php

define('DS', DIRECTORY_SEPARATOR);
define('MEDIA_AUTH_KEY', '0123456789');

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

	$filename= date('Y').date('m').date('d').date('H').date('i').date('s').rand(100,999).'.'.$ext;
	$uploadfile = $uploadPath . $filename;

	if(!is_dir(dirname($uploadPath))) {
		 @mkdir($uploadPath, 0777, true);
	}

	if(move_uploaded_file($_FILES['images']['tmp_name'], $uploadfile))
	{
		if(!is_dir($thumbPath)) {
			@mkdir($thumbPath, 0777, true);
		}

		$thumbfile = $thumbPath . $filename;
		$img = Image::make($uploadfile);

		$img->fit(200,200, function ($constraint) {
                $constraint->upsize();
            });
		$img->save($thumbfile);
		//Logic to do the image resize/path/etc.

		$arr['status'] = '1';
		$arr['url'] = $baseMedialUrl . $baseMedialPath . $filename;
		$arr['thumb'] = $baseMedialUrl . $baseMedialPath . 'thumbnails/'. $filename;
		echo json_encode($arr);
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

