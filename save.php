<?php
	require_once('lib.php');
	$date = date("Ymd");
	$con = db_connect();
	$date = date("Ymd");

	$url = $date;
	
	$sql = "insert into main (url) values('$url.png')";	
	$result = mysql_query($sql);
	
	$img_id = mysql_insert_id();
	$url = $url."_".$img_id;
	
	$sql = "update main set url = '$url.png' where id = $img_id";
	$result = mysql_query($sql);
	
	$img_id = mysql_insert_id();
	$url = $date."_".$img_id;

	$paint = base64_decode(htmlspecialchars($_POST['paint']));
	$im    = imagecreatefromstring($paint);
	imagepng($im,"image/create/".$url.".png");
	imagedestroy($im);
?>
<!DOCTYPE html><!-- 文書型宣言 -->
<html lang="ja"><!-- 言語型宣言 -->
<script src="js/jquery.min.js"></script>
<script src="js/upload.js"></script>
<script src="js/action.js"></script>	
<script src="js/fillter.js"></script>	
<head>
	<meta charset="utf-8"><!-- 文字コード設定 -->
	<title>DaPaD</title>
	
	<!-- スマホ用の指定 start -->
	<meta name="viewport" content="width=device-width" /><!-- ビューポート設定：デバイスの幅に依存 -->
	<meta name="format-detection" content="telephone=no" /><!-- 自動電話番号変換機能をオフに -->
	<link rel="apple-touch-icon" href="apple-touch-icon.png" /><!-- iPhone用ブックマークアイコンの指定 57*57 -->
	<!-- スマホ用の指定 end -->
	
	<link rel="shortcut icon" href="/favicon.ico"><!-- ファビコン指定 16*16 -->
	
	<meta name="Description" content="コラージュ" /> 
	<meta name="keywords" content="html5, css3, お絵かき" />
	
	<!-- スタイルシートの指定 type="text/css"が書かなくて良くなった。 -->
	<link rel="stylesheet" href="css/common.css" media="screen" />
	<!-- javascriptの指定 type="text/javascript"が書かなくて良くなった。 -->
</head>
	<body class="thankyou">
        <div id="wrap" class="saving cf">
            <p class="thanks">Thank you!<br />保存してね！<br />
            	<a href="index.php">TOPへ戻る</a><br /><br />
                <a href="#" class="fillter">加工する？</a>
            </p>
            <nav>
              <form action="index.php" id="fillter" method="post">
            	<ul id="nowselect">
                    <li id="saturate"><input type="range" name="saturate" min="0" max="300" value="100"><output class="value"><span>100</span>%</output></li>
                    <li id="brightness"><input type="range" name="brightness" min="-100" max="100" value="0"><output class="value"><span>0</span>%</output></li>
                    <li id="contrast"><input type="range" name="contrast" min="0" max="200" value="100"><output class="value"><span>100</span>%</output></li>
                    <li id="huerotate"><input type="range" name="huerotate" min="-180" max="180" value="0"><output class="value"><span>0</span>deg</output></li>
                    <li id="invert"><input type="range" name="invert" min="0" max="100" value="0"><output class="value"><span>0</span>%</output></li>
                    <li id="blur"><input type="range" name="blur" min="0" max="30" value="0"><output class="value"><span>0</span>px</output></li>
                    <li id="sepia"><input type="range" name="sepia" min="0" max="100" value="0"><output class="value"><span>0</span>%</output></li>
                    <li id="grayscale"><input type="range" name="grayscale" min="0" max="100" value="0"><output class="value"><span>0</span>%</output></li>
                    <li id="opacity"><input type="range" name="opacity" min="0" max="100" value="100"><output class="value"><span>100</span>%</output></li>
            	</ul>
                <div id="nowmode">
                	<ul class="clearfix">
                	  <li class="saturate">saturate</li>
                	  <li class="brightness">brightness</li>
                	  <li class="contrast">contrast</li>
                	  <li class="huerotate">huerotate</li>
                	  <li class="invert">invert</li>
                	  <li class="blur">blur</li>
                	  <li class="sepia">sepia</li>
                	  <li class="grayscale">grayscale</li>
                	  <li class="opacity">opacity</li>
                	</ul>
                </div>
				<input type="submit" name="submit" class="paint" id="edit" value="まだ作成中です。。" />
               </form>
            </nav>
            <div id="picture"><img src="image/create/<?php echo $url ?>.png" /></div>
        </div>	
	</body>
	
</html>
