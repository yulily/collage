$(function(){

	var penX,penY,canvas,ctx,s_src,penColor,penWidth;
	var drawing = false;
	var s_flg = false;
	var p_left = 1;
	
	var draw = function(){
		canvas = document.getElementById('collage');	
		if (canvas.getContext){
			ctx = canvas.getContext('2d');
		}
		if(s_flg == false){
			$('#collage').mousemove(function(e){		
				penX = e.pageX - $(this).offset().left;
				penY = e.pageY;
				if (drawing){	
				    ctx.lineTo(penX,penY);
				    ctx.stroke();
				}
				$(this).mousedown(function(){
					penColor = $('#t2').val();
					penWidth = p_left;
				    ctx.beginPath();
					ctx.lineWidth = penWidth;
					ctx.strokeStyle = penColor;
				    ctx.moveTo(penX,penY);
					drawing = true;
				}).mouseup(function(){
				    ctx.closePath();
				    drawing = false;
				});
				debug();
			});
			function debug(){
				$('#mouse_state').html('座標:'+penX +','+ penY);
			}
		}
	};
	draw.prototype = {
		frame : function(){
			var img = new Image();
			img.src = s_src;
			img.onload = function() {
				ctx.drawImage(img,0,0);
			}
		},
		stamp : function(){
			s_flg = true;
			var img = new Image();
			img.src = s_src;
			if(s_flg){
				img.onload = function() {
					 $('#collage').mousemove(function(e){	
						sX = e.pageX - $(this).offset().left;
						sY = e.pageY;
						$(this).mousedown(function(){
							ctx.drawImage(img,sX,sY);
							s_flg = false;
							img.src = '';
						});
				 	});
				}
			}
		}
	};

	$('.item li').click(function(){
		var fs = $(this).attr('class');
		s_src = $(this).find('img').attr('src');
		$(this).css('background-color','#eee');
		if(fs == 's'){
			draw.prototype.stamp();
		}else if(fs == 'f'){
			draw.prototype.frame();
		}
	});

	draw();	
	
	// weight + key action + save
	$(window).keyup(function(event){
		if(p_left >= 1 && p_left <= 100){
			if(event.keyCode == 38){
				p_left = p_left+1;
			}else if(event.keyCode == 40){
				p_left = p_left-1;
			}
			$('.get').css('left',p_left+'px');
			$('#w').html(p_left);
		}
	});
	
	$('#weight').mousedown(function(e){
		p_left = e.pageX - $(this).offset().left;
		$('.get').css('left',p_left+'px');
		$('#w').html(p_left);
	});
		
	$('#save').click(function() {
		$('#over,#s_over').show();
   });

	$('#back').click(function(){
		$('#over,#s_over').hide(); 	
	});
   
	$('#regist').click(function(){
 	
	});
   
});// JavaScript Document

