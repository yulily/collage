$(function(){
	$('.js').css('display','none');
	var userAgent = window.navigator.userAgent.toLowerCase();
	console.log(userAgent);
	if (userAgent.indexOf('chrome') == -1) {
	  $('.att').fadeIn();
	}
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