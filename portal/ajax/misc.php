<?php
//result,assignment and curiiculum feedback

include_once("../inc/connect.inc.php");
$id=$_SESSION['id'];

//subjects
if (isset($_POST['subject'])) {
	$sub_count=mysqli_query($mysqli,"SELECT * FROM subjects ORDER BY subject");
	$output="<option value='none'>Select Subject</option>";
	while ($row=mysqli_fetch_assoc($sub_count)) {
		$output.="<option value='".$row['subject_code']."'>".ucfirst($row['subject'])."</option>";
	}
	echo $output;
}

//feedback Curriculum
if (isset($_POST['curFeed'])) {
	$curFeed=trim($_POST['curFeed']);

	$session=$schDetails['school_session'];
	$term=strtolower($schDetails['school_term']);
	if ($curFeed == 'cur2') {
		$feedCount=mysqli_query($mysqli,"SELECT * FROM curriculum WHERE session='$session' AND class_term='$term' ORDER BY id DESC");
	}else{
		$feedCount=mysqli_query($mysqli,"SELECT * FROM curriculum WHERE teachers_id='$id' AND session='$session' AND class_term='$term' ORDER BY id DESC");
	}
	$curOutput='';
	while ($row=mysqli_fetch_assoc($feedCount)) {
	$main_subject	=strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects 
					WHERE subject_code ='{$row['subject']}'"))['subject']);
	$getTeacher		=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers 
					WHERE teachers_id ='{$row['teachers_id']}'"));
	$curOutput.='
				<div class="c_cols">
					<h4>Curriculum '.strtoupper($row['class']).'</h4>
					<p style="text-transform:capitalize"><span>Subject: </span> '.$main_subject.'</p>
					<p style="text-transform:capitalize"><span>Term: </span> '.$row['class_term'].' Term</p>
					<p><span>Session: </span> '.$row['session'].'</p>
					<p><span>Teacher: </span> '.ucwords($getTeacher['name']).'</p>
					<p>
						<button class="c_view" data-type="view" data-viewPath='.$row['file_path'].'> <i class="fa fa-eye"></i> View</button>
						<button class="c_delete" data-deleteId='.$row['id'].'> <i class="fa fa-trash-o"></i> Delete</button>
						<button class="c_download" data-type="download" data-viewPath='.$row['file_path'].'> <i class="fa fa-download"></i> Download</button>
					</p>
				</div>
				';
	}
	echo $curOutput;
}
if (isset($_POST['resFeed'])) {
	$resFeed=trim($_POST['resFeed']);

	$session=$schDetails['school_session'];
	$term=strtolower($schDetails['school_term']);
	if ($resFeed == 'res2') {
		$feedCount=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE session='$session' AND school_term='$term' ORDER BY result_id DESC");
	}else{
		$feedCount=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE teachers_id='$id' AND session='$session' AND school_term='$term' ORDER BY result_id DESC ");
	}

	$resOutput='';
	while ($row=mysqli_fetch_assoc($feedCount)) {

	$main_subject	=strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects 
					WHERE subject_code ='{$row['subject']}'"))['subject']);
	if (strpos($resOutput, $row['teachers_id'].'.'.$row['session'].'.'.$row['school_term'].'.'.$row['subject'].'.'.$row['class'])==true) { continue;}

	$stdNumber=mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM result_upload WHERE session='$session' AND school_term='$term' AND subject='{$row['subject']}' AND class='{$row['class']}' "));
	$getTeacher		=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers 
					WHERE teachers_id ='{$row['teachers_id']}'"));
	$resOutput.='
				<div class="r_cols">
					<h4><span style="text-transform:capitalize">'.$main_subject.'</span> Result '.strtoupper($row['class']).'</h4>
					<p style="text-transform:capitalize"><span>Term: </span> '.$row['school_term'].' Term</p>
					<p style="text-transform:capitalize"><span>Session: </span> '.$row['session'].'</p>
					<p style="text-transform:capitalize"><span>Number of students: </span> '.$stdNumber.'</p>
					<p><span>Teacher: </span> '.ucwords($getTeacher['name']).'</p>
					<p style="text-transform:lowercase;visibility: hidden;height:0px;">
					<span style="text-transform:capitalize">Result Id: </span> '.$row['teachers_id'].'.'
					.$row['session'].'.'.$row['school_term'].'.'.$row['subject'].'.'.$row['class'].'
					</p>
					<p><button class="r_edit" data-edit_id="'.$row['result_id'].'"
					 data-teachers_id="'.$row['teachers_id'].'"
					 data-class_id="'.$row['class'].'"
					 data-session_id="'.$row['session'].'"
					 data-term_id="'.$row['school_term'].'"
					 data-subject_id="'.$row['subject'].'">
					 <i class="fa fa-pencil"></i> Edit</button></p>
				</div>
				';
	}
	echo $resOutput;
}
if (isset($_POST['assFeed'])) {
	$assFeed=trim($_POST['assFeed']);

	$session=$schDetails['school_session'];
	$term=strtolower($schDetails['school_term']);
	if ($assFeed == 'ass2') {
		$feedCount=mysqli_query($mysqli,"SELECT * FROM assignment WHERE session='$session'  AND class_term='$term' ORDER BY id DESC");
	}else{
		$feedCount=mysqli_query($mysqli,"SELECT * FROM assignment WHERE teachers_id='$id' AND session='$session'  AND class_term='$term' AND class LIKE '%$class_set%' ORDER BY id DESC");
	}	
	$assOutput='';
	while ($row=mysqli_fetch_assoc($feedCount)) {
	$main_subject	=strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects 
					WHERE subject_code ='{$row['subject']}'"))['subject']);
	$getTeacher		=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers 
					WHERE teachers_id ='{$row['teachers_id']}'"));
	$assOutput.='
				<div class="ass_cols">
					<h4>Assignment '.strtoupper($row['class']).'</h4>
					<p style="text-transform:capitalize"><span>Subject: </span> '.$main_subject.'</p>
					<p style="text-transform:capitalize"><span>Term: </span> '.$row['class_term'].' Term</p>
					<p><span>Session: </span> '.$row['session'].'</p>
					<p style="text-transform:capitalize"><span>Date: </span> '.timer_converter_f($row['uploaded_time']).'</p>
					<p><span>Teacher: </span> '.ucwords($getTeacher['name']).'</p>
					<p>
						<button class="ass_view" data-type="view" data-viewPath='.$row['file_path'].'> <i class="fa fa-eye"></i> View</button>
						<button class="ass_delete" data-ass_delete_id='.$row['id'].'> <i class="fa fa-trash-o"></i> Delete</button>
						<button class="ass_download" data-type="download" data-viewPath='.$row['file_path'].'> <i class="fa fa-download"></i> Download</button>
					</p>
				</div>
				';
	}
	echo $assOutput;
}
if (isset($_POST['curViewPath'])) {
	$curViewPath=$_POST['curViewPath'];
	header('Content-Type:application/pdf');
	header('Content-Disposition: attachment;filename="Ebook.pdf"');
	readfile('curriculum-upload/'.$curViewPath);
}
if (isset($_POST['deleteId'])) {
	$deleteId=$_POST['deleteId'];
	$getDetails=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM curriculum WHERE id='$deleteId'"));
	if (!empty($getDetails)) {
		if (mysqli_query($mysqli,"DELETE FROM  curriculum WHERE id='$deleteId'")) {
			if (@unlink('curriculum-upload/'.$getDetails['file_path'])) {
				echo "ok";
			}else{
				echo "ok";
			}
		}else{
			echo "An error occured, try again.";
		}
	}else{
		echo "Curriculum already deleted.";
	}
}
//ass deleted
if (isset($_POST['deleteAssId'])) {
	$deleteAssId=$_POST['deleteAssId'];
	$getDetails=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM assignment WHERE id='$deleteAssId'"));
	if (!empty($getDetails)) {
		if (mysqli_query($mysqli,"DELETE FROM  assignment WHERE id='$deleteAssId'")) {
			if (@unlink('assignment-upload/'.$getDetails['file_path'])) {
				echo "ok";
			}else{
				echo "ok";
			}
		}else{
			echo "An error occured, try again.";
		}
	}else{
		echo "Assignment already deleted.";
	}
}
if (isset($_POST['type'],$_POST['r_Id'],$_POST['dValue'])) {
	$data_type=$_POST['type'];
	$r_Id=$_POST['r_Id'];
	$dValue=$_POST['dValue'];

	if ($data_type=="edit_teachers_id") {
		$valid=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id='$dValue'"));
		if (!empty($valid)) {
			if (mysqli_query($mysqli,"UPDATE result_upload SET teachers_id='{$dValue}' WHERE result_id='{$r_Id}'")) {
					echo "Teachers Id edited";
				}
		}else{
			echo "Invalid Teachers ID.";
		}
	}elseif ($data_type=="edit_student") {
		$valid=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id='$dValue'"));
		if (!empty($valid)) {
			if (mysqli_query($mysqli,"UPDATE result_upload SET student_id='{$dValue}' WHERE result_id='{$r_Id}'")) {
					echo "Students Id edited";
				}
		}else{
			echo "Invalid Students Id.";
		}	
	}elseif ($data_type=="edit_subject") {
		$valid=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects WHERE subject='$dValue'"));
		if (!empty($valid)) {
			$code=$valid['subject_code'];
			if (mysqli_query($mysqli,"UPDATE result_upload SET subject='{$code}' WHERE result_id='{$r_Id}'")) {
					echo "Subject edited";
				}
		}else{
			echo "Enter a valid subject.";
		}	
	}elseif ($data_type=="edit_class") {
		if (preg_match('/^[a-zA-Z]{3}[1-6]{1}[a-zA-Z]{1}$/', $dValue)) {
			if (mysqli_query($mysqli,"UPDATE result_upload SET class='{$dValue}' WHERE result_id='{$r_Id}'")) {
					echo "Class edited";
				}
		}else{
			echo "Invalid class format. E.g: JSS1A.";
		}
	}elseif ($data_type=="edit_ca") {
		if (preg_match('/^[0-9]+$/', $dValue)) {
			if (mysqli_query($mysqli,"UPDATE result_upload SET students_c_a='{$dValue}' WHERE result_id='{$r_Id}'")) {
					echo "Continous assesment edited";
				}
		}else{
			echo "Invalid CA score. Enter integer or decimals.";
		}
	}elseif ($data_type=="edit_exam") {
		if (preg_match('/^[0-9]+$/', $dValue)) {
			if (mysqli_query($mysqli,"UPDATE result_upload SET exam_score='{$dValue}' WHERE result_id='{$r_Id}'")) {
					echo "Exam Score edited";
				}
		}else{
			echo "Invalid Exam Score entered. Enter integer or decimals.";
		}
	}elseif ($data_type=="edit_total") {
		if (preg_match('/^[0-9]+$/', $dValue)) {
			if (mysqli_query($mysqli,"UPDATE result_upload SET total_score='{$dValue}' WHERE result_id='{$r_Id}'")) {
					echo "Total Score edited";
				}
		}else{
			echo "Invalid Total Score entered. Enter integer or decimals.";
		}
	}elseif ($data_type=="edit_grade") {
		if (preg_match('/^[a-zA-Z0-9]+$/', $dValue)) {
			if (mysqli_query($mysqli,"UPDATE result_upload SET grade='{$dValue}' WHERE result_id='{$r_Id}'")) {
					echo "Grade edited";
				}
		}else{
			echo "Invalid Grade assigned. Enter letters or digits.";
		}
	}elseif ($data_type=="edit_term") {
		if (preg_match('/^[a-zA-Z]+$/', $dValue)) {
			if (mysqli_query($mysqli,"UPDATE result_upload SET school_term='{$dValue}' WHERE result_id='{$r_Id}'")) {
					echo "Term edited";
				}
		}else{
			echo "Invalid Term. Enter first, second or third.";
		}
	}elseif ($data_type=="edit_session") {
		if (preg_match('/^[0-9]{4}\/[0-9]{4}$/', $dValue)) {
			if (mysqli_query($mysqli,"UPDATE result_upload SET session='{$dValue}' WHERE result_id='{$r_Id}'")) {
					echo "School session edited";
				}
		}else{
			echo "Enter valid session. E.g 2017/2018.";
		}
	}
}

