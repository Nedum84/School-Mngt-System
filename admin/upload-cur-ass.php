<?php include_once 'inc/header.inc.php';?>

		<title>Uploads</title>
		<div class="contents">
			<div id="welcome" class="home_welcome">
				<h4>Upload Curriculum/Assignment</h4>
			</div>
		<center class="white_background">
			<div class="curriculum_result_wrapper">
				<div class="cur_res_div">
					<button class="btnEffects uploadSelected upload_cur" id="addNews"  data-show="add_result_form_online">
			            <div class="btnIcon_info"><i class="fa fa-file-audio-o"></i></div><div class="btnDetail_info">
			              <h4>Upload Curriculum</h4>
			              <div class="progress_div"><div class="progress-bar" style="width: 70%"></div></div>
			              <span class="progress-description">Upload the curriculum</span>
			            </div>
			          </button>
			          <button class="btnEffects upload_ass" id="addNews" data-show="add_result_form">
			            <div class="btnIcon_info"><i class="fa fa-file-audio-o"></i></div><div class="btnDetail_info">
			              <h4>Upload Assignment</h4>
			              <div class="progress_div"><div class="progress-bar" style="width: 70%"></div></div>
			              <span class="progress-description">Upload the assignment</span>
			            </div>
			          </button>

				</div>
				
				<div class="res_cur">
					<!-- corricolum			 -->
					<div class="curriculum" style="display: block;">
						<div class="inputss">
							<h4>Curriculum upload selected</h4>
							<form enctype="multipart/form-data" method="post" id="add_curriculum_form" class="add_curriculum_form">
								<div class="input_div">
									<label for="cur_teachers_id">Teachers ID</label>
									<input type="text" id="cur_teachers_id" placeholder="Eg: <?php echo ("T/".$schDetails['school_code']."/212"); ?>" name="c_teachers_id" style="text-transform: uppercase;">
									<span class="error"></span>
								</div>
								<div class="input_div">
									<label for="cur_class">Class</label>
									<select id="cur_class" name="c_class">
										<option value="none">Class</option>
										<option value="jss1">JSS1</option>
										<option value="jss2">JSS2</option>
										<option value="jss3">JSS3</option>
										<option value="sss1">SSS1</option>
										<option value="sss2">SSS2</option>
										<option value="sss3">SSS3</option>
									</select>
									<span class="error"></span>
								</div>
								<div class="input_div">
									<label for="subject">Subject</label>
									<select id="subject" class="subject_drop" name="c_subject"></select>
									<span class="error"></span>
								</div>
								<div class="input_div">
									<label for="term">Term</label>
									<select id="term" name="c_term">
										<?php termSelect(); ?>
									</select>
									<span class="error" id="term_error"></span>
								</div>
								<div class="input_div">
									<label for="session">session</label>
									<select id="session" name="c_session" class="session_drop_wait">
										<?php sessionSelect(); ?>
									</select>
									<span class="error" id="session_error"></span>
								</div>
								<div class="input_div">
									<label for="upload_cur_input">Select .pdf/docx curriculum file</label>
									<label for="upload_cur_input" id="browse_label"><i class="fa fa-file-pdf-o"></i> Browse Curriculum</label>
									<input type="file" id="upload_cur_input" name="upload_cur_input">
									<span class="error" id="file_error"></span>
								</div>
								<div class="input_div" style="width: 100%;font-size: 1.1em;">
									<button id="add_curriculum" type="submit" name="add_curriculum" style="min-height: 50px;"> <i class="fa fa-upload"></i> Upload Curriculum</button>
									<span class="error" id="curriculum_error"></span>
								</div>
							</form>
						</div>
						<div class="uploaded_files">
							<h5>Uploaded Curriculum</h5>
							<div class="show_c_uploaded" id="show_c_uploaded">
