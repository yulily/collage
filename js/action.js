$(function(){
	$('body.index').each(function(index, element) {
		$('div#wrap,div#your_canvas').hide().each(function (i) {
		   $(this).fadeIn(1000);
		});        
    });
	$("p.thanks").each(function(){
		setTimeout(function(){
			$("p.thanks").fadeIn("slow").animate({opacity:'.8'},1000);
		},1000);
	});
	
});