<?php
    session_start();
    if(isset($_GET['code'])){
        if(!$_SESSION['access_token']){
            $_SESSION['code'] = $_GET['code'];

            $client_id     = "e81d504255fd4241854288ebfd436c7b";
            $client_secret = "b092bec964f34cc499ebbd22d9b4e570";
            $redirect_uri  = "http://cascade.sub.jp/dapad/create.php";
            $token_uri     = 'https://api.instagram.com/oauth/access_token';
            $url           = 'https://api.instagram.com/oauth/authorize/?client_id='.$client_id.'&redirect_uri='.$redirect_uri.' URI&response_type=code&scope=basic+relationships+comments+likes';
            //-----[postするデータ]
            $post          = "client_id=".$client_id."&client_secret=".$client_secret."&grant_type=authorization_code&redirect_uri=".$redirect_uri."&code=".$_SESSION['code'];

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
                mkdir( "./img/".$use_id, 0777 );
                chmod( "./img/".$use_id, 0777 );
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
        }
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
  <link rel="stylesheet" href="css/farbtastic.css" type="text/css" />

    <script src="js/jquery.min.js"></script>
    <script src="js/upload.js"></script>
    <script src="js/canvas.js"></script>
    <script src="js/farbtastic.js"></script>
    <script src="js/palet.js"></script>
    <script src="js/jquery.webcam.js"></script>

 </head>

	<body class="create cf">
        <div id="siteHeader">
            <hgroup>
                <h1><a href="index.php" rel="index" class="googleFont">DaPaD</a></h1>
            </hgroup>
        </div>
            <section class="cf" id="wrap">    
              <section id="tool" class="cf">
                  <ul class="tool_01 cf">
                     <li class="title nf">TOOL</li>
                       <li>
                         <ul>
                          <li class="nf"><input type="range" id="weight" name="invert" min="1" max="100" value="0"><span id="w">1</span></li>
                          <li id="pencil"><img src="image/pen.gif" width="30" height="30" alt="ペン"></li>           
                          <li class="paint_back"><span>1</span><img src="image/icon_back.gif" width="30" height="30" alt="戻る" /></li>
                          <li class="paint_delete"><img src="image/icon_all-delete.gif" width="30" height="30" alt="全消し" /></li>
                          <li class="paint_save"><img src="image/icon_local-save.gif" width="30" height="30" alt="一時保存" /></li>  
                          <li id="webcamera"><img src="image/icon_camera.gif" width="30" height="30" alt="Webカメラ" /></li>
                          <li id="mouse_state" class="nf">座標:0,0</li>
                        </ul>
                     </li>
                  </ul>
                  <ul class="tool_02 cf">
                   <li>
                      <p class="title">STAMP</p>
                       <ul>
                            <li class="s"><img src="image/stamp/stamp01.png" width="45"></li>
                            <li class="s"><img src="image/stamp/stamp02.png" width="45"></li>
                            <li class="s"><img src="image/stamp/stamp03.png" width="45"></li>
                            <li class="s"><img src="image/stamp/stamp04.png" width="45"></li>
                      </ul>
                   </li>
                   <li>
                      <p class="title">FRAME</p>
                       <ul>
                            <li class="f"><img src="image/frame/frame01.png" width="100" height="69" /></li>
                            <li class="f"><img src="image/frame/frame02.png" width="100" height="69" /></li>
                            <li class="f"><img src="image/frame/frame03.png" width="100" height="69" /></li>
                            <li class="f"><img src="image/frame/frame04.png" width="100" height="69" /></li>
                       </ul>
                   </li>
                   <li>
                      <?php
                        if(isset($_SESSION['access_token'])){
                            echo "<p class='title'>instagram</p><ul>";
                            $path = './img/'.$_SESSION['use_id'];
                            $dir = scandir($path);
                            $dir_max = count($dir)-3;
                            for($i=0; $i<$dir_max;$i++ ){
                               echo "<li class='i'><img src='./img/".$_SESSION['use_id']."/insta".$i.".jpg' width='50' /></li>";
                             }
                            echo "</ul>";
                          } else {
                            echo "<div class='yet_insta'>";
                            echo "<a href='index.php?insta=true'>instagramのデータを登録する</a><br />";
                            echo "※登録する場合は、データが破棄されるのでSAVEDATAに保存してから登録してください。<br />";
                            echo "※画像取得に数分かかります。";
                            echo "</div>";
                        }
                      ?>
                   </li>
                  </ul>
                  <ul class="tool_03 cf">
                    <li class="title">SAVEDATA</li>
                    <li>
                      <ul></ul>
                    </li>
                  </ul>
                  <dl class="tool_04">
                    <dt class="title">PALET</dt>
                    <dd id="palet">
                        <form><input type="text" id="color" name="color" value="#123456" /></form>
                        <div id="colorpicker"></div>
                        <ul class="imcus cf">
                          <li>#444</li>
                          <li>#444</li>
                          <li>#444</li>
                          <li>#444</li>
                          <li>#444</li>
                          <li>#444</li>
                          <li>#444</li>
                          <li>#444</li>
                          <li>#444</li>
                          <li>#444</li>
                        </ul>
                        <form action="paletCreate.php" id="form" method="post" enctype="multipart/form-data">
                        <ul class="cust cf">
                          <li><input type="text" name="c2" value="#ddd" size="6" id="t3" /></li>
                          <li><input type="text" name="c2" value="#ddd" size="6" id="t4" /></li>
                          <li><input type="text" name="c2" value="#ddd" size="6" id="t5" /></li>
                          <li><input type="text" name="c2" value="#ddd" size="6" id="t6" /></li>
                          <li><input type="text" name="c2" value="#ddd" size="6" id="t7" /></li>
                          <li><input type="text" name="c2" value="#ddd" size="6" id="t8" /></li>
                          <li><input type="text" name="c2" value="#ddd" size="6" id="t9" /></li>
                          <li><input type="text" name="c2" value="#ddd" size="6" id="t10" /></li>
                          <li><input type="text" name="c2" value="#ddd" size="6" id="t11" /></li>
                          <li><input type="text" name="c2" value="#ddd" size="6" id="t12" /></li>
                        </ul>                    
                        </form>
                    </dd>
                    <dt>パレットを画像から自動的に生成する</dt>
                    <dd>
                        <input type="file" id="img" name="img" value="" />
                    </dd>
                    <dd class="error"></dd>
                  </dl>
                  <ul class="tool_05 cf">   
                     <li class="title">LAYER</li>
                     <li>
                        <ol id="sortable" class="cf">
                          <li class="canvas0"><img src="" width="50" height="34" class="layer" alt="">レイヤー1</li>
                          <li class="canvas1"><img src="" width="50" height="34" class="layer" alt="">レイヤー2</li>
                          <li class="canvas2"><img src="" width="50" height="34" class="layer" alt="">レイヤー3</li>
                          <li class="canvas3"><img src="" width="50" height="34" class="layer" alt="">レイヤー4</li>
                        </ol>
                    </li>
                 </ul>
                <ul class="tool_06">
                    <li class="title">END</li>
                    <li id="save">画像を保存する</li>
                </ul>	             
          </section>
          <article>
              <header><h1 class="title">名称未設定</h1></header>
              <ul id="canvas">
                <li id="layer"><canvas id="collage" width="800" height="550"></canvas></li>
                <li id="layer3"><canvas id="collage3" width="800" height="550"></canvas></li>
                <li id="layer2"><canvas id="collage2" width="800" height="550"></canvas></li>
                <li id="layer1"><canvas id="collage1" width="800" height="550"></canvas></li>
                <li id="layer0"><canvas id="collage0" width="800" height="550"></canvas></li>
             </ul>
             <div id="resData"></div>
          </article>
        </section>
        <div id="wrapcamera" class="hide">
          <div id="camera"></div>
        </div>
        <div id="s_over"></div>
        <div id="over">
            <div id="btn" class="cf">
                <form action="save.php" method="POST" name="frmMain">
                    <input type="button" class="paint" id="back" value="修正する" />
                    <input type="submit" name="submit" class="paint" id="regist" value="保存する" />
                </form>
            </div>  
        </div>
	</body>
	
</html>