<!-- 									<div class="c_cols">
										<h4>Curriculum JSS1</h4>
										<p><span>Term: </span> First Term</p>
										<p><span>Session: </span> 2016/2017</p>
										<p>
											<button class="c_view"> <i class="fa fa-eye"></i> View</button> 
											<button class="c_delete"> <i class="fa fa-trash-o"></i> Delete</button>
										</p>
									</div>
									<div class="c_cols">
										<h4>Curriculum JSS1</h4>
										<p><span>Term: </span> First Term</p>
										<p><span>Session: </span> 2016/2017</p>
										<p>
											<button class="c_view"> <i class="fa fa-eye"></i> View</button> 
											<button class="c_delete"> <i class="fa fa-trash-o"></i> Delete</button>
										</p>
									</div> -->
							</div>
						</div>
					</div>		
					<!-- Assignment			 -->
					<div class="assignment">
						<div class="inputss">
							<h4>Assignment upload selected</h4>
							<form enctype="multipart/form-data" method="post" id="add_assignment_form">
								<div class="input_div">
									<label for="ass_teachers_id">Teachers ID</label>
									<input type="text" id="ass_teachers_id" placeholder="Eg: <?php echo ("T/".$schDetails['school_code']."/212"); ?>" name="a_teachers_id" style="text-transform: uppercase;">
									<span class="error"></span>
								</div>
								<div class="input_div">
									<label for="ass_class">Class</label>
									<input type="text" id="ass_class" placeholder="Eg: JSS1B OR JSS1" name="ass_class">
									<span class="error"></span>
								</div>
								<div class="input_div">
									<label for="subject">Subject</label>
									<select id="subject" class="subject_drop" name="ass_subject"></select>
									<span class="error"></span>
								</div>
								<div class="input_div">
									<label for="term">Term</label>
									<select id="term" name="ass_term">
										<?php termSelect(); ?>
									</select>
									<span class="error" id="term_error"></span>
								</div>
								<div class="input_div">
									<label for="session">session</label>
									<select id="session" name="ass_session" class="session_drop_wait">
										<?php sessionSelect(); ?>
									</select>
									<span class="error" id="session_error"></span>
								</div>
								<div class="input_div">
									<label for="upload_ass_input">Select .pdf/docx assignment file</label>
									<label for="upload_ass_input" id="browse_label"><i class="fa fa-file-pdf-o"></i> Browse Assignment</label>
									<input type="file" id="upload_ass_input" name="upload_ass_input">
									<span class="error" id="ass_file_error"></span>
								</div>
								<div class="input_div" style="width: 100%;font-size: 1.1em;">
									<button id="add_assignment" type="submit" name="add_assignment" style="min-height: 50px;"> <i class="fa fa-upload"></i> Upload Assignment</button>
									<span class="error" id="assignment_error"></span>
								</div>
							</form>
						</div>
						<div class="uploaded_files">
							<h5>Uploaded Assignment</h5>
							<div class="show_ass_uploaded" id="show_ass_uploaded">
<!-- 									<div class="ass_cols">
										<h4>Curriculum JSS1</h4>
										<p><span>Term: </span> First Term</p>
										<p><span>Session: </span> 2016/2017</p>
										<p>
											<button class="ass_view"> <i class="fa fa-eye"></i> View</button> 
											<button class="ass_delete"> <i class="fa fa-trash-o"></i> Delete</button>
										</p>
									</div>
									<div class="ass_cols">
										<h4>Curriculum JSS1</h4>
										<p><span>Term: </span> First Term</p>
										<p><span>Session: </span> 2016/2017</p>
										<p>
											<button class="ass_view"> <i class="fa fa-eye"></i> View</button> 
											<button class="ass_delete"> <i class="fa fa-trash-o"></i> Delete</button>
										</p>
									</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</center>

		</div>
		
<?php include_once 'inc/footer.inc.php'; ?>

<script type="text/javascript">
	(function() {
		$(document).ready(function() {

			//submit on change of the teachers name selection
			$(document).on('change select','#res_teachers_id',function() {
				var resultId = $(this).val();
				window.location.href="teachers-upload?resultId="+encodeURIComponent(resultId);
			});

			//Real time Update TOTAL SCORE AND GRADE details
			$(document).on('keyup focus','tr.editable td',function() {
				var r_Id=$(this).attr('data-r_id').trim();

				var curCA 	=parseInt($('tr#'+r_Id+' td[data-type=ca_score]').text().trim());
				var curExam =parseInt($('tr#'+r_Id+' td[data-type=exam_score]').text().trim());
				var st_total=curCA+curExam;
				$('tr#'+r_Id+' td[data-type=st_total]').text(st_total);
				// alert(st_total)
				$.post('ajax/exam-process.php',{st_total:st_total},function(data) {
					$('tr#'+r_Id+' td[data-type=st_grade]').text(data);
				});
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

		    	studentsResults=JSON.stringify(studentsResults);
		    	resultDetails=JSON.stringify(resultDetails);

		    	$.post('ajax/upload-process.php',
	    				{studentsResults:studentsResults,
	    				resultDetails:resultDetails
	    				},function(data) {			
		  					$('.feedback').html(data);
		  					$('#add_result_form')[0].reset();
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

		    	$.post('ajax/upload-process.php',
	    				{deleteResultDetails:deleteResultDetails},function(data) {

		  					$('.feedback').html(data);
		      				$('#result_exist_form_delete button[type=submit]').removeAttr('disabled').removeClass('addBtnOpacity')
		      				.html('<i class="fa fa-upload"></i> Upload Result');


		        	});

			});

		});
	})();
</script>