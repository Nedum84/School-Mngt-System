<!-- student upload -->
<center>
	<div id="st_add_modal" class="st_teachers_modal">
		<div class="modal_header"><span class="modal_close">&times;</span></div>
		<form enctype="multipart/form-data" method="post" id="st_upload_form">
			<label for="st_file_input" id="browse_label" class="browse_label">
				<i class="fa fa-image"></i> Browse the student register file</label>
			<input type="file" class="st_file_input"  id="st_file_input" name="st_file">
			<span class="warning_s">Select the excel(.csv) student register file.</span>
			<div class="modal_footer">
				<button id="footer_upload_button" type="submit">
					<i class="fa fa-upload"></i><span> Upload</span>
				</button>
				<button id="footer_close_button" class="modal_close">
					<i class="fa fa-times"></i><span> close</span>
				</button>
			</div>
		</form>
	</div>
</center>
<!-- student register -->
<center>
	<div id="st_register_modal" class="st_teachers_modal">
		<div class="modal_header"><span class="modal_close">&times;</span></div>
		<form enctype="multipart/form-data" method="post" id="st_register_form">
			<h4>Register new student.</h4>
			<label for="register_st_id">Student Identity.</label>
			<input type="text" class="register_st_id"  id="register_st_id" placeholder="Enter student ID" name="register_st_id">
			<label for="register_st_name">Student full name.</label>
			<input type="text" placeholder="Enter student full name" class="register_st_name"  id="register_st_name" name="register_st_name">
			<label for="register_st_class">Student class.</label>
			<input type="text" placeholder="Enter student class if any" class="register_st_class"  id="register_st_class" name="register_st_class">
			<div class="er">
				<span class="warning_st_r"></span>
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
	</div>
</center>
<!-- teachers upload -->
<center>
	<div id="t_add_modal" class="st_teachers_modal">
		<div class="modal_header"><span class="modal_close">&times;</span></div>
		<form enctype="multipart/form-data" method="post" id="t_upload_form">
			<label for="t_file_input" id="browse_label" class="browse_label">
				<i class="fa fa-image"></i> Browse the student teachers file</label>
			<input type="file" class="t_file_input"  id="t_file_input" name="t_file">
			<span class="warning_s">Select the excel(.csv) teacher register file.</span>
			<div class="modal_footer">
				<button id="footer_upload_button" type="submit">
					<i class="fa fa-upload"></i><span> Upload</span>
				</button>
				<button id="footer_close_button" class="modal_close">
					<i class="fa fa-times"></i><span> close</span>
				</button>
			</div>
		</form>
	</div>
</center>
<!-- teachers register -->
<center>
	<div id="t_register_modal" class="st_teachers_modal">
		<div class="modal_header"><span class="modal_close">&times;</span></div>
		<form enctype="multipart/form-data" method="post" id="t_register_form">
			<h4>Register new Teacher.</h4>
			<label for="register_t_id">Teacher Identity.</label>
			<input type="text" class="register_t_id"  id="register_t_id" placeholder="Enter teacher ID" name="register_t_id">
			<label for="register_t_name">Teacher full name.</label>
			<input type="text" placeholder="Enter teacher full name" class="register_t_name"  id="register_t_name" name="register_t_name">
			<label for="register_t_class">Teacher class(For form teachers).</label>
			<input type="text" placeholder="Enter your class/no of subject" class="register_t_class"  id="register_t_class" name="register_t_class">
			<div class="er">
				<span class="warning_st_r"></span>
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
	</div>
</center>
<!-- add news by principal-->
<center>
	<div id="add_news" class="st_teachers_modal" style="position: absolute;">
		<div class="modal_header"><span class="modal_close">&times;</span></div>
		<form enctype="multipart/form-data" method="post" id="add_news_form">
			<h4>Add news to show in the landing page for everybody to view.</h4>
			<label for="news_subject">News Subject/Heading.</label>
			<input type="text" class="news_subject"  id="news_subject" placeholder="Enter news subject" name="news_subject">
			<label for="addnews_textarea">Write the news.</label>
			<textarea id="addnews_textarea" name="addnews_textarea" placeholder="Enter the news."></textarea>
			<label for="news_image" id="browse_label" class="browse_label">
				<i class="fa fa-image"></i> Add Image</label>
			<input type="file" class="news_image"  id="news_image" name="news_image">
			<div class="er">
				<span class="add_news_error error"></span>
			</div>

			<div class="modal_footer">
				<button id="footer_register_button" type="submit">
					<i class="fa fa-plus"></i><span> Add News</span>
				</button>
				<button id="footer_close_button" class="modal_close">
					<i class="fa fa-times"></i><span> close</span>
				</button>
			</div>
		</form>
	</div>
</center>
<!-- view news -->
<center>
	<div id="view_news" class="st_teachers_modal" style="position: absolute;">
		<div class="modal_header"><span class="modal_close">&times;</span></div>
		<div class="news_body">
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
	</div>
</center>
<!-- notify Student -->
<center>
	<div id="notify_students_modal" class="st_teachers_modal">
		<div class="modal_header"><span class="modal_close">&times;</span></div>
		<form enctype="multipart/form-data" method="post" id="add_news_form">
			<h4>Notify all the students.</h4>
			<label for="notify_student_textarea">Write the notification.</label>
			<textarea id="notify_student_textarea" placeholder="Enter the students notification."></textarea>

			<div class="er">
				<span class="notify_student_error error"></span>
			</div>

			<div class="modal_footer">
				<button id="notify_student_button" type="submit">
					<i class="fa fa-info"></i><span> Notify Students</span>
				</button>
				<button id="footer_close_button" class="modal_close">
					<i class="fa fa-times"></i><span> close</span>
				</button>
			</div>
		</form>
	</div>
</center>
<!-- notify teachers -->
<center>
	<div id="notify_teachers_modal" class="st_teachers_modal">
		<div class="modal_header"><span class="modal_close">&times;</span></div>
		<!-- <form enctype="multipart/form-data" method="post" id="add_news_form"> -->
			<h4>Notify all the Teachers.</h4>
			<label for="notify_teachers_textarea">Write the notification.</label>
			<textarea id="notify_teachers_textarea" placeholder="Enter the teachers notification."></textarea>

			<div class="er">
				<span class="notify_teacher_error error"></span>
			</div>

			<div class="modal_footer">
				<button id="notify_teacher_button" type="submit">
					<i class="fa fa-info"></i><span> Notify Teachers</span>
				</button>
				<button id="footer_close_button" class="modal_close">
					<i class="fa fa-times"></i><span> close</span>
				</button>
			</div>
		<!-- </form> -->
	</div>
</center>
<!-- view sent notifications -->
<center>
	<div id="sent_n_modal" class="st_teachers_modal" style="position: absolute;overflow: auto;max-height: 500px;">
		<div class="modal_header"><span class="modal_close">&times;</span></div>
		<div class="news_body">
			<div class="sent_n_fill">
			</div>

			<div class="modal_footer">
				<button id="footer_close_button" class="modal_close">
					<i class="fa fa-times"></i><span> close</span>
				</button>
			</div>
		</div>
	</div>
</center>