$(function() {
	//localStorage.clear();
	var penX,penY,ctx,stampSrc,penWidth;
	var drawing   = false,
		stampFlg  = false,
		penColor  = '#000',
		paintDb   = [],
		penLeft   = 1,
		nowLayer  = 'canvas3',
		savenum   = 0,
		bg        ="#eee";
	var layer = {
			canvas  : $('#collage')[0],
			canvas3 : $('#collage3')[0],
			canvas2 : $('#collage2')[0],
			canvas1 : $('#collage1')[0],
			canvas0	: $('#collage0')[0]
	}	
	var Draw = function (layer) {  
		if (layer.getContext) {
			ctx = layer.getContext('2d');
		}
		$('#canvas canvas').mousemove(function(e){		
			penX = e.pageX - parseInt($(this).offset().left);
			penY = e.pageY;
			if ( !stampFlg ) {
				if (drawing) {
					ctx.lineTo(penX,penY-53);
					ctx.stroke();
				}
				$(this).mousedown(function() {
					penWidth = penLeft;
					ctx.beginPath();
					ctx.lineWidth = penWidth;
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
	
	Draw(layer.canvas);
	ctx.fillStyle = bg;
	ctx.fillRect(0,0,800,550);
 	Draw(layer.canvas3);
	$('#colorpicker').farbtastic('#color');
	
	Draw.prototype = {
		frame : function() {
			var img = new Image();
			img.src = stampSrc;
			img.onload = function() {
				ctx.drawImage(img,0,0);
				layerInfo();
			}
		},
		stamp : function() {
			stampFlg = true;
			if (stampFlg) {
				img = new Image();
				img.src = stampSrc;
				img.onload = function() {
					 $('#canvas').mousemove(function(e) {	
						sX = e.pageX - $(this).offset().left - img.width/2;
						sY = e.pageY - img.height / 2;
						$(this).mousedown(function(){
							(!stampFlg) ? img.src ="" : false;
							ctx.drawImage(img,sX,sY);
						});
				 	});
					layerInfo();
				}
			}
		},
		dbSave : function(save) {
			var maxCases = 10;
			var base64 = layer[nowLayer].toDataURL();
			if(save){
				if ( localStorage.length < maxCases ) {
					window.localStorage.setItem("save"+localStorage.length,base64);
					var save_img = $('<img />').attr('src', base64).width('50px').height('34px');
					var list = $('<li />').append(save_img);
					$('.tool_03').append(list);
				} else { alert("保存領域がいっぱいです。どれか消して再度登録して下さい");}
			} else {
				if ( paintDb.length < maxCases ) {
					var i = paintDb.length;
					paintDb[i] = base64;	
				}
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
		$('.tool_03').append(list);
	});
	$('#canvas canvas').click(function() {
		Draw.prototype.dbSave();
		var r = paintDb.length;
		layerInfo();
	});
	$(".paint_back").click(function() {
		var img = new Image();
		var i = paintDb.length - 2;
		img.src = paintDb[i];
		img.onload = function(){
		  ctx.clearRect(0,0,800,550);
		  ctx.drawImage(img,0,0);
		}
		paintDb.pop(i);
	});
	$('ul.tool_01 li').click(function() {
		var tool = $(this).attr('id');
		if ( tool == 'pencil' ) {
			stampFlg    = false;
			penColor = "#000";
		}
	});
	$('.tool_02 li').click(function() {
		var fs = $(this).attr('class');
		stampSrc = $(this).find('img').attr('src');
		if ( fs == 's' ) {
			Draw.prototype.stamp();
		} else if( fs == 'f' ) {
			Draw.prototype.frame();
		}
	});
	var e = new Draw( layer.canvas3 );
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
		console.log($('#color').val());
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
		ctx.clearRect(0,0,800,550);
		layerInfo();
	});
	$(".paint_save").click(function() {
		Draw.prototype.dbSave("save");
	});
	$(document).on('click','ul.tool_03 li',function() {
		var num = $(this).index() - 1;
		var base64 = localStorage.getItem("save" + num);
		var img = new Image();
		img.src = base64;
	    ctx.clearRect(0,0,800,550);
		img.onload = function() {
		  ctx.drawImage(img,0,0);
		  layerInfo();
		}
    });
	$('#weight').mousedown(function(e) {
		penLeft = e.pageX - parseInt($(this).offset().left);
		if(0 < penLeft && penLeft < 100) $('.get').css( 'left',penLeft +'px' );
		$('#w').html(penLeft);
	});
	$(window).keyup(function(event) {
		event.preventDefault();
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
		}
	});
	$("#tool ul,#tool dl").mousedown(function(e){
		$(this)
			.data("X",e.pageX - $(this).position().left)
			.data("Y",e.pageY - $(this).position().top)
			.mousemove(function(e){
				$(this).css({
					top  : e.pageY - $(this).data("Y")+"px",
					left : e.pageX - $(this).data("X")+"px"
				});
			}).mouseup(function(e){
				$("#tool ul,#tool dl").unbind("mousemove");
			});
	});
	$('#save').click(function() {
		$('#s_over form input').not('#regist').remove();
		var mc = document.createElement("canvas");
            mc.width  = 800;
            mc.height = 550;
            for( var property in layer ) {
                mc.getContext("2d").drawImage(layer[property], 0, 0);
			}
		$('#over,#s_over').show();
		var paint_data = mc.toDataURL();
			paint_data = paint_data.replace(/^.*,/, '');
			$('<input />').attr('type','hidden').attr('name','paint').attr('value',paint_data).appendTo('#s_over form');
	});
	$('#back').click(function(){
		$('#over,#s_over').hide(); 	
	});
});