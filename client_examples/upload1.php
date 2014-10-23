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

	$photo_data['images'] = '@' . $_FILES['images']['tmp_name'];
	$photo_data['origname'] = $_FILES['images']['name'];
	$result = $curl->post($upload_url,  $photo_data);
	echo $result;
}
?>
<form enctype="multipart/form-data" method="post">
<fieldset>
<legend>Photo Upload</legend>
<label>Photo1 <input name="images" type="file" /></label><br />
<label>Title <input name="title" placeholder="Vacation (optional)" type="text" /></label><br />
<label>Tags <input name="tags" placeholder="tropical,beach,vacation (optional)" type="text" /></label><br />
<input type="submit" />
</fieldset>
</form>
</body>
</html>