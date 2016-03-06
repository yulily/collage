$(function() {
    localStorage.clear();
	var penX,penY,ctx,stampSrc,penWidth;
	var size = {
		width   : 800,
		height  : 550,
		cameraX : 733,
		cameraY : 550
	};
	var drawing   = false,
		stampFlg  = false,
		penColor  = '#000',
		paintDb   = [],
		penLeft   = 1,
		nowLayer  = 'canvas3',
		savenum   = 0,
		bg        = "#eee";
	var layer = {
		canvas  : $('#collage')[0],
		canvas3 : $('#collage3')[0],
		canvas2 : $('#collage2')[0],
		canvas1 : $('#collage1')[0],
		canvas0	: $('#collage0')[0]
	};
	paintDb[0] = layer[nowLayer].toDataURL();
	var Draw   = function (layer) {
		if (layer.getContext) {
			ctx = layer.getContext('2d');
		}
		$('#canvas canvas').mousemove(function(e){
			console.log(penColor);		
			penX = e.pageX - parseInt($(this).offset().left);
			penY = e.pageY - parseInt($(this).offset().top);
			if ( !stampFlg ) {
				if (drawing) {
					ctx.lineJoin = 'round';
					ctx.lineCap  = 'round';
					ctx.lineTo(penX,penY);
					ctx.stroke();
				}
				$(this).mousedown(function() {
					penWidth = penLeft;
					ctx.beginPath();
					ctx.lineWidth   = penWidth;
					ctx.strokeStyle = penColor;
					ctx.moveTo(penX,penY);
					drawing = true;
				}).mouseup(function() {
					ctx.closePath();
					drawing = false;
				});
			}
			$('#mouse_state').html('座標:'+ penX +','+penY);
		});
	}
	//start
    Draw(layer.canvas);
    ctx.fillStyle = bg;
    ctx.fillRect(0,0,size.width,size.height);
    Draw(layer.canvas3);
    //start
    Draw.prototype = {
        frame : function() {
            var img = new Image();
            img.src = stampSrc;
            img.onload = function() {
                ctx.drawImage(img,0,0);
                layerInfo();
                Draw.prototype.dbSave();
            }
        },
        stamp : function() {
            stampFlg = true;
            if (stampFlg) {
                img = new Image();
                img.src = stampSrc;
                img.onload = function() {
                    $('#canvas').mousemove(function(e) {
                        sX = e.pageX - $(this).offset().left - img.width / 2;
                        sY = e.pageY - $(this).offset().top - img.height / 2;
                        $(this).mousedown(function(){
                            (!stampFlg) ? img.src ="" : false;
                            ctx.drawImage(img,sX,sY);
                        });
                    });
                    layerInfo();
                    Draw.prototype.dbSave();
                }
            }
        },
        insta : function() {
            var centerX = 94;
            var img = new Image();
            img.src = stampSrc;
            img.onload = function() {
                ctx.drawImage(img,centerX,0);
                layerInfo();
                Draw.prototype.dbSave();
            }
        },
        dbSave : function(save) {
            var base64 = layer[nowLayer].toDataURL();
            if(save){
                window.localStorage.setItem("save"+localStorage.length,base64);
                var save_img = $('<img />').attr('src', base64).width('50px').height('34px');
                var list = $('<li />').append(save_img);
                $('.tool_03 li ul').append(list);
            } else {
                var i = paintDb.length;
                paintDb[i] = base64;
       		}
        }
    };
    var layerInfo = function () {
        var layer_index = nowLayer.replace('canvas','');
        var view = $("ol li").eq(layer_index).find('img');
        view.attr("src",layer[nowLayer].toDataURL());
    }
    $.each(localStorage,function(i) {
        var datasrc  = localStorage.getItem("save"+i);
        var save_img = $('<img />').attr('src', datasrc).width('50px').height('34px');
        var list     = $('<li />').append(save_img);
        $('.tool_03 li ul').append(list);
    });
	var btn_change = function(btn_src , pro){
		if(pro == 'pencil' || pro == 'stamp'){
			if(pro == 'pencil' && !btn_src.match(/_on/)){
				btn_src = btn_src.replace('.','_on.');
			}else if(pro == 'stamp'){
				btn_src = btn_src.replace(/_on/,'');
			}
		}else{
			if(btn_src.match(/_on/)){
				btn_src = btn_src.replace(/_on/,'');
			}else{
				btn_src = btn_src.replace('.','_on.');
			}
		}
		return btn_src;
	}
	var start_camera = function(txt){
		$("#camera").webcam({
			width: 733,
			height: 550,
			mode: "callback",
			swffile: "js/jscam.swf",

			onSave : (function () {
			   ctx1 = layer.canvas3.getContext('2d');
			   image = ctx1.getImageData(0, 0, size.cameraX, size.cameraY);  
			   return function (data) {  
				var col = data.split(";"); //1pxごとに分割  
				var img = image;
				for (var i = 0; i < size.cameraX; i++) {  
					var tmp = parseInt(col[i]);  
					img.data[pos + 0] = (tmp >> 16) & 0xff; //赤  
					img.data[pos + 1] = (tmp >> 8) & 0xff;  //緑  
					img.data[pos + 2] = tmp  & 0xff;        //青  
					img.data[pos + 3] = 0xff;               //アルファ  
					pos += 4;
			    }
			    if (pos >= 4 * size.cameraX * size.cameraY) {  
					ctx1.putImageData(img, 33, 0);
					pos = 0;
			    }
			   };  
	  		})(),
			onCapture: function () {
				webcam.save();
			},
			debug: function (type, string , txt) {
				if(string.indexOf('stopped') != -1){
					$('#webcamera').removeClass('play');
					$('#wrapcamera').addClass('hide');
					var btn_c = btn_change($('#webcamera').find('img').attr('src'));
					$('#webcamera').find('img').attr('src',btn_c);
					$('#camera object').eq(0).remove();
					start_camera();
				}
				console.log(type + ": " + string);
			}
		});
	}
	$('#colorpicker').farbtastic('#color');
	$('#canvas canvas').click(function() {
		Draw.prototype.dbSave();
		var r = paintDb.length;
		layerInfo();
	});
	$(".paint_back").click(function() {
		var img = new Image();
		if(paintDb.length > 0){
			var i = paintDb.length - 2;
			img.src = paintDb[i];
			img.onload = function(){
			  ctx.clearRect(0,0,size.width,size.height);
			  ctx.drawImage(img,0,0);
			}
			paintDb.pop(i);
			layerInfo();
		}
	});
	$('ul.tool_01 li').click(function() {
		var tool = $(this).attr('id');
		if ( tool == 'pencil' ) {
			stampFlg    = false;
			var btn_c = btn_change($("ul.tool_01 li#" + tool).find('img').attr('src'),'pencil');
			$( "ul.tool_01 li#" + tool).find('img').attr('src',btn_c);
		}
	});
	$('.tool_02 li').click(function() {
		var fs = $(this).attr('class');
		stampSrc = $(this).find('img').attr('src');
		if ( fs == 's' ) {
			Draw.prototype.stamp();
			var btn_c = btn_change($("ul.tool_01 li#pencil").find('img').attr('src'),'stamp');
			$("ul.tool_01 li#pencil").find('img').attr('src',btn_c);
		} else if( fs == 'f' ) {
			Draw.prototype.frame();
		} else if( fs == 'i' ){
            Draw.prototype.insta();
        }
	});
	$('ol li').click(function() {
		switch ($(this).index()) {
			case 0 : Draw(layer.canvas0);
			  break;
			case 1 : Draw(layer.canvas1);
			  break;
			case 2 : Draw(layer.canvas2);					
			  break;
			case 3 : Draw(layer.canvas3);
			  break;
		}
		$("ol#sortable li").find('img').css("border", "none");
		$(this).find('img').css("border", "2px solid #a00");
		nowLayer = $(this).attr('class');
	});
	$('div.clickzone').click(function() {
		penColor = $('#color').val();
    });
	$(document).on('click','ul.imcus li',function() {
		penColor = $(this).text();
	});
	$(document).on('focus','ul.cust li input',function() {
		var numb = $(this).parent().index();
		var code = $(this).val();
		$(".imcus li").eq(numb).text(code).css("background-color",code);
	});
	$(".paint_delete").click(function() {
		ctx.clearRect(0,0,size.width,size.height);
		layerInfo();
	});
	$(".paint_save").click(function() {
		Draw.prototype.dbSave("save");
	});
	$(document).on('click','ul.tool_03 li',function() {
        if($(this).index() != 0){
            var num = $(this).index() - 1;
            var base64 = localStorage.getItem("save" + num);
            var img = new Image();
            img.src = base64;
            ctx.clearRect(0,0,size.width,size.height);
            img.onload = function() {
              ctx.drawImage(img,0,0);
              layerInfo();
            }
        }
    });
	/*  ★クリニック★  */
	$('.tool_02 li ul').eq(0).css('width',($('li.s').width() + 12) * $('li.s').length +'px');
	$('.tool_02 li ul').eq(1).css('width',($('li.f').width() + 12) * $('li.f').length +'px');
	$('.tool_02 li ul').eq(2).css('width',($('li.i').width() + 12) * $('li.i').length +'px');
	$('.tool_03 li ul').css('width',($('li').width() + 12) * $('li').length +'px');

	$('.tool_02 li ul,.tool_03 li ul').mousedown(function(e){
		var drag = e.pageX;
		$(this).on('mousemove',function(e){
			$(this).css({ marginLeft : e.pageX - drag + 'px' });
		}).mouseup(function(e){
			$(this).off('mousemove');
		});
	});

	$('#weight').change(function(){
		penLeft = $(this).val();
		$('#w').html(penLeft);
	});

	$(window).keyup(function(event) {
		var maxpenWidth = 100;
		var minpenWidth = 1;
		if ( penLeft >= minpenWidth && penLeft <= maxpenWidth ) {
			if ( event.keyCode == 38 ) {
				( penLeft != maxpenWidth ) ? penLeft = penLeft + 1 : false;
			} else if ( event.keyCode == 40) {
				( penLeft != minpenWidth ) ? penLeft = penLeft - 1 : false;
			}
			$('.get').css('left',penLeft+'px');
			$('#w').html(penLeft);
			$('#weight').val = penLeft;
		}
	});

	$("#tool .title").mousedown(function(e){
	    $(this).closest('ul,dl')
	        .data("X",e.pageX - $(this).closest('ul,dl').position().left)
	        .data("Y",e.pageY - $(this).closest('ul,dl').position().top)
	        .mousemove(function(e){
	            $(this).closest('ul,dl').css({
	                top  : e.pageY - $(this).closest('ul,dl').data("Y")+"px",
	                left : e.pageX - $(this).closest('ul,dl').data("X")+"px"
	            });
	        }).mouseup(function(e){
	            $(this).unbind("mousemove");
        });
	});

    //webcamera
	var pos = 0, ctx1 = null, saveCB, image = [];
	start_camera();
	$('#webcamera').click(function(){
		if(!$(this).hasClass('play')){
			var btn_c = btn_change($('#webcamera').find('img').attr('src'));
			console.log(btn_c);
			$('#webcamera').find('img').attr('src',btn_c);
			$('#wrapcamera').removeClass('hide');
			$(this).addClass('play');
		}else{
			var btn_c = btn_change($(this).find('img').attr('src'));
			$(this).find('img').attr('src',btn_c);
			$(this).removeClass('play');
			$('#wrapcamera').addClass('hide');
			webcam.capture();
			layerInfo();
			Draw.prototype.dbSave();
		}
    });
    //save
	$('#save').click(function() {
		$('#s_over form input').not('#regist').remove();
		var mc = document.createElement("canvas");
            mc.width  = size.width;
            mc.height = size.height;
            for( var property in layer ) {
                mc.getContext("2d").drawImage(layer[property], 0, 0);
			}
        $('#canvas').css('z-index','7');
		$('#over,#s_over').show();
		var paint_data = mc.toDataURL();
			paint_data = paint_data.replace(/^.*,/, '');
			$('<input />').attr('type','hidden').attr('name','paint').attr('value',paint_data).appendTo('#btn form');
	});
	$('#back').click(function(){
        $('#canvas').css('z-index','2');
		$('#over,#s_over').hide(); 	
	});
});