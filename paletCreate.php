<?php
if ( $_FILES["img"]["size"] != 0 ) :
	$fileName 	 = basename(date("U")."-".$_FILES['img']['name']);
	$fileType 	 = $_FILES['img']['type'];
	$fileTmpName = $_FILES['img']['tmp_name'];
	$result 	 = false;
	
	if(preg_match("/jpeg|png/",$fileType)):
		if (move_uploaded_file($fileTmpName,'./img/'.$fileName)) :
			$color 	 = array();
			$palet 	 = array();
	
			$im = new Imagick('./img/'.$fileName);
			$im->quantizeImage(10, Imagick::COLORSPACE_RGB, 0, true , false);
			$im->resizeImage(500,500, imagick::FILTER_LANCZOS, 0.9, true);
			$im->writeImage('./img/'.$fileName);
			$im->destroy();
	
			if($fileType == "image/png"):
				$im = imagecreatefrompng('./img/'.$fileName);
			else:
				$im = imagecreatefromjpeg('./img/'.$fileName);
			endif;
	
			list($width,$height) = getimagesize('./img/'.$fileName);
	
			for($i = 0; $i < $width-10; $i+=10){
				for($v = 0; $v < $height-10; $v+=10){
					$rgb 	 = imagecolorat($im, $i, $v);	
					$info    = imagecolorsforindex($im,$rgb);
					$r 		 = sprintf("%02x",$info['red']);
					$g 		 = sprintf("%02x",$info['green']);
					$b		 = sprintf("%02x",$info['blue']);
					$rgb 	 = $r.$g.$b;
					$color[] = $rgb;
					if($i > $width || $v > $height){
						break 2;
					}
				}
			}
			
			unlink('./img/'.$fileName);
			
			$data = array_count_values($color);	
		
			$cnt = 0;
	
			foreach($data as $key=>$value){
				$palet[] = $key;
				if($cnt > 9){
					break;
				}
				$cnt++;
			}
	
			$result = true; 
			
		else:
		  echo  '保存に失敗しました。';
		endif;
	
	else:
		unlink($fileTmpName);
		echo "jpgのみ対応しております。"; 
	endif;
	
	if($result == true){
	?>
	  <li>#<?php echo $palet[0] ?></li>
	  <li>#<?php echo $palet[1] ?></li>
	  <li>#<?php echo $palet[2] ?></li>
	  <li>#<?php echo $palet[3] ?></li>
	  <li>#<?php echo $palet[4] ?></li>
	  <li>#<?php echo $palet[5] ?></li>
	  <li>#<?php echo $palet[6] ?></li>
	  <li>#<?php echo $palet[7] ?></li>
	  <li>#<?php echo $palet[8] ?></li>
	  <li>#<?php echo $palet[9] ?></li>
	<?php
	}
endif;
?>
