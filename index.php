<?php
   if(isset($_GET['insta'])){
    $client_id = "e81d504255fd4241854288ebfd436c7b";
    $redirect_uri = "http://localhost:8888/collage/instagram.php";
     
    header("Location: https://api.instagram.com/oauth/authorize/?client_id=".$client_id."&redirect_uri=".$redirect_uri."&response_type=code");
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>DaPaD</title>
	
	<meta name="viewport" content="width=device-width" />
	<meta name="format-detection" content="telephone=no" />
	<link rel="apple-touch-icon" href="apple-touch-icon.png" />
	
	<link rel="shortcut icon" href="/favicon.ico">	
	<meta name="Description" content="イラストを描いて投稿するサービス。" /> 
	<meta name="keywords" content="イラストサービス,SNS,html5,お絵かき" />
	
	<link rel="stylesheet" href="css/common.css" media="screen" />
	<script src="js/jquery.min.js"></script>
    <script src="js/action.js"></script>	
    </head>

	<body class="index">
        <div id="wrap">
            <div id="your_canvas">
            	<ul>
            	  <li>『&nbsp;DaPaD&nbsp;』</li>
            	  <li>当WEBサービスは、</li>
            	  <li>WEB上でお絵描きが出来ます。</li>
                  <li>まだ製作中ですが宜しければ試しに遊んで下さい</li>
            	  <li>New! ▶ <a href='index.php?insta=true'>instagramから背景画像を選ぶ</a></li>
            	</ul>
                <p id="draw" class="thanks"><a href="create.php">描きにいく</a></p>
            </div>
        </div>
	</body>
</html>



