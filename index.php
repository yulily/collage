<?php
   if(isset($_GET['insta'])){
    $client_id = "e81d504255fd4241854288ebfd436c7b";
    $redirect_uri = "http://cascade.sub.jp/dapad/create.php";
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
				<div class="att js">
						<noscript>
							JavaScriptが無効になっています。<br />
							当サービスの全ての機能を利用するためには、JavaScriptを有効にする必要があります。<br />
							<a href="http://www.enable-javascript.com/ja/" title="あなたのWebブラウザーでJavaScriptを有効にする方法" target="_blank">
							こちら</a>を参照してください。
						</noscript>
				</div>
        <div id="wrap">
            <div id="your_canvas">
                <section>
                    <ul>
                      <li><h1>『&nbsp;DaPaD&nbsp;』</h1></li>
                      <li>当WEBサービスは、</li>
                      <li>WEB上でお絵描きが出来ます。</li>
                      <li>まだ製作中ですが宜しければ試しに遊んで下さい</li>
                      <li>最新のChromeのみ動作確認済み</ul>
                    <p id="draw" class="thanks"><a href="create.php">描きにいく</a></p>
                </section>
            </div>
        </div>
        <div class="att">
          お使いのブラウザでは、当サービスはご利用頂けません。<br />
          当サービスのご利用にはHTML5をサポートしたブラウザが必要です。<br />
          サポートは最新のGoogle Chromeのみになります。<br />
          &#9658;<a href="http://www.google.com/chrome/intl/ja/landing.html" target='_blank'>こちらからダウンロード可能です。</a> 
        </div>
        
	</body>
</html>



