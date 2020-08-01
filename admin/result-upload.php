<?php include_once 'inc/header.inc.php';?>
<?php 

if (isset($_GET['resultId'])) {
	$resultId=$_GET['resultId'];	
	$teachers_details=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id='$resultId' "));
}

?>
		<title>Uploads</title>
		<div class="contents">
			<div id="welcome" class="home_welcome">
				<h4>Result Upload Portal!</h4>
			</div>
		<center>
			<div class="curriculum_result_wrapper white_background">

				<div class="cur_res_div">
		          <button class="btnEffects uploadSelected" id="addNews"  data-show="add_result_form_online">
		            <div class="btnIcon_info"><i class="fa fa-file-audio-o"></i></div><div class="btnDetail_info">
		              <h4>Upload Online</h4>
		              <div class="progress_div"><div class="progress-bar" style="width: 70%"></div></div>
		              <span class="progress-description">Upload your results directly results online</span>
		            </div>
		          </button>
		          <button class="btnEffects" id="addNews" data-show="add_result_form">
		            <div class="btnIcon_info"><i class="fa fa-file-audio-o"></i></div><div class="btnDetail_info">
		              <h4>Upload File</h4>
		              <div class="progress_div"><div class="progress-bar" style="width: 70%"></div></div>
		              <span class="progress-description">Upload excel format of your result</span>
		            </div>
		          </button>

        
					<!-- <button class="upload_res_online uploadSelected" data-show="add_result_form_online"></button>
					<button class="upload_res_file"  data-show="add_result_form">Upload File</button> -->
				</div>
				<div class="res_cur">
					<!-- result -->
					<div class="result">
						<div class="inputss">
							<h4> <i class="fa fa-long-arrow-right"></i> UPLOADING RESULT <?php 
							echo "<span>".strtoupper($school_term." TERM"." 
							".$school_session." SESSION")."</span>"; 
						?></h4><hr>
							<!-- Online upload -->
							<form method="get" id="add_result_form_online">
								<span class="error" ><i class="text-success">
									Before uploading your Exam score, Carefully select the Teachers Name, Class and Subject</i>
								</span>

								<div class="input_div">
									<label for="res_teachers_id">Teacher's Name</label>
									<select name="res_teachers_id" id="res_teachers_id">		
										<?php 
										if (isset($resultId)&&!empty($resultId)) {
											echo '<option value="'.$resultId.'">'.strtoupper($teachers_details['name']).'</option>';
										}else{
											echo '<option value="">SELECT TEACHER</option>';
										}

										$get_teacher=mysqli_query($mysqli,"SELECT * FROM teachers WHERE status='0' ORDER BY id ASC ");
										while ($row=mysqli_fetch_assoc($get_teacher)) {
											echo '<option value="'.$row['teachers_id'].'">'.strtoupper($row['name']).'</option>';
										}
										?>
									</select>
								</div>
								<div class="input_div">
									<label for="r_class">Class</label>
									<select class="class_sub" id="teachers_class">		
										<?php 
										echo '<option value="">SELECT CLASS</option>';
										
										if (!empty($teachers_details['teaching_class'])) {
											$classArray=explode(',', $teachers_details['teaching_class']);
											foreach ($classArray as $value) {
												echo '<option value="'.$value.'">'.strtoupper($value).'</option>';
											}
										
										}
										?>
									</select>
								</div>
								<div class="input_div" style="width:100%">
									<label for="subject">Subject</label>
									<select class="class_sub" id="teachers_sub">
										<?php 
										echo '<option value="">SELECT SUBJECT</option>';
										
										if (!empty($teachers_details['teaching_subject'])) {
											$classArray=explode(',', $teachers_details['teaching_subject']);
											foreach ($classArray as $value) {
												$get_subject=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects WHERE subject_code='$value' "))['subject'];

												echo '<option value="'.$value.'">'.strtoupper($get_subject).'</option>';
											}
										
										}
										?>
									</select>
								</div>
								<div class="input_div" style="width: 100%;font-size: 1.1em;">
									<button id="add_result_online" disabled type="submit" style="min-height: 50px;">  <i class="fa fa-search"></i> Load Data</button>

								</div>

								<!-- feeding back students details for online uploading -->
								<hr>
								<div id="online_result_div"  class="student_table" style="text-align:center">

									No Matched record(s) found...

								</div>
								<hr>
							</form>
							<!-- File upload -->
							<form enctype="multipart/form-data" method="post" id="add_result_form" style="display:none">
								<!-- feedback error -->
								<span class="error" id="result_error"><i class="text-success">Carefully upload result(s) file here. Don't have a sample result sheet, download it <a href="result-sheet">here</a></i></span>

								<div class="input_div">
									<label for="res_teachers_id">Teacher's Name</label>
									<select name="r_teachers_id" id="res_teachers_id">
										<?php 
										if (isset($resultId)&&!empty($resultId)) {
											echo '<option value="'.$resultId.'">'.strtoupper($teachers_details['name']).'</option>';
										}else{
											echo '<option value="">SELECT TEACHER</option>';
										}

										$get_teacher=mysqli_query($mysqli,"SELECT * FROM teachers WHERE status='0' ORDER BY id ASC ");
										while ($row=mysqli_fetch_assoc($get_teacher)) {
											echo '<option value="'.$row['teachers_id'].'">'.strtoupper($row['name']).'</option>';
										}
										?>
									</select>
								</div>
								<div class="input_div">
									<label for="r_class">Class</label>
									<select class="class_sub" id="teachers_class" name="r_class">		
										<?php 
										echo '<option value="">SELECT CLASS</option>';
										
										if (!empty($teachers_details['teaching_class'])) {
											$classArray=explode(',', $teachers_details['teaching_class']);
											foreach ($classArray as $value) {
												echo '<option value="'.$value.'">'.strtoupper($value).'</option>';
											}
										
										}
										?>
									</select>
								</div>
								<div class="input_div">
									<label for="subject">Subject</label>

									<select class="class_sub" id="teachers_sub" name="r_subject">
										<?php 
										echo '<option value="">SELECT SUBJECT</option>';
										
										if (!empty($teachers_details['teaching_subject'])) {
											$classArray=explode(',', $teachers_details['teaching_subject']);
											foreach ($classArray as $value) {
												$get_subject=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects WHERE subject_code='$value' "))['subject'];

												echo '<option value="'.$value.'">'.strtoupper($get_subject).'</option>';
											}
										
										}
										?>
									</select>
								</div>
								<!-- <div class="input_div">
									<label for="term">Term</label>
									<select id="term" name="r_term">
										<?php termSelect(); ?>
									</select>
								</div>
								<div class="input_div">
									<label for="session">session</label>
									<select id="session" name="r_session" class="session_drop_wait">
										<?php sessionSelect(); ?>
									</select>
								</div> -->
								<div class="input_div">
									<label for="upload_res_input">carefully select .csv result file</label>
									<label for="upload_res_input" id="browse_label"><i class="fa fa-support fa-spin"></i> Browse Result</label>
									<input type="file" id="upload_res_input" name="upload_res_input">
									<span class="file_sel_feedback" id="res_file_error"> &nbsp;</span>
								</div>

								<div class="input_div" style="width: 100%;font-size: 1.1em;">
									<button id="add_result" type="submit" name="add_result" style="min-height: 50px;"> <i class="fa fa-upload"></i> Upload Result</button>

								</div>
								<hr>
							</form>
						</div>
						<!-- Previewing Uploaded result -->
						<div class="uploaded_files">
							<h5 class="bg-info text-white text-center"> <i class="fa fa-eye"></i> VIEW UPLOADED RESULT(S) BELOW!</h5>
							<hr>
							<div class="show_r_uploaded" style="text-align:">
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
					</div>	<!-- result div ends -->	
		

				</div>
			</div>
		</center>

		</div>
		
<?php include_once 'inc/footer.inc.php'; ?>