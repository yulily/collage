<?php
	$post_data = array();
		foreach($_POST as $key => $val) {
		$post_data[$key] = $val;
	}
	$im = new Imagick('');
	$im->quantizeImage(10, Imagick::COLORSPACE_RGB, 0, true , false);
	$im->resizeImage(500,500, imagick::FILTER_LANCZOS, 0.9, true);
	$im->writeImage('./img/'.$fileName);
	$im->destroy();
	
	?>
    <div id="picture"><img src="image/create/<?php echo $url ?>.png" /></div>
	<?php
?>
