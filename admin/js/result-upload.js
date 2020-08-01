(function() {
	$(document).ready(function () {
		$(document).ajaxStart(function () {
			//$('#loader').show(); show_opacity();
		}).ajaxStop(function () {
			//$('#add_result').removeAttr('disabled').removeClass('addBtnOpacity').html('<i class="fa fa-upload"></i> Upload Result');
		});
		//result curriculum toogle
		$('.contents .curriculum_result_wrapper .cur_res_div button').on('click',function() {

			$('.contents .curriculum_result_wrapper .cur_res_div button').removeClass('uploadSelected');
			var current_Class=$(this).attr('class');
			$(this).addClass('uploadSelected');

			var current_Show=$(this).attr('data-show');
			$('.contents .curriculum_result_wrapper .res_cur form').css('display','none');
			$('.contents .curriculum_result_wrapper .res_cur form#'+current_Show).css('display','block');

		});
		//checking path selections bw admin and portal
		if (window.location.href.indexOf('admin')!=-1) {
			var portalVal='./';
			var appendVal=2;
			var editResPath='teachers-edit-results?';
		}else{
			var portalVal='';
			var appendVal='';
			var editResPath='edit-results?';
		}

			// Online upload
			//Submitting the form on select of subject and class
		$(document).on('change select','.class_sub',function() {

			var teachers_id = $('#res_teachers_id').val();
			var teachers_sub = $('#teachers_sub').val();
			var teachers_class = $('#teachers_class').val();

			if (teachers_class!=""&&teachers_sub!="") {
				$('#add_result_form_online button').removeAttr('disabled');
			}else{
				$('#add_result_form_online button').attr('disabled','disabled');
			}
			$('#online_result_div').text('No Matched record(s) found...');
				
		});
		$(document).on('submit','#add_result_form_online',function(e) {
			e.preventDefault();
			var teachers_id = $('#res_teachers_id').val();
			var teachers_sub = $('#teachers_sub').val();
			var teachers_class = $('#teachers_class').val();
			
			if (teachers_class!=""&&teachers_sub!="") {
				$('#online_result_div').html('<i class="fa fa-refresh fa-spin"></i> Loading, please wait...');
				$.post('ajax/result-upload-process.php',
					{teachers_id:teachers_id
					,teachers_sub:teachers_sub
					,teachers_class:teachers_class}
					,function (data) {
						if (data.indexOf('Delete?')!=-1) {
				      		$('.modal_wrapper').css({'display':'block'});
							$('.modal_container').html(data);

						}else{
							$('#online_result_div').html(data);
							resFeedBack();
						}
					}
				);
			};
				
		});
		//Update details (Online result )
		// for ca and exam scores
		$(document).on('blur','tr.editable td',function() {
			var type=$(this).attr('data-type').trim();
			var r_Id=$(this).attr('data-r_id').trim();
			var dValue=$(this).text().trim().toLowerCase();
			if (type!='edit_no_of_s') {
				$.post('ajax/result-upload-process.php',{type:type,r_Id:r_Id,dValue:dValue},function(data) {
					$('#error_feed').addClass('bg-success').fadeIn(100).text(data).delay(2000).fadeOut(50);
				});
			};
		});
		//Real time Update details (Online result )
		$(document).on('keyup focus','tr.editable td',function() {
			var r_Id=$(this).attr('data-r_id').trim();
			var curCA 	=parseInt($('tr#'+r_Id+' td[data-type=ca_score]').text().trim());
			var curExam =parseInt($('tr#'+r_Id+' td[data-type=exam_score]').text().trim());
			var st_total=parseInt(curCA+curExam);
			$('tr#'+r_Id+' td[data-type=st_total]').text(st_total);

			$.post('ajax/result-upload-process.php',{st_total:st_total},function(data) {
				$('tr#'+r_Id+' td[data-type=st_grade]').text(data);
			});
		});
		//Real time Update details (File upload table updates)
		$(document).on('keyup focus','tr.editable_file td',function() {
			var r_Id=$(this).attr('data-r_id').trim();
			var curCA 	=parseInt($('tr#'+r_Id+' td[data-type=ca_score]').text().trim());
			var curExam =parseInt($('tr#'+r_Id+' td[data-type=exam_score]').text().trim());
			var st_total=parseInt(curCA+curExam);
			$('tr#'+r_Id+' td[data-type=st_total]').text(st_total);

			$.post('ajax/result-upload-process.php',{st_total:st_total},function(data) {
				$('tr#'+r_Id+' td[data-type=st_grade]').text(data);
			});
		});


		
		//Result turn (File result)
		var form_result = _("add_result_form");
		form_result.addEventListener('submit', function(e) {
			$('#add_result').html('Uploading <i class="fa fa-spinner"></i>').addClass('addBtnOpacity').attr('disabled','disabled');
		    var result_feedBack = _("result_error");

		    var ajax = new XMLHttpRequest();
		    ajax.open("POST", portalVal+"ajax/result-upload-process.php", true);
		    ajax.onload = function(event) {
		      if (ajax.status == 200 && ajax.readyState == 4) {
		      	if (ajax.responseText.indexOf('close')!=-1) {
		      		
		      		$('.modal_wrapper').css({'display':'block'});
					$('.modal_container').html(ajax.responseText);
		      	}else{
		      		result_feedBack.innerHTML = ajax.responseText;
		      	}		        
		      } else {result_feedBack.innerHTML = "Error " + ajax.status + " occurred when trying to upload your file.<br \/>";}
		    
			    $('#add_result').removeAttr('disabled').removeClass('addBtnOpacity')
			    .html('<i class="fa fa-upload"></i> Upload Result');
		    
		    };


		    ajax.send(new FormData(form_result));
		    e.preventDefault();return false;
		  },false);

		//result feedback
		resFeedBack();
		function resFeedBack() {
			var resFeed='res'+appendVal;
			$.post('ajax/result-upload-process.php',
				{resFeed:resFeed},
				function(data) {
					$('.show_r_uploaded').html(data);
				})
		}
		//result edit
		$(document).on('click','.r_view',function() {
			var teachers_id=$(this).attr('data-teachers_id');
			var class_id=$(this).attr('data-class_id');
			var session_id=$(this).attr('data-session_id');
			var term_id=$(this).attr('data-term_id');
			var subject_id=$(this).attr('data-subject_id');

			var viewResultDetails = {
										"view_result_Class":class_id,
										"view_result_Subject":subject_id,
										"view_result_TeachersID":teachers_id,
										"view_result_Term":term_id,
										"view_result_Session":session_id
									}

	    	viewResultDetails=JSON.stringify(viewResultDetails);

	    	$.post('ajax/result-upload-process.php',
    				{viewResultDetails:viewResultDetails},function(data) {

		      		$('.modal_wrapper').css({'display':'block'});
					$('.modal_container').html(data);


	        });
		});

		//Select of result file
		$('#upload_res_input').on("change select", function() {
		  	var ext_array=$(this).val().split('.');
		  	ext=ext_array[(ext_array.length)-1];
		  	if (ext=='csv') {
		  		_('res_file_error').innerHTML="<span class='text-success'>Result selected.</span>";
		  	}else{
		  		_('res_file_error').innerHTML="Invalid file formate. Upload .csv result file.";
		  	}
		  });

		//submit on change of the teachers name selection
		$(document).on('change select','#res_teachers_id',function() {
			var resultId = $(this).val();
			window.location.href="result-upload?resultId="+encodeURIComponent(resultId);
		});

		// Form teacher class register
		$(document).on('submit','#result_upload_form',function(e) {
			$('#upload_resultBTN').html('Uploading <i class="fa fa-refresh fa-spin"></i>')
			.addClass('addBtnOpacity').attr('disabled','disabled');
			e.preventDefault();

			var r_teachers_id 	=$('#result_upload_form input[id=r_teachers_id]').val();
			var res_subject 	=$('#result_upload_form input[id=res_subject]').val();
			var res_class 		=$('#result_upload_form input[id=res_class]').val();
			var res_term 		=$('#result_upload_form input[id=res_term]').val();
			var res_session 	=$('#result_upload_form input[id=res_session]').val();

			var studentsResults ={};
			var resultDetails = {
									"result_Class":res_class,
									"result_Subject":res_subject,
									"result_TeachersID":r_teachers_id,
									"result_Term":res_term,
									"result_Session":res_session
								}

	    	$('#result_upload_form table tbody tr').each(function  () {
	    		// if ($(this).is(":checked")) {

	    			var row_ID		=$(this).attr('id');
	    			var student_id 	=$(this).children('td[data-type=student_id]').text().trim();
	    			var st_curCA 	=parseInt($(this).children('td[data-type=ca_score]').text().trim());
					var st_curExam 	=parseInt($(this).children('td[data-type=exam_score]').text().trim());
					var st_total 	=parseInt($(this).children('td[data-type=st_total]').text().trim());
					var st_grade 	=$(this).children('td[data-type=st_grade]').text().trim();

	    			studentsResults[row_ID]={
											"student_id":student_id,
											"st_curCA":st_curCA,
											"st_curExam":st_curExam,
											"st_total":st_total,
											"st_grade":st_grade
										}
	    		// };
	    	});

	    	studentsResults =JSON.stringify(studentsResults);
	    	resultDetails 	=JSON.stringify(resultDetails);

	    	$.post('ajax/result-upload-process.php',
    				{studentsResults:studentsResults,
    				resultDetails:resultDetails
    				},function(data) {			
	  					$('.feedback').html(data);
	  					$('#add_result_form')[0].reset();
	  					resFeedBack();
	      				$('#upload_resultBTN').removeAttr('disabled').removeClass('addBtnOpacity')
	      				.html('<i class="fa fa-upload"></i> Upload Result');


	        	});
		});
		//Deleting already uploaded result
		$(document).on('submit','#result_exist_form_delete',function(e) {
			$('#result_exist_form_delete button[type=submit]').html('Deleting <i class="fa fa-spinner fa-spin"></i>')
			.addClass('addBtnOpacity').attr('disabled','disabled');
			e.preventDefault();


			var r_teachers_id 	=$('#result_exist_form_delete input[id=r_teachers_id]').val();
			var res_subject 	=$('#result_exist_form_delete input[id=res_subject]').val();
			var res_class 		=$('#result_exist_form_delete input[id=res_class]').val();
			var res_term 		=$('#result_exist_form_delete input[id=res_term]').val();
			var res_session 	=$('#result_exist_form_delete input[id=res_session]').val();

			var deleteResultDetails = {
										"delete_result_Class":res_class,
										"delete_result_Subject":res_subject,
										"delete_result_TeachersID":r_teachers_id,
										"delete_result_Term":res_term,
										"delete_result_Session":res_session
									}

	    	deleteResultDetails=JSON.stringify(deleteResultDetails);

	    	$.post('ajax/result-upload-process.php',
    				{deleteResultDetails:deleteResultDetails},function(data) {

	  					$('.feedback').html(data);
	      				$('#result_exist_form_delete button[type=submit]').removeAttr('disabled').removeClass('addBtnOpacity')
	      				.html('<i class="fa fa-upload"></i> Upload Result');


	        });

		});
		function _(x){
			return document.getElementById(x);
		}
	});
})();