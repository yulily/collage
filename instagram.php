<?php
    session_start();
    if(!$_SESSION['code']){
        $_SESSION['code'] = $_GET["code"];
    }
    $client_id = "e81d504255fd4241854288ebfd436c7b";
    $client_secret = "b092bec964f34cc499ebbd22d9b4e570";
    $redirect_uri = "http://localhost:8888/collage/instagram.php";
    $token_uri = 'https://api.instagram.com/oauth/access_token';
    $url = 'https://api.instagram.com/oauth/authorize/?client_id='.$client_id.'&redirect_uri='.$redirect_uri.' URI&response_type=code&scope=basic+relationships+comments+likes';
    //-----[postするデータ]
    $post = "client_id=".$client_id."&client_secret=".$client_secret."&grant_type=authorization_code&redirect_uri=".$redirect_uri."&code=".$_SESSION['code'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_uri);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $json = json_decode(curl_exec($ch));
    curl_close($ch);
    $token  = $json->access_token;
    $use_id = $json->user->id;

    $file_name = "./img/".$use_id;

    if( !file_exists( $file_name ) ){
        mkdir( "./img/".$use_id, 0700 );
    }

    $_SESSION['access_token'] = $token;
    $_SESSION['use_id'] = $use_id;

    $data = $token;

    $json = file_get_contents("https://api.instagram.com/v1/users/self/media/recent?access_token=".$token);
    $data = json_decode($json,true);

    foreach( $data as $photo ){
        for( $i = 0; $i < count($photo); $i++ ){
            if(isset($photo[$i])){
                $url = $photo[$i]["images"]["standard_resolution"]["url"];
                $data = file_get_contents($url);
                file_put_contents('./img/'.$use_id.'/insta'.$i.'.jpg',$data);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>White</title>
	
	<meta name="viewport" content="width=device-width" />
	<meta name="format-detection" content="telephone=no" />
	<link rel="apple-touch-icon" href="apple-touch-icon.png" />
	
	<link rel="shortcut icon" href="/favicon.ico">	
	<meta name="Description" content="イラストを描いて投稿するサービス。" /> 
	<meta name="keywords" content="イラストサービス,SNS,html5,お絵かき" />
	
	<link rel="stylesheet" href="css/common.css" media="screen" />
	<script src="js/jquery.min.js"></script>
    <script src="js/action.js"></script>
    <script src="js/instagram.js"></script>
</head>

	<body class="index">
        <div id="wrap">
            <div id="instagram">
                <ul>
                <?php
                    for( $i = 0; $i < count($photo); $i++ ){
                        if( isset($photo[$i]) ){
                            echo "<li><img src='img/".$use_id."/insta".$i.".jpg' width='100' /></li>";
                        }
                    }
                ?>
            	</ul>
                <p id="draw" class="thanks"><a href="create.php">描きにいく</a></p>
            </div>
        </div>
	</body>
</html>



