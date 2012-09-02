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
  <link rel="stylesheet" href="css/farbtastic.css" type="text/css" /> 

	<script src="js/jquery.min.js"></script>
	<script src="js/upload.js"></script>
  <script src="js/canvas.js"></script>
  <script src="js/farbtastic.js"></script>
	<script src="js/palet.js"></script>	
    </head>

	<body class="create cf">
        <div id="siteHeader">
            <hgroup>
                <h1><a href="/" rel="index" class="googleFont">White</a></h1>
            </hgroup>
        </div>
            <section class="cf" id="wrap">    
              <section id="tool" class="cf">
                   <ul class="tool_01 cf">
                    <li class="title nf">TOOL</li>
                    <li class="nf"><p id="weight"><span class="get"></span></p><span id="w">1</span></li>
                    <li id="pencil"><img src="image/pen.jpg" width="40" height="40" alt=""></li>           
                    <li class="paint_back"><span>1</span><img src="image/icon_back.jpg" alt="戻る" /></li>
                    <li class="paint_delete"><img src="image/icon_all-delete.jpg" alt="全消し" /></li>
                    <li class="paint_save"><img src="image/icon_local-save.jpg" alt="一時保存" /></li>  
                    <li id="mouse_state" class="nf">座標:</li>           
                  </ul>
                  <ul class="tool_02 cf">
                    <li class="title">STAMP</li>
                    <li class="s"><img src="image/stamp/imgFlower01.png" width="45"></li>
                    <li class="s"><img src="image/stamp/imgFlower02.png" width="45"></li>
                    <li class="s"><img src="image/stamp/imgFlower03.png" width="45"></li>
                    <li class="s"><img src="image/stamp/imgFlower04.png" width="45"></li>
                    <li class="title">FRAME</li>
                    <li class="f"><img src="image/frame/frame01.png" width="45"></li>
                    <li class="f"><img src="image/frame/frame02.png" width="45"></li>
                    <li class="f"><img src="image/frame/frame03.png" width="45"></li>
                    <li class="f"><img src="image/frame/frame04.png" width="45"></li>
                  </ul>
                  <ul class="tool_03 cf">
                    <li class="title">SAVEDATA</li>
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
          </article>
        </section>
        <div id="s_over">
            <div id="btn" class="cf">
                <form action="save.php" method="POST" name="frmMain">
                    <p id="back" class="paint">修正する</p>	
                    <input type="submit" name="submit" class="paint" id="regist" value="保存する" />
                </form>
            </div>
        </div>
        <div id="over"></div>
	</body>
	
</html>



