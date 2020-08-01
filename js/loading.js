$(document).ready(function(){

	$(window).resize(function(){
		if ($(window).width() > 620) {
			$('.head .full_menu').hide();
		}
	});

	//Load profile
	$('#profile').on('click', function(){
		$('.indivi_content').load('./mgt/profile.php');
	});

	//Load Eprofile
	$('#Eprofile').on('click', function(){
		$('.indivi_content').load('./mgt/Eprofile.php');
	});

	//Load Curriculum
	$('#view_curri').on('click', function(){
		$('.indivi_content').load('./mgt/view_curriculum.php');
	});


	//Load check result
	$('#check_result').on('click', function(){
		$('.indivi_content').load('./mgt/check_result.php');
	});

	//Load upload curriculum
	$('#upload_curriculum').on('click', function(){
		$('.indivi_content').load('./mgt/upload_curriculum.php');
	});

	//Load upload curriculum
	$('#upload_result').on('click', function(){
		$('.indivi_content').load('./mgt/upload_result.php');
	});

	//Load check assignment
	$('#check_assignment').on('click', function(){
		$('.indivi_content').load('./mgt/check_assignment.php');
	});

	//Load upload assignment
	$('#upload_assignment').on('click', function(){
		$('.indivi_content').load('./mgt/upload_assignment.php');
	});

	// alert($(window).width());





	//Show menu icon for small devices
	$('#menu_icon').click(function(){
		$('.full_menu').slideToggle('slow');
	});


	//Load profile
	$('#Sprofile').on('click', function(){
		$('.indivi_content').load('./mgt/profile.php');
	});

	//Load profile
	$('#SEprofile').on('click', function(){
		$('.indivi_content').load('./mgt/Eprofile.php');
	});

	//Load Curriculum
	$('#Sview_curri').on('click', function(){
		$('.indivi_content').load('./mgt/view_curriculum.php');
	});

	//Load result
	$('#Scheck_result').on('click', function(){
		$('.indivi_content').load('./mgt/check_result.php');
	});

	//Load upload curriculum
	$('#Supload_curriculum').on('click', function(){
		$('.indivi_content').load('./mgt/upload_curriculum.php');
	});

	//Load upload curriculum
	$('#Supload_result').on('click', function(){
		$('.indivi_content').load('./mgt/upload_result.php');
	});

	//Load check assignment
	$('#Scheck_assignment').on('click', function(){
		$('.indivi_content').load('./mgt/check_assignment.php');
	});

	//Load check assignment
	$('#Supload_assignment').on('click', function(){
		$('.indivi_content').load('./mgt/upload_assignment.php');
	});









});