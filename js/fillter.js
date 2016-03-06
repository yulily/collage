var pe = {
  footerScrollLeft: 0,
  footerScrollTop: 0,
  orientation: 0,
  dblTap: false,
  captureModeStatus: false,
  checkStyleContent: false
};
pe.filterValueArray = {
  'saturate':100,
  'brightness':0,
  'contrast':100,
  'huerotate':0,
  'invert':0,
  'blur':0,
  'sepia':0,
  'grayscale':0,
  'opacity':100
};
pe.setFilter = function(){
	$('#picture img').attr('style','-webkit-filter:saturate('+ pe.filterValueArray["saturate"] +'%) brightness('+ pe.filterValueArray["brightness"] +'%) contrast('+ pe.filterValueArray["contrast"] +'%) hue-rotate('+ pe.filterValueArray["huerotate"] +'deg) invert('+ pe.filterValueArray["invert"] +'%) blur('+ pe.filterValueArray["blur"] +'px) sepia('+ pe.filterValueArray["sepia"] +'%) grayscale('+ pe.filterValueArray["grayscale"] +'%) opacity('+ pe.filterValueArray["opacity"] +'%)');
}
$(function(){
	$('nav,#nowselect li').css('display','none');
	$('a.fillter').click(function(){
		//$('p.thanks').fadeOut();
		$('nav,#nowselect li:first').fadeIn();
	});
	$('#nowselect input[type="range"]').change(function(){
		var filterName = $(this).attr('name');
		var filterValue = $(this).attr('value');
		pe.filterValueArray[filterName] = filterValue;
		$('#'+filterName+' output span').text(filterValue);
		pe.setFilter();
	});
	$('#nowmode li').click(function(){
		var now = $(this).attr('class');
		$('#nowselect').find('li').hide();
		$('#nowselect li#'+ now ).fadeIn();
	});
	/*$("#edit").click(function(){
		$(this).upload('fillter.php',
		$("#form").serialize(),function(html){
			$("#picture").html(html);
		},'html');
	});*/
});