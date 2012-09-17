$(function(){
	$('#instagram').each(function(index, element) {
		$('#instagram li').click(function(){
            $('#instagram li').removeClass('select');
            $(this).addClass('select');
            $('#draw').find('a').attr('href','create.php?image='+$(this).find('img').attr('src'));
        });
    });
});