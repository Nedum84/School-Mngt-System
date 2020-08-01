<?php
include("inc/header.inc.php");
	if ($status!="teachers") {
		header('Location:home');
	}
?>
	<title>Upload Result Curriculum and Assignment</title>
	<div class="left_divs">
		<?php include 'inc/left_menu.inc.php'; ?>
	</div><!-- 
	--><div class="contents">
		<center>
			<div class="curriculum_result_wrapper">
				<h4>Carefully upload your curriculum/result</h4>
				<div class="cur_res_div">
					<button class="upload_res" data-show="result">Upload Result</button>
					<button class="upload_cur" data-show="curriculum">Upload Curriculum</button>
					<button class="upload_ass" data-show="assignment">Upload Assignment</button>
				</div>
				<div class="res_cur">
					<!-- result -->
					<div class="result">
						<div class="inputss">
							<h4>Result upload selected</h4>
							<form enctype="multipart/form-data" method="post" id="add_result_form">

								<input type="hidden" id="res_teachers_id" value=" <?php echo ($id); ?>" name="r_teachers_id">

								<div class="input_div">
									<label for="r_class">Class</label>
									<input type="text" id="r_class" placeholder="Eg: JSS1B" name="r_class">
									<span class="error"></span>
								</div>
								<div class="input_div">
									<label for="subject">Subject</label>
									<select id="input_subject" class="subject_drop"  name="r_subject"></select>
									<span class="error"></span>
								</div>
								<div class="input_div">
									<label for="term">Term</label>
									<select id="term" name="r_term">
										<?php termSelect(); ?>
									</select>
									<span class="error" id="term_error"></span>
								</div>
								<div class="input_div">
									<label for="session">session</label>
									<select id="session" name="r_session" class="session_drop_wait">
										<?php sessionSelect(); ?>
									</select>
									<span class="error" id="session_error"></span>
								</div>
								<div class="input_div">
									<label for="upload_res_input">carefully select .csv result file</label>
									<label for="upload_res_input" id="browse_label"><i class="fa fa-image"></i> Browse file</label>
									<input type="file" id="upload_res_input" name="upload_res_input">
									<span class="res_file_error error" id="res_file_error"></span>
								</div>
								<div class="input_div">
									<button id="add_result" type="submit" name="add_result"> <i class="fa fa-upload"></i> Upload Result</button>
									<span class="error" id="result_error"></span>
								</div>
							</form>
						</div>
						<div class="uploaded_files">
							<h5>Uploaded Results</h5>
							<div class="show_r_uploaded">
<!-- 								<div class="r_cols">
									<h4>Mathematics Result JSS1B</h4>
									<p><span>Term: </span> First Term</p>
									<p><span>Session: </span> 2016/2017</p>
									<p><button class="r_edit"> <i class="fa fa-pencil"></i> Edit</button></p>
								</div>
								<div class="r_cols">
									<h4>Mathematics Result JSS3E</h4>
									<p><span>Term: </span> First Term</p>
									<p><span>Session: </span> 2016/2017</p>
									<p><button class="r_edit"> <i class="fa fa-pencil"></i> Edit</button></p>
								</div> -->
							</div>
						</div>
					</div>		
					<!-- corricolum			 -->
					<div class="curriculum">
						<div class="inputss">
							<h4>Curriculum upload selected</h4>
							<form enctype="multipart/form-data" method="post" id="add_curriculum_form" class="add_curriculum_form">

								<input type="hidden" id="cur_teachers_id" value=" <?php echo ($id); ?>" name="c_teachers_id">

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
									<label for="upload_cur_input" id="browse_label"><i class="fa fa-image"></i> Browse file</label>
									<input type="file" id="upload_cur_input" name="upload_cur_input">
									<span class="error" id="file_error"></span>
								</div>
								<div class="input_div">
									<button id="add_curriculum" type="submit" name="add_curriculum"> <i class="fa fa-upload"></i> Upload Curriculum</button>
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

								<input type="hidden" id="ass_teachers_id" value=" <?php echo ($id); ?>" name="a_teachers_id">

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
									<label for="upload_ass_input" id="browse_label"><i class="fa fa-image"></i> Browse file</label>
									<input type="file" id="upload_ass_input" name="upload_ass_input">
									<span class="error" id="ass_file_error"></span>
								</div>
								<div class="input_div">
									<button id="add_assignment" type="submit" name="add_assignment"> <i class="fa fa-upload"></i> Upload Assignment</button>
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
</div>

<?php
include("inc/footer.inc.php");
?>
<script type="text/javascript">
	$(document).ready(function() {
		// $(document).on('click','.c_view',function() {
		// 	var curViewPath=$(this).attr('data-viewPath');
		// 	<?php
		// 		header('Content-Type:application/pdf');
		// 		header('Content-Disposition:Attachment;filename="Aptech-Ebook.pdf"');
		// 		readfile('curriculum-upload/'.$curViewPath);
		// 	?>
		// });
	})
</script>
<script type="text/javascript" src="js/upload.js"></script>
<div id="error_feed"></div>
</body>
</html>