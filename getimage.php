<!DOCTYPE html><!-- 文書型宣言 -->
<html lang="ja"><!-- 言語型宣言 -->
<head>
	<meta charset="utf-8"><!-- 文字コード設定 -->
	<title>シリージュ</title>
	
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
	<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/cpick.js"></script>
	<script src="js/canvas.js"></script>
	<script src="js/palet.js"></script>	
    </head>

	<body>
		<form action="itemAddCheck.php" name="register" method="post" enctype="multipart/form-data">
        	<input type="file" name="userfile" maxlength="255" value="" />
        </form>
	</body>
	
</html>



