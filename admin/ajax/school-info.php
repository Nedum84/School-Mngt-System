<?php 
include_once("../inc/functions.inc.php");

//edit subjects
if (isset($_POST['sub_edit_input'])) {
	$sub_edit_input=sanitize(strtolower($_POST['sub_edit_input']));
	$sub_edit_input_id=sanitize($_POST['sub_edit_input_id']);

	if (empty($sub_edit_input)) {
		echo "Enter the subject";
	}elseif (checkExist("*","subjects","subject",$sub_edit_input)) {
		echo "Subject already added";
	}else{
		$update_sub=mysqli_query($mysqli,"UPDATE subjects SET subject='$sub_edit_input' WHERE subject_code='{$sub_edit_input_id}'");
		if ($update_sub) {
			echo "<p class='success'> Subject edited successfully</p>";
		}

	}

}
//add subjects 
if (isset($_POST['sub_add_input'])) {
	$sub_add_input=sanitize($_POST['sub_add_input']);

	if (empty($sub_add_input)) {
		echo "Enter the subject";
	}elseif (checkExist("*","subjects","subject",$sub_add_input)) {
		echo "Subject already added";
	}else{
		$add_sub=mysqli_query($mysqli,"INSERT INTO subjects(subject) VALUES('{$sub_add_input}') ");
		if ($add_sub) {
			echo "<p class='success'> Subject added successfully</p>";
		}

	}

}

//feeding back subjects
if (isset($_POST['feed_back_subjects'])) {
	$get_subjects=(mysqli_query($mysqli,"SELECT * FROM subjects "));
			while ($s=mysqli_fetch_assoc($get_subjects)) {
		?>
		<div class="each_val">
			<span style="display: ;"><?php echo $s['subject_code']; ?>. 
				<?php echo ucwords($s['subject']); ?>:</span>
			&nbsp;
			<a href="view-school-subjects?<?php echo(md5($s['subject'])) ?>" 
				class="edit_each_subject" data-subject="<?php echo(ucwords($s['subject'])); ?>" data-sub_id="<?php echo($s['subject_code']) ?>">
				<i class="fa fa-pencil"> </i>Edit <?php echo ucwords($s['subject']); ?>
			</a>
		</div>

		<?php }

		echo '
		<div class="user_input">
			<button class="btn btn-info" id="add_subject">Add Subject</button>
		</div>';
}



?>