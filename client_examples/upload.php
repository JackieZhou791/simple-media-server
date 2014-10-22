<?php
define('MEDIA_AUTH_KEY', '0123456789');
require 'Curl.php';

use \Curl\Curl;
?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Photo Upload</title>
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//upload photo
	$curl = new Curl();

	$upload_url = 'http://media.local.ve.cn/service.php';
	$photo_data['media_auth_key'] = MEDIA_AUTH_KEY;

	$result = array();
	foreach($_FILES['photo']['tmp_name'] as $k=>$tmpname) {

		$photo_data['key'] = $k;
		$photo_data['photo'] = '@' . $_FILES['photo']['tmp_name'][$k];
		$photo_data['filename'] = $_FILES['photo']['name'][$k];
		$result[] = $curl->post($upload_url,  $photo_data);
	}

	var_dump($result);
}
?>
<form enctype="multipart/form-data" method="post">
<fieldset>
<legend>Photo Upload</legend>
<label>Photo1 <input name="photo[]" type="file" /></label><br />
<label>Photo2 <input name="photo[]" type="file" /></label><br />
<label>Photo3 <input name="photo[]" type="file" /></label><br />
<label>Title <input name="title" placeholder="Vacation (optional)" type="text" /></label><br />
<label>Tags <input name="tags" placeholder="tropical,beach,vacation (optional)" type="text" /></label><br />
<input type="submit" />
</fieldset>
</form>
</body>
</html>