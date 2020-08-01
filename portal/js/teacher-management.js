(function() {
	$(document).ready(function () {
		$('.contents .curriculum_result_view .cur_res_btn button.view_res').on('click',function() {
			$('.contents .curriculum_result_view .res_cur_view div.curriculum').css('display','none');
			$('.contents .curriculum_result_view .res_cur_view div.result').css('display','block');
		});
		$('.contents .curriculum_result_view .cur_res_btn button.view_cur').on('click',function() {
			$('.contents .curriculum_result_view .res_cur_view div.result').css('display','none');
			$('.contents .curriculum_result_view .res_cur_view div.curriculum').css('display','block');
		});

		  curFeedBack();
		//curriculum feedback
		function curFeedBack() {
			var curFeedTeacher= 'yes';
			$.post('ajax/formteacher-process.php',{curFeedTeacher:curFeedTeacher},function(data) {$('#show_c_uploaded.form_teachers').html(data);})
		}
		$(document).on('click','.c_view',function() {
			var curViewPath=$(this).attr('data-viewPath');
			var type=$(this).attr('data-type');
			window.location.href="feed_back.php?curViewPath="+curViewPath+"&type="+type;
		});
		$(document).on('click','.c_download',function() {
			var curViewPath=$(this).attr('data-viewPath');
			var type=$(this).attr('data-type');
			window.location.href="feed_back.php?curViewPath="+curViewPath+"&type="+type;
		});
		//result feedback
		resFeedBack();
		function resFeedBack() {
			var resFeedTeacher='yes';$.post('ajax/formteacher-process.php',{resFeedTeacher:resFeedTeacher},function(data) {$('.show_r_uploaded.form_teachers').html(data);})
		}//view result
		$(document).on('click','.r_view',function() {
			var teachers_id=$(this).attr('data-teachers_id');
			var class_id=$(this).attr('data-class_id');
			var session_id=$(this).attr('data-session_id');
			var term_id=$(this).attr('data-term_id');
			var subject_id=$(this).attr('data-subject_id');
			window.location.href="view-uploaded-r?teachers_id="+teachers_id+"&class_id="+class_id
			+"&session_id="+session_id+"&term_id="+term_id+"&subject_id="+subject_id;
		});
		$(document).on('click','.approveBtn',function() {
			var term_type=$(this).attr('data-term_type');
			if (confirm("Approve result?")) {

				if (term_type=='termly') {
					$.post('ajax/formteacher-process.php',{approve_termly_result:'approve_termly_result'},
					function(data) {
						$('#error_feed').fadeIn(150).text(data).delay(10000).fadeOut(50);
					});
				}else{
					$.post('ajax/formteacher-process.php',{approve_annual_result:'approve_annual_result'},
					function(data) {
						$('#error_feed').fadeIn(150).text(data).delay(10000).fadeOut(50);
					});					

				}
			}

		});
		$(document).on('click','.assignBtn',function() {
			var term_type=$(this).attr('data-term_type');
			if (confirm("Assign Position?")) {
				
				if (term_type=='termly') {
					$.post('ajax/formteacher-process.php',{assign_termly_position:'assign_termly_position'},
					function(data) {
						$('#error_feed').fadeIn(150).text(data).delay(10000).fadeOut(50);
					});
				}else{
					$.post('ajax/formteacher-process.php',{assign_annual_position:'assign_annual_position'},
					function(data) {
						$('#error_feed').fadeIn(150).text(data).delay(10000).fadeOut(50);
					});					

				}
			}
		});
		$(document).on('click','.addBtn',function() {
			var term_type=$(this).attr('data-term_type');
				
			if (term_type=='termly') {			
				$.post('ajax/formteacher-process.php',{add_termly_Comment:'add_termly_Comment'},
					function(data) {
						if (data>0) {
							if (confirm("Add comment to "+data+" Students?")) {
								window.location.href="form-teacher-comment?termDDD=termly";
							}
						}else{
							$('#error_feed').fadeIn(150).text('Result not approved yet.').delay(10000).fadeOut(50);
						}
					});
			}else{		
				$.post('ajax/formteacher-process.php',{add_annual_Comment:'add_annual_Comment'},
					function(data) {
						if (data>0) {
							if (confirm("Add comment to "+data+" Students?")) {
								window.location.href="form-teacher-comment?termDDD=annual";
							}
						}else{
							$('#error_feed').fadeIn(150).text('Annual result not approved yet.').delay(10000).fadeOut(50);
						}
					});			

			}
		});





	});
})();