<?php
define('DS', DIRECTORY_SEPARATOR);
define('BP', dirname(__FILE__). DS);
define('DEFAULT_PATH', BP . DS . 'public' . DS . 'attachment' . DS);

// include composer autoload
require 'vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;

function getParam($param, $split_uri = array()) {
    $pos = array_search($param, $split_uri);
    if ($pos && isset($split_uri[$pos + 1])) {
        return $split_uri[$pos + 1];
    }
    return null;
}

function getPlaceholder($attr)
{
    $placeholder =  'public/placeholder/'.$attr.'.jpg';
    return $placeholder;
}

$request_uri = $_SERVER['REQUEST_URI'];
$split_uri = explode('/',$request_uri);

try {

    $new_file = BP . $request_uri;
    
    if (file_exists($new_file)) {
        echo  Image::make($new_file)->response('jpg');
    } else {
        $imageName = $split_uri[4];

        $_file = DEFAULT_PATH . $imageName;

        $img = Image::make($_file);

        list($width, $height) = explode('x', $split_uri[3]);
        if ($width) {
            $img->resize($width,  $height);
        }

        $new_file =  BP . $request_uri;

        if(!is_dir(dirname($new_file))) {
            @mkdir(dirname( $new_file), 0777, true);
        }
        
        if (!file_exists($new_file) || !@imagecreatefromjpeg($new_file)) {
            $img->save($new_file);
        }
        echo Image::make($new_file)->response('jpg');
    }
    exit();
} catch (Exception $e) {
    print_r($e->getMessage());die();
    $url = 'http://media.local.ve.cn/' . getPlaceholder('ve');
    header("Location: " . $url, TRUE, 302);
}
exit;
