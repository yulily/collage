$(function(){
	var preview = $('#palet ul.imcus li');
    preview.css("background-color","#444");
	$("#img").change(function(){
		$(this).upload('paletCreate.php',
		$("#form").serialize(),function(html){
			$("#palet ul.imcus").html(html);
			$('#palet ul.imcus li').each(function (i) {
			  $(this).css("background-color",$(this).text());
			});
		},'html');
	});
});