if (isset($_POST['t_id'])) {
	$t_id=strtolower(trim($_POST['t_id']));
	$st_id=strtolower(trim($_POST['st_id']));
	$sub_id=strtolower(trim($_POST['sub_id']));
	$cla_id=strtolower(trim($_POST['cla_id']));
	$ca_id=trim($_POST['ca_id']);
	$ex_id=trim($_POST['ex_id']);
	$tot_id=trim($_POST['tot_id']);
	$gra_id=strtolower(trim($_POST['gra_id']));
	$tem_id=strtolower(trim($_POST['tem_id']));
	$ses_id=strtolower(trim($_POST['ses_id']));
	$term_array=array('first','second','third');
	$t_valid=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id='$t_id'"));
		if (empty($t_valid)) {
			echo "Invalid Teachers ID.";	
		}elseif (empty(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id='$st_id'")))) {
			echo "Invalid Students ID.";
		}elseif (empty(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects WHERE subject='$sub_id'")))) {
			echo "Enter a valid registered subject.";
		}elseif (!preg_match('/^[a-zA-Z]{3}[1-6]{1}[a-zA-Z]{1}$/', $cla_id)) {
			echo "Invalid class format. E.g: JSS1A.";
		}elseif (!preg_match('/^[0-9]+$/', $ca_id)) {
			echo "Invalid CA score. Enter integer or decimals.";
		}elseif (!preg_match('/^[0-9]+$/', $ex_id)) {
			echo "Invalid Exam Score entered. Enter integer or decimals.";
		}elseif (!preg_match('/^[0-9]+$/', $tot_id)) {
			echo "Invalid Total Score entered. Enter integer or decimals.";
		}elseif (!preg_match('/^[a-zA-Z0-9]+$/', $gra_id)) {
			echo "Invalid Grade assigned. Enter letters or digits.";
		}elseif (!in_array($tem_id, $term_array)) {
			echo "Invalid Term. Enter first, second or third.";
		}elseif (!preg_match('/^[0-9]{4}\/[0-9]{4}$/', $ses_id)) {
			echo "Enter valid session. E.g 2017/2018.";
		}else{
			$subject_code=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects WHERE subject='$sub_id'"))['subject_code'];
            $r_check_if_inserted=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM result_upload WHERE teachers_id ='{$t_id}' AND subject= '$subject_code' AND class='$cla_id' AND student_id='$st_id' AND session='$ses_id' AND school_term='$tem_id' "));
            if (!empty($r_check_if_inserted)) {
            	echo "Student with the ID <strong>\"$st_id\"</strong> already added.";
            }else{
            	$t_id=trim(mysqli_Real_escape_string($mysqli,htmlentities($t_id)));
            	$st_id=trim(mysqli_Real_escape_string($mysqli,htmlentities($st_id)));
            	$sub_id=trim(mysqli_Real_escape_string($mysqli,htmlentities($sub_id)));
            	$cla_id=trim(mysqli_Real_escape_string($mysqli,htmlentities($cla_id)));
            	$ca_id=trim(mysqli_Real_escape_string($mysqli,htmlentities($ca_id)));
            	$ex_id=trim(mysqli_Real_escape_string($mysqli,htmlentities($ex_id)));
            	$tot_id=trim(mysqli_Real_escape_string($mysqli,htmlentities($tot_id)));
            	$gra_id=trim(mysqli_Real_escape_string($mysqli,htmlentities($gra_id)));
            	$tem_id=trim(mysqli_Real_escape_string($mysqli,htmlentities($tem_id)));
            	$ses_id=trim(mysqli_Real_escape_string($mysqli,htmlentities($ses_id)));
            	$date_uploaded=time();
				$r_insert=mysqli_query($mysqli, "INSERT INTO result_upload (result_id,teachers_id,subject,class,student_id,students_c_a,exam_score,total_score,grade,session,school_term,date_uploaded)
	            VALUES ('{}','{$t_id}','{$subject_code}','{$cla_id}','{$st_id}',
	            '{$ca_id}','{$ex_id}','{$tot_id}','{$gra_id}','{$ses_id}','{$tem_id}','{$date_uploaded}') ");
		            if ($r_insert) {
		            	echo "ok";
		            }else{
		            	echo "An error occured, try again.";
		            }
            	}
		}
}
//removing student
if (isset($_POST['removeId'])) {
	$removeId=trim($_POST['removeId']);
	if (empty(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM result_upload WHERE result_id='$removeId'")))) {
			echo "Student already removed.";
		}else{
			if (mysqli_query($mysqli,"DELETE FROM  result_upload WHERE result_id='$removeId'")) {
				echo "Result removed succesfully.";
			}else{
				echo "An error encountered. Try again.";
			}
		}
}
//deleting student
if (isset($_POST['teachers_id_d'])) {
	$teachers_id_d=trim($_POST['teachers_id_d']);
	$session_id_d=trim($_POST['session_id_d']);
	$term_id_d=trim($_POST['term_id_d']);
	$class_id_d=trim($_POST['class_id_d']);
	$subject_id_d=trim($_POST['subject_id_d']);
	$check_d=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE teachers_id='$teachers_id_d' AND  class='$class_id_d' AND  school_term='$term_id_d' AND  subject='$subject_id_d' AND  session='$session_id_d' ");
    if (mysqli_query($mysqli,"DELETE FROM  result_upload WHERE teachers_id='$teachers_id_d' AND  class='$class_id_d' AND  school_term='$term_id_d' AND  subject='$subject_id_d' AND  session='$session_id_d' ")) {
    	echo "ok";
    };
}

?>