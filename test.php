<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja" dir="ltr">
<head>
<title>sample771(ImageMagick6.4.4)</title>
</head>
<body>
<?php
/* 画像を32色に減色する */
$im = new Imagick("img/1342337767-1.png");
$im->quantizeImage(30, Imagick::COLORSPACE_RGB, 0, true , false);
$im->writeImage('1342337767-1.png');
$im->destroy();
?>
<img src="1342337767-1.png" /><br />

</body>
</html>
