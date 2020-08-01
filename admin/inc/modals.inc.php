<!-- view uploaded img -->
<center>
	<div class="modal_wrapper">
		<div class="remove_header"><span class="modal_close">&times;</span></div>
		<div class="modal_position">
			<div id="uploaded_pictures_body" class="modal_body">
				<div class="modal_header"><span class="modal_close">&times;</span></div>
				<div class="modal_container">
					<!-- register student -->
					<form enctype="multipart/form-data" method="post" id="st_register_form" style="display: none;">
						<h4>Register new student</h4>							
						<div>
							<label for="register_st_name">Student full name.</label>
							<input type="text" placeholder="Enter student full name" class="register_st_name"  id="register_st_name" name="register_st_name">
						</div>							
						<div>
							<label for="register_st_class">Student class.</label>
							<input type="text" placeholder="Enter student class" class="register_st_class"  id="register_st_class" name="register_st_class">
						</div>
						<div>
							<label for="register_st_id">Student Identity.</label>
							<input type="text" class="register_st_id"  id="register_st_id" placeholder="Enter student ID" name="register_st_id">
						</div>
							

						<div class="er">
							<span class="feedback">Carefully enter the student's class</span>
						</div>
						<div class="modal_footer">
							<button id="st_register_button" type="submit">
								<i class="fa fa-upload"></i><span> Register</span>
							</button>
							<button id="footer_close_button" class="modal_close">
								<i class="fa fa-times"></i><span> close</span>
							</button>
						</div>
					</form>

					<!-- upload student -->
					<form enctype="multipart/form-data" method="post" id="st_upload_form" style="display: none;">
						<h4>Upload Students</h4>
						<label for="st_file_input" id="browse_label" class="browse_label">
							<i class="fa fa-file-excel-o"></i> Browse the student register file</label>
						<input type="file" class="st_file_input"  id="st_file_input" name="st_file">

						<span class="feedback">Select the excel (.csv) student's register file that contains two compulsory columns of student's class (s) and their full names respectively</span>

						<div class="modal_footer">
							<button id="st_upload_button" type="submit">
								<i class="fa fa-upload"></i><span> Upload</span>
							</button>
							<button id="footer_close_button" class="modal_close">
								<i class="fa fa-times"></i><span> close</span>
							</button>
						</div>
					</form>

					<!-- register teachers -->
					<form enctype="multipart/form-data" method="post" id="t_register_form" style="display: none;">
						<h4>Register new Teacher</h4>

						<div>
							<label for="register_t_name">Teacher full name</label>
							<input type="text" placeholder="Enter teacher full name" class="register_t_name"  id="register_t_name" name="register_t_name">
						</div>							

						<div>
							<label for="register_t_year">Teacher's Year of Entrance to the school</label>
							<input type="text" placeholder="e.g 2013" class="register_t_year"  id="register_t_year" name="register_t_year">
						</div>

						<div>
							<label for="register_t_id">Teacher Identity</label>
							<input type="text" class="register_t_id"  id="register_t_id" placeholder="Enter teacher ID" name="register_t_id">
						</div>						

						<div class="er">
							<span class="feedback">Enter the teacher's year of entrance and full name of the teacher.</span>
						</div>
						<div class="modal_footer">
							<button id="footer_register_button" type="submit">
								<i class="fa fa-upload"></i><span> Register</span>
							</button>
							<button id="footer_close_button" class="modal_close">
								<i class="fa fa-times"></i><span> close</span>
							</button>
						</div>
					</form>

					<!-- upload teachers -->
					<form enctype="multipart/form-data" method="post" id="t_upload_form" style="display: none;">
						<h4>Upload Teachers</h4>
						<label for="t_file_input" id="browse_label" class="browse_label">
							<i class="fa fa fa-file-excel-o"></i> Browse the teachers register file</label>
						<input type="file" class="t_file_input"  id="t_file_input" name="t_file">

						<span class="feedback">Select the excel (.csv) teacher's register file that contains a compulsory column for teacher's full names and optional column for their year of entrance to this institution</span>

						<div class="modal_footer">
							<button id="t_upload_button" type="submit">
								<i class="fa fa-upload"></i><span> Upload</span>
							</button>
							<button id="footer_close_button" class="modal_close">
								<i class="fa fa-times"></i><span> close</span>
							</button>
						</div>
					</form>

					<!-- view uploaded news -->
					<div style="display: none;" id="view_uploaded_news">
						<div class="news_info_fill"></div>
						<div class="modal_footer">
							<button class="news_delete_button" type="submit">
								<i class="fa fa-trash"></i><span> Delete</span>
							</button>
							<button id="footer_close_button" class="modal_close">
								<i class="fa fa-times"></i><span> close</span>
							</button>
						</div>
					</div>

					<!-- notify student -->
					<form enctype="multipart/form-data" method="post" id="notify_st_form" style="display: none;">
						<h4>Notify students</h4>

						<label for="notify_student_textarea">Write the notification.</label>
						<textarea style="width: 100%;" id="notify_student_textarea" placeholder="Enter the students notification."></textarea>

						<div class="er">
							<span class="feedback"></span>
						</div>

						<div class="modal_footer">
							<button id="notify_student_button" type="submit">
								<i class="fa fa-send"></i><span> Notify Students</span>
							</button>
							<button id="footer_close_button" class="modal_close">
								<i class="fa fa-times"></i><span> close</span>
							</button>
						</div>
					</form>
						
					<!-- notify teachers -->
					<form enctype="multipart/form-data" method="post" id="notify_t_form" style="display: none;">
						<h4>Notify Teachers</h4>

						<label for="notify_teachers_textarea">Write the notification.</label>
						<textarea id="notify_teachers_textarea" placeholder="Enter the teacher's notification."></textarea>

						<div class="er">
							<span class="feedback"></span>
						</div>

						<div class="modal_footer">
							<button id="notify_teacher_button" type="submit">
								<i class="fa fa-send"></i><span> Notify Teachers</span>
							</button>
							<button id="footer_close_button" class="modal_close">
								<i class="fa fa-times"></i><span> close</span>
							</button>
						</div>
					</form>

					<!-- view sent notification -->
					<div class="view_notification" id="view_notification" style="display: none;">
						<div class="sent_n_fill"></div>

						<div class="modal_footer">
							<button id="footer_close_button" class="modal_close">
								<i class="fa fa-times"></i><span> close</span>
							</button>
						</div>
					</div>

					<!-- Add subject -->
					<form method="post" id="add_sub_form" style="display: none;">
						<h4>Add Subject</h4>

						<label for="sub_add_input">Subject</label>
						<input type="text" class="sub_add_input"  id="sub_add_input" placeholder="Enter the subject" name="sub_add_input">

						<div class="er">
							<span class="feedback"></span>
						</div>

						<div class="modal_footer">
							<button id="notify_student_button" type="submit">
								<i class="fa fa-check"></i><span> Add Subject</span>
							</button>
							<button id="footer_close_button" class="modal_close">
								<i class="fa fa-times"></i><span> close</span>
							</button>
						</div>
					</form>

					<!-- edit subject -->
					<form method="post" id="edit_sub_form" style="display: none;">
						<h4>Edit Subject</h4>

						<label for="sub_edit_input">Subject</label>
						<input type="text" class="sub_edit_input"  id="sub_edit_input" placeholder="Edit the subject" name="sub_edit_input">
						<input type="hidden" name="sub_edit_input_id">

						<div class="er">
							<span class="feedback"></span>
						</div>

						<div class="modal_footer">
							<button id="notify_student_button" type="submit">
								<i class="fa fa-check"></i><span> Add Subject</span>
							</button>
							<button id="footer_close_button" class="modal_close">
								<i class="fa fa-times"></i><span> close</span>
							</button>
						</div>
					</form>


				</div>
					
			</div>
		</div>

	</div>
</center>