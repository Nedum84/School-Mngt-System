<?php 

include_once("../inc/functions.inc.php");

//for result
if (isset($_POST['r_class'])) {
    $r_teachers_id  	=sanitize(strtolower($_POST['r_teachers_id']));
    $res_class 			=sanitize(strtolower($_POST['r_class']));
    $res_subject 		=sanitize(strtolower($_POST['r_subject']));
    // $res_session 		=sanitize(strtolower($_POST['r_session']));
    // $res_term 			=sanitize(strtolower($_POST['r_term']));
    $res_session 		=sanitize($school_session);
    $res_term 			=sanitize($school_term);

	$result_ext 		=strtolower(pathinfo($_FILES['upload_res_input']['name'],PATHINFO_EXTENSION));		
    $tmp_name   		=$_FILES['upload_res_input']['tmp_name'];

    $resultExt_array 	= array('csv');
    $get_teacher_Det 	=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id='$r_teachers_id' "));
    $registered_class 	=explode(',', $get_teacher_Det['teaching_class']);
    $registered_subjects=explode(',', $get_teacher_Det['teaching_subject']);
    $res_subject_name	=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT subject FROM subjects WHERE subject_code = '$res_subject' "))['subject'];
    $check_result_exist	=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE
    					subject= '$res_subject' AND class='$res_class' AND session='$res_session' 
    					AND school_term='$res_term' ");

    if (empty($r_teachers_id)) {
        $error_feed_r='Select the Teacher';
    }elseif (!checkExist("*","teachers","teachers_id", $r_teachers_id)) {
        $error_feed_r='Teacher not registered.';
    }elseif (empty($res_class)) {
        $error_feed_r='Select the class. e.g JSS1A.';
    }elseif (!in_array($res_class, $registered_class)) {
        $error_feed_r=strtoupper($res_class)." is not included in the class you are teaching or contact <b>admin</b> if you think this is omission/mistake.";
    }elseif (empty($res_subject)) {
        $error_feed_r='Select the subject.';
    }elseif (!in_array($res_subject, $registered_subjects)) {
        $error_feed_r=strtoupper($res_subject_name)." is not included in the subject you are teaching or contact <b>admin</b> if you think this is omission/mistake.";
    }elseif (empty($res_term)) {
        $error_feed_r='Select the term.';
    }elseif (empty($res_session)) {
        $error_feed_r='Select the session.';
    }elseif((!in_array($result_ext, $resultExt_array))){
            $error_feed_r='Select .csv result file.';
    }elseif((mysqli_num_rows($check_result_exist)>0)&&(mysqli_fetch_assoc($check_result_exist)['teachers_id']!=$r_teachers_id)){
    	$teacher_exist_Dets	=mysqli_fetch_assoc($check_result_exist)['teachers_id'];
    	$teacher_exist_Dets	=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id='$teacher_exist_Dets' "));

	    $output='
		        <form method="post" id="result_exist_form_delete" style="display: block;">
		            <h4 style="margin-bottom: 12px;" class="text-danger"> Result Upload Error!</h4>

		            <label class="text-warning">!RESULT ALREADY UPLOADED BY '.strtoupper($teacher_exist_Dets['name']).'</label>

		            <hr>
		            <p style="font-size: 1.5em;color:#000">
		            	'.strtoupper($res_subject_name).' Result of '.strtoupper($res_class).' class, 
		            	'.strtoupper($res_term).' Term and '.$res_session.' session has already been uploaded 
		            	by '.ucwords($teacher_exist_Dets['name']).'. To delete this result, click <b>DELETE BELOW</b>
		            </p>
		    		<input type="hidden" value="'.$r_teachers_id.'" id="r_teachers_id">
		    		<input type="hidden" value="'.$res_subject.'" id="res_subject">
		    		<input type="hidden" value="'.$res_class.'" id="res_class">
		    		<input type="hidden" value="'.$res_term.'" id="res_term">
		    		<input type="hidden" value="'.$res_session.'" id="res_session">
					
					<div class="er">
		              <span class="feedback"></span>
		            </div>
		            <div class="modal_footer">
		              <button id="notify_student_button" type="submit">
		                <i class="fa fa-check"></i><span> Delete?</span>
		              </button>
		              <button id="footer_close_button" class="modal_close">
		                <i class="fa fa-times"></i><span> close</span>
		              </button>
		            </div>
	    		</form>';
    }else{ 
        $output='
		        <form method="post" id="result_upload_form" style="display: block;">
		            <h4 style="margin-bottom: 12px;"> Result Upload</h4>

		            <b class="bg-success text-white p-1">Teachers Name: </b> '.ucwords($get_teacher_Det['name']).' |
		            <b class="bg-success text-white p-1">Subject: </b> '.ucwords($res_subject_name).' |
		            <b class="bg-success text-white p-1">Class: </b> '.strtoupper($res_class).'

		            <hr>

		            <div class="er">
		              <span class="feedback"></span>
		            </div>
		            ';
        $output .= '

        <table class="table table-bordered result_upload_table" id="result_upload_table">
		<thead>							
			<tr>
				<th>
					S/N
				</th>
				<th>
					Students REG NO.
		              	<span class="fa fa-question"> 
		              		<span>The Students unique ID</span>
		              		<i class="fa fa-close"></i>
		              	</span>
				</th>
				<th>
					Students Name
		              	<span class="fa fa-question"> 
		              		<span>The Students full name</span>
		              		<i class="fa fa-close"></i>
		              	</span>					              
				</th>
				<th>
					Students CA
			              <span class="fa fa-question"> 
			              	<span >Enter the student\'s continous assesment (CA) score below carefully
			              		<a href="#">Learn more?</a><i class="fa fa-close"></i>
			              	</span> 
			              </span>
				</th>

				<th>
					Exam Score
			              <span class="fa fa-question"> 
			              	<span >Enter the student\'s Exam Score below carefully 
			              		<a href="#">Learn more?</a><i class="fa fa-close"></i>
			              	</span> 
			              </span>
				</th>
				<th>
					Total
			              <span class="fa fa-question"> 
			              	<span>Student\'s total score shows here 
			              		<i class="fa fa-close"></i>
			              	</span> 
			              </span>
				</th> 
				<th>
					Grade
			              <span class="fa fa-question"> 
			              	<span>Student\'s grade shows here 
			              		<i class="fa fa-close"></i>
			              	</span> 
			              </span>
				</th>
			</tr>
		</thead>
		<tbody>';
		$x=1;

		$handle=fopen($tmp_name, 'r');
        while ($row=fgetcsv($handle)) {
          if (mysqli_real_escape_string($mysqli,strtolower($row[1]))=="student id"){continue;}

            $r_class=trim(mysqli_real_escape_string($mysqli,strtolower($row[0])));
            $r_student_id=trim(mysqli_real_escape_string($mysqli,strtolower($row[1])));
            $r_class_ca=(int)trim(mysqli_real_escape_string($mysqli,strtolower($row[2])));
            $r_exam_score=(int)trim(mysqli_real_escape_string($mysqli,strtolower($row[3])));
            $r_total_score=$r_class_ca+$r_exam_score;
            $r_grade=checkGrade($r_total_score);
            $r_date_uploaded=time();

            $st_id=$row['student_id'];
		$st_name=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id='$r_student_id'"));

		$output.='<tr class="editable_file" id="'.$x.'">
				<td>
					'.$x.'
				</td>
				<td data-type="student_id">
					'.$r_student_id.'
				</td>
				<td >
					'.ucwords($st_name['name']).'
				</td>

				<td contenteditable="true" data-type="ca_score" data-r_id="'.$x.'">
				'.$r_class_ca.'							
				</td>

				<td contenteditable="true" data-type="exam_score" data-r_id="'.$x.'">
				'.$r_exam_score.'							
				</td>

				<td data-type="st_total">
				'.$r_total_score.'
													
				</td>
				<td data-type="st_grade">
				'.strtoupper($r_grade).'
													
				</td>
			</tr>';

		$x++;

        }
        $output.='
			</tbody>
		</table>';

        $output.='
	    		<input type="hidden" value="'.$r_teachers_id.'" id="r_teachers_id">
	    		<input type="hidden" value="'.$res_subject.'" id="res_subject">
	    		<input type="hidden" value="'.$res_class.'" id="res_class">
	    		<input type="hidden" value="'.$res_term.'" id="res_term">
	    		<input type="hidden" value="'.$res_session.'" id="res_session">


	            <div class="er">
	              <span class="feedback"></span>
	            </div>
	            <div class="modal_footer">
	              <button id="upload_resultBTN" type="submit">
	                <i class="fa fa-check"></i><span> Upload Result</span>
	              </button>
	              <button id="footer_close_button" class="modal_close">
	                <i class="fa fa-times"></i><span> close</span>
	              </button>
	            </div>
	    </form>';
	    
    }
    if (empty($output)) {
    	echo ucfirst($error_feed_r);
    }else{
    	echo $output;
    }
    
}

//uploading the result
if ($_POST['studentsResults']) {
	$studentsResults 	=json_decode($_POST['studentsResults'],true);
	$resultDetails 		=json_decode($_POST['resultDetails'],true);

	$result_Class 		=$resultDetails['result_Class'];
	$result_Subject 	=$resultDetails['result_Subject'];
	$result_TeachersID 	=$resultDetails['result_TeachersID'];
	$result_Term 		=$resultDetails['result_Term'];
	$result_Session 	=$resultDetails['result_Session'];
	$count				=0;

	for ($i=1; $i <=count($studentsResults) ; $i++) {

			$student_id 	=$studentsResults[$i]['student_id'];
			$st_curCA 		=$studentsResults[$i]['st_curCA'];
			$st_curExam 	=$studentsResults[$i]['st_curExam'];
			$st_total 		=$studentsResults[$i]['st_total'];
			$st_grade 		=$studentsResults[$i]['st_grade'];


		$r_check_if_inserted=mysqli_fetch_assoc(mysqli_query(
							$mysqli,"SELECT * FROM result_upload WHERE teachers_id ='{$result_TeachersID}' 
							AND subject= '$result_Subject' AND class='$result_Class' 
							AND student_id='$student_id' AND session='$result_Session' 
							AND school_term='$result_Term' "));
        if (empty($r_check_if_inserted)) {
            $r_insert=mysqli_query(
            		$mysqli, "INSERT INTO `result_upload` (`result_id`, `teachers_id`, `subject`, 
            			`class`, `student_id`, `students_c_a`, `exam_score`, `total_score`, `grade`, 
            			`session`, `school_term`, `date_uploaded`, `approved`) 
            			VALUES (NULL,'{$result_TeachersID}','{$result_Subject}','{$result_Class}',
                		'{$student_id}', '{$st_curCA}','{$st_curExam}','{$st_total}',
                		'{$st_grade}','{$result_Session}', '{$result_Term}','{$time}','0') ");
            if ($r_insert) {
                $count+=1;
            }
        }else{
            $r_update=mysqli_query(
            		$mysqli, "UPDATE `result_upload` SET `students_c_a`='$st_curCA',
            		`exam_score`='$st_curExam',`total_score`='$st_total',`grade`='$st_grade'
            		WHERE `session`='$result_Session' AND class='$result_Class'  
            		AND subject='$result_Subject' AND `school_term` = '$result_Term' 
            		AND student_id='$student_id' ");
            if ($r_update) {
                $count+=1;
            }
        }
		
	}
	echo "<b class='text-white bg-success' 
			style='font-size:1.4em;display:block;width:100%;padding:12px;'>
			RESULTS($count) UPLOADED!!!
		</b>";

}

//Deleting existing result
if (isset($_POST['deleteResultDetails'])) {
	$deleteResultDetails 		=json_decode($_POST['deleteResultDetails'],true);

	$delete_result_Class 		=$deleteResultDetails['delete_result_Class'];
	$delete_result_Subject 		=$deleteResultDetails['delete_result_Subject'];
	$delete_result_TeachersID 	=$deleteResultDetails['delete_result_TeachersID'];
	$delete_result_Term 		=$deleteResultDetails['delete_result_Term'];
	$delete_result_Session 		=$deleteResultDetails['delete_result_Session'];
    $res_subject_name			=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT subject FROM subjects WHERE subject_code = '$delete_result_Subject' "))['subject'];

	$getDelDetails=mysqli_query(
						$mysqli,"SELECT * FROM result_upload WHERE subject= '$delete_result_Subject' AND  class='$delete_result_Class' 
						AND session='$delete_result_Session' AND school_term='$delete_result_Term' ");

	if (mysqli_num_rows($getDelDetails)>0) {
		$delResult=mysqli_query($mysqli,"DELETE FROM result_upload 
						WHERE subject= '$delete_result_Subject' AND class='$delete_result_Class' 
						AND session='$delete_result_Session' AND school_term='$delete_result_Term' ");
		if ($delResult) {		
			echo "<b class='text-white bg-success' 
					style='font-size:1.2em;display:block;width:100%;padding:12px;'>
					".strtoupper($res_subject_name)."
					RESULT(".mysqli_num_rows($getDelDetails).") DELETED!!!
				</b>";

		}else{
			echo "<b class='text-white bg-danger' 
					style='font-size:1.2em;display:block;width:100%;padding:12px;'>
					AN ERROR OCCURED, TRY AGAIN!!!
				</b>";

		}
	}else{
		echo "<b class='text-white bg-danger' 
				style='font-size:1.2em;display:block;width:100%;padding:12px;'>
				".strtoupper($res_subject_name)."
				RESULT ALREADY DELETED!!!
			</b>";

	}

}

//FOR ONLINE FILLING
//Exams Processing

if (isset($_POST['teachers_id'])) {
	$teachers_id 		=sanitize($_POST['teachers_id']);
	$teachers_sub 		=sanitize($_POST['teachers_sub']);
	$teachers_class 	=sanitize($_POST['teachers_class']);
    $res_session 		=sanitize($school_session);
    $res_term 			=sanitize($school_term);
    $res_subject_name	=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT subject FROM subjects WHERE subject_code = '$teachers_sub' "))['subject'];

	$check_result_exist	=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE
    					subject= '$teachers_sub' AND class='$teachers_class' AND session='$res_session' 
    					AND school_term='$res_term' ");
	if((mysqli_num_rows($check_result_exist)>0)&&(mysqli_fetch_assoc($check_result_exist)['teachers_id']!=$teachers_id)){
    	$teacher_exist_Dets	=mysqli_fetch_assoc($check_result_exist)['teachers_id'];
    	$teacher_exist_Dets	=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id='$teacher_exist_Dets' "));

	    $output='
		        <form method="post" id="result_exist_form_delete" style="display: block;">
		            <h4 style="margin-bottom: 12px;" class="text-danger"> Result Upload Error!</h4>

		            <label class="text-warning">!RESULT ALREADY UPLOADED BY '.strtoupper($teacher_exist_Dets['name']).'</label>

		            <hr>
		            <p style="font-size: 1.5em;color:#000">
		            	'.strtoupper($res_subject_name).' Result of '.strtoupper($teachers_class).' class, 
		            	'.strtoupper($res_term).' Term and '.$res_session.' session has already been uploaded 
		            	by '.ucwords($teacher_exist_Dets['name']).'. To delete this result, click <b>DELETE BELOW</b>
		            </p>
		    		<input type="hidden" value="'.$teachers_id.'" id="r_teachers_id">
		    		<input type="hidden" value="'.$teachers_sub.'" id="res_subject">
		    		<input type="hidden" value="'.$teachers_class.'" id="res_class">
		    		<input type="hidden" value="'.$res_term.'" id="res_term">
		    		<input type="hidden" value="'.$res_session.'" id="res_session">
					
					<div class="er">
		              <span class="feedback"></span>
		            </div>
		            <div class="modal_footer">
		              <button id="notify_student_button" type="submit">
		                <i class="fa fa-check"></i><span> Delete?</span>
		              </button>
		              <button id="footer_close_button" class="modal_close">
		                <i class="fa fa-times"></i><span> close</span>
		              </button>
		            </div>
	    		</form>';
	    	echo $output;
	}else{
		$allStudents=mysqli_query($mysqli,"SELECT * FROM students WHERE class='$teachers_class' ");
		while ($row=mysqli_fetch_assoc($allStudents)) {
			$student_id=$row['st_id'];
			$checkAdded=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM result_upload WHERE class='$teachers_class' AND teachers_id='$teachers_id' AND subject='$teachers_sub' AND student_id='$student_id' AND school_term='$school_term' AND session='$school_session' "));
			if (empty($checkAdded)) {
				
	            $st_insert=mysqli_query($mysqli, "INSERT INTO `result_upload` (`result_id`, `teachers_id`, `subject`, `class`, `student_id`, `students_c_a`, `exam_score`, `total_score`, `grade`, `session`, `school_term`, `date_uploaded`, `approved`)

	                VALUES (NULL,'{$teachers_id}','{$teachers_sub}','{$teachers_class}','{$student_id}', '0','0','0','','{$school_session}', '{$school_term}','{$time}','') ");
			}
		}

		echo feedStudentsRes($teachers_id,$teachers_sub,$teachers_class);
	}

}
//students feeding exam function 
function feedStudentsRes($teachers_id,$teachers_sub,$teachers_class){
	global $school_term;
	global $school_session;
	global $mysqli;
	$count_students=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE class='$teachers_class' AND teachers_id='$teachers_id' AND subject='$teachers_sub' AND school_term='$school_term' AND session='$school_session' ");

	$output='<table class="table table-bordered result">
				<thead>							
			<tr>
				<th>
					S/N
				</th>
				<th>
					Students REG NO.
		              	<span class="fa fa-question"> 
		              		<span>The Students unique ID 
		              		<i class="fa fa-close"></i></span>
		              		
		              	</span>
				</th>
				<th>
					Students Name
		              	<span class="fa fa-question"> 
		              		<span>The Students full name
		              		<i class="fa fa-close"></i></span>
		              	</span>					              
				</th>
				<th>
					Students CA
			              <span class="fa fa-question"> 
			              	<span >Enter the student\'s continous assesment (CA) score below carefully
			              		<a href="#">Learn more?</a><i class="fa fa-close"></i>
			              	</span> 
			              </span>
				</th>

				<th>
					Exam Score
			              <span class="fa fa-question"> 
			              	<span >Enter the student\'s Exam Score below carefully 
			              		<a href="#">Learn more?</a><i class="fa fa-close"></i>
			              	</span> 
			              </span>
				</th>
				<th>
					Total
			              <span class="fa fa-question"> 
			              	<span>Student\'s total score shows here 
			              		<i class="fa fa-close"></i>
			              	</span> 
			              </span>
				</th> 
				<th>
					Grade
			              <span class="fa fa-question"> 
			              	<span>Student\'s grade shows here 
			              		<i class="fa fa-close"></i>
			              	</span> 
			              </span>
				</th>
			</tr>
		</thead>
				<tbody>';
				$x=1;
			while ($row=mysqli_fetch_assoc($count_students)) {
				$st_id=$row['student_id'];
				$st_name=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id='$st_id'"));

				$output.='<tr class="editable" id="'.$row['result_id'].'">
							<td>
								'.$x.'
							</td>
							<td >
								'.$st_id.'
							</td>
							<td >
								'.ucwords($st_name['name']).'
							</td>

							<td contenteditable="true" data-type="ca_score" data-r_id="'.$row['result_id'].'">
							'.$row['students_c_a'].'							
							</td>

							<td contenteditable="true" data-type="exam_score" data-r_id="'.$row['result_id'].'">
							'.$row['exam_score'].'							
							</td>

							<td data-type="st_total">
							'.$row['total_score'].'
																
							</td>
							<td data-type="st_grade">
							'.strtoupper($row['grade']).'
																
							</td>
						</tr>';

					$x++;
				}	
		$output.='
				</tbody>
			</table>';

		return $output;
}

//result update
if (isset($_POST['type'],$_POST['r_Id'],$_POST['dValue'])) {
	$data_type=$_POST['type'];
	$r_Id=$_POST['r_Id'];
	$dValue=intval($_POST['dValue']);

	if ($data_type=="ca_score") {
		if (mysqli_query($mysqli,"UPDATE result_upload SET students_c_a='{$dValue}' WHERE result_id='{$r_Id}'")) {
			echo "Edited";
		}else{
			echo "An error occured, try again";
		}
	}elseif ($data_type=="exam_score") {
		if (mysqli_query($mysqli,"UPDATE result_upload SET exam_score='{$dValue}' WHERE result_id='{$r_Id}'")) {
			echo "Edited";
		}else{
			echo "An error occured, try again";
		}
	}

	$st_details=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM result_upload WHERE result_id='$r_Id'"));
	$st_total=intval($st_details['students_c_a']+$st_details['exam_score']);
	$st_grade=checkGrade($st_total);
	if (!mysqli_query($mysqli,"UPDATE result_upload SET total_score='{$st_total}',grade='{$st_grade}' WHERE result_id='{$r_Id}'")) {
			echo "An error occured, try again";
	}

}

//GET ST GRADE
if (isset($_POST['st_total'])) {
	echo strtoupper(checkGrade(intval($_POST['st_total'])));
}
//FeedBack uploaded result

if (isset($_POST['resFeed'])) {
	$resFeed=trim($_POST['resFeed']);

	$term=strtolower($schDetails['school_term']);
	if ($resFeed == 'res2') {
		$feedCount=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE session='$school_session' AND school_term='$school_term' ORDER BY result_id DESC");
	}else{
		$feedCount=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE teachers_id='$id' AND session='$school_session' AND school_term='$term' ORDER BY result_id DESC ");
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
					<p><button class="r_view" data-edit_id="'.$row['result_id'].'"
					 data-teachers_id="'.$row['teachers_id'].'"
					 data-class_id="'.$row['class'].'"
					 data-session_id="'.$row['session'].'"
					 data-term_id="'.$row['school_term'].'"
					 data-subject_id="'.$row['subject'].'">
					 <i class="fa fa-eye"></i> View</button></p>
				</div>
				';
	}
	echo $resOutput;
}
//View uploaded result
if (isset($_POST['viewResultDetails'])) {
	$viewResultDetails 		=json_decode($_POST['viewResultDetails'],true);

	$view_result_Class 		=$viewResultDetails['view_result_Class'];
	$view_result_Subject 	=$viewResultDetails['view_result_Subject'];
	$view_result_TeachersID 	=$viewResultDetails['view_result_TeachersID'];
	$view_result_Term 		=$viewResultDetails['view_result_Term'];
	$view_result_Session 	=$viewResultDetails['view_result_Session'];

	$getViewDetails=mysqli_query(
						$mysqli,"SELECT * FROM result_upload WHERE subject= '$view_result_Subject' AND  class='$view_result_Class' 
						AND session='$view_result_Session' AND school_term='$view_result_Term' ");
    $res_subject_name	=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT subject FROM subjects WHERE subject_code = '$view_result_Subject' "))['subject'];
    $get_teacher_Det 	=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id='$view_result_TeachersID' "));

        $output='
		            <h4 style="margin-bottom: 12px;"> Result Upload</h4>

		            <b class="bg-success text-white p-1">Teachers Name: </b> '.ucwords($get_teacher_Det['name']).' |
		            <b class="bg-success text-white p-1">Subject: </b> '.ucwords($res_subject_name).' |
		            <b class="bg-success text-white p-1">Class: </b> '.strtoupper($view_result_Class).'

		            <hr>

		            <div class="er">
		              <span class="feedback"></span>
		            </div>
		            ';
		$output .='<table class="table table-bordered result">
				<thead>							
					<tr>
						<th>
							S/N
						</th>
						<th>
							Students REG NO.
						</th>
						<th>
							Students Name
						</th>
						<th>
							Students CA
						</th>

						<th>
							Exam Score
						</th>
						<th>
							Total
						</th> 
						<th>
							Grade
						</th>
					</tr>
				</thead>
				<tbody>';
			if (mysqli_num_rows($getViewDetails)>0) {
				$x=1;

			while ($row=mysqli_fetch_assoc($getViewDetails)) {
				$st_id=$row['student_id'];
				$st_name=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id='$st_id'"));

				$output.='<tr class="editable" id="'.$row['result_id'].'">
							<td>
								'.$x.'
							</td>
							<td >
								'.$st_id.'
							</td>
							<td >
								'.ucwords($st_name['name']).'
							</td>

							<td>
							'.$row['students_c_a'].'							
							</td>

							<td>
							'.$row['exam_score'].'							
							</td>

							<td data-type="st_total">
							'.$row['total_score'].'
																
							</td>
							<td data-type="st_grade">
							'.strtoupper($row['grade']).'
																
							</td>
						</tr>';

					$x++;
				}	
		$output.='
				</tbody>
			</table>';
		$output .='
			<hr>
			<div class="modal_footer">
              <button id="footer_close_button" class="modal_close">
                <i class="fa fa-times"></i><span> close</span>
              </button>
            </div>
		';

	}
	echo $output;
}



















 ?>