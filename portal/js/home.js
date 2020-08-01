$(document).ready(function () {
//ajax spinner
$(document).ajaxStart(function () {
	$('#loader').show(); show_opacity();
}).ajaxStop(function () {
	$('#loader').hide();hide_opacity();
	$('.left_divs').css('height',($('.container_div').height())+"px");
}).ajaxError(function () {
	$('#ajaxerror').show('slow'); show_opacity();
});


	//menu toggle
	$('#mobile-menu').on('click',function () {
		if ($('#modile_ul_container').css('display')=="block") {
			$('#modile_ul_container').css('display','none');
			$(this).attr('class','fa fa-bars');
			$('body').css({'overflow':'auto'});
		}else{
			$('#modile_ul_container').css('display','block');
			$(this).attr('class','fa fa-times');
			$('body').css({'overflow':'hidden'});
		}
	});


//close modal
	$('.modal_close').on('click',function (e) {
		$('form')[0].reset();
		$('.st_teachers_modal').hide('fast'); hide_opacity();
		e.preventDefault();
	});

// decrease the opacity of the body
function show_opacity(){
	$('#loaderWrapper').show();
}

// decrease the opacity of the body
function hide_opacity(){
	$('#loaderWrapper').hide();
}

	
//position at the center
var win_height=$(window).height();
var win_width=$(window).width();
var pg_gh_height=$('.st_teachers_modal').height();
var pg_gh_width=$('.st_teachers_modal').width();
var actual_top=(win_height/2)-((pg_gh_height/2));
var actual_left=(win_width/2)-((pg_gh_width/2));
// $('.st_teachers_modal').css('top',actual_top);
$('.st_teachers_modal').css('left',actual_left);

});