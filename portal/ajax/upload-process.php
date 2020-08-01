<?php

// include_once("../inc/plan_connect.inc.php");
include_once("../inc/connect.inc.php");
if (isset($_POST['c_class'])) {
    $c_teachers_id  =trim(strtolower($_POST['c_teachers_id']));
    $c_class        =trim(strtolower($_POST['c_class']));
	$c_subject      =trim(strtolower($_POST['c_subject']));
	$c_session      =trim(strtolower($_POST['c_session']));
	$c_term         =trim(strtolower($_POST['c_term']));
	$main_subject   =strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT subject FROM subjects WHERE subject_code ='{$c_subject}'"))['subject']);

	$c_f_name= $_FILES["upload_cur_input"]["name"];
    $c_f_name_explode=explode('.', $c_f_name);
    $ext     =strtolower(end($c_f_name_explode));
    $type     =$_FILES['upload_cur_input']['type'];
    $size     =$_FILES['upload_cur_input']['size'];
    $tmp_name   =$_FILES['upload_cur_input']['tmp_name'];
    $location= '../upload/curriculum-upload/';
    $curriculumExt_array = array('docx','doc','pdf');

    if (empty($c_teachers_id)) {
        $error_feed='Enter the teachers ID.';
    }elseif (!checkExist("*","teachers","teachers_id",$c_teachers_id)) {
        $error_feed='Teachers ID not registered.';
    }elseif ($c_class=='none') {
        $error_feed='Select the class.';
    }elseif ($c_term=='none') {
    	$error_feed='Select the term.';
    }elseif ($c_subject=='none') {
    	$error_feed='Select the subject.';
    }elseif ($c_session=='none') {
    	$error_feed='Select the session.';
    }
    // elseif (($c_session!=$session)||($c_term!=$term)) {
    //     $error_feed='You cannot Upload Curriculum for '.$c_term.' term '.$c_session.' session Or update your(teachers) profile.';
    // }
    else{
    	if (isset($c_f_name)) {
    		if ((!in_array($ext, $curriculumExt_array))||($size>4097676)) {
    			$error_feed="Select .pdf or docx curriculum file less than 4Mb.";
    		}else{
    			$session_put=substr($c_session, 0,4).'-'.substr($c_session, 5);
    			$end_path=$c_class."-".$c_term."-".$main_subject.'-'.$session_put.".".$ext;
    			$cur_name=$location.$end_path;
                $check_if_inserted=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM curriculum WHERE subject ='{$c_subject}' AND session= '$c_session' AND class='$c_class' AND class_term='$c_term' "));
		        if (empty($check_if_inserted)) {
		        	if (move_uploaded_file($tmp_name, $cur_name)) {
			        	if (mysqli_query($mysqli,"INSERT INTO curriculum 
			        		VALUES('{}','{$c_teachers_id}','{$c_subject}','{$c_session}','{$c_term}','{$c_class}','{$end_path}')")) {
			        		echo"ok";
			        	}else{
			        		$error_feed="An error occured, try again.";
			        	}
		        	}else{
		        		$error_feed="Counld not upload curriculum, try again.";
		        	}		        	
		        }else{
		        	$error_feed="Curriculum already uploaded.";
		        }
    		}
    	}else{
    		$error_feed='Select .pdf or docx curriculum file less than 4Mb.';
    	}
    }
    echo $error_feed;
}
//for result
if (isset($_POST['r_class'])) {
    $r_teachers_id  =trim(strtolower($_POST['r_teachers_id']));
    $res_class=trim(strtolower($_POST['r_class']));
    $res_subject=trim(strtolower($_POST['r_subject']));
    $res_session=trim(strtolower($_POST['r_session']));
    $res_term=trim(strtolower($_POST['r_term']));
    $input_subject=trim(strtolower($_POST['input_subject']));

    $r_f_name= $_FILES["upload_res_input"]["name"];
    $r_f_name_explode=explode('.', $r_f_name);
    $ext      =strtolower(end($r_f_name_explode));
    $type     =$_FILES['upload_res_input']['type'];
    $size     =$_FILES['upload_res_input']['size'];
    $tmp_name   =$_FILES['upload_res_input']['tmp_name'];
    $location= '../support_images/';
    $resultExt_array = array('csv');
    $getClass =mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id='$r_teachers_id' "));
    $registered_class=explode(',', $getClass['teaching_class']);
    $registered_subjects=explode(',', $getClass['teaching_subject']);

    if (empty($r_teachers_id)) {
        $error_feed_r='Enter the teachers ID.';
    }elseif (!checkExist("*","teachers","teachers_id", $r_teachers_id)) {
        $error_feed_r='Teachers ID not registered.';
    }elseif (empty($res_class)) {
        $error_feed_r='Enter the class. e.g JSS1A.';
    }elseif (!preg_match('/^[a-zA-Z]{3}[1-6]{1}[a-zA-Z]{1}$/', $res_class)) {
        $error_feed_r='Invalid class format. Class format: JSS1A.';
    }elseif (!in_array($res_class, $registered_class)) {
        $error_feed_r=strtoupper($res_class)." is not included in the class you are teaching or add it on your (teachers) profile.";
    }elseif ($res_subject=='none') {
        $error_feed_r='Select the subject.';
    }elseif (!in_array($input_subject, $registered_subjects)) {
        $error_feed_r="$input_subject is not included in the subject you are teaching or add it on your profile.";
    }elseif ($res_term=='none') {
        $error_feed_r='Select the term.';
    }elseif ($res_session=='none') {
        $error_feed_r='Select the session.';
    }elseif (($res_session!=$session)||($res_term!=$term)) {
        $error_feed_r='You cannot Upload result for '.$res_term.' term '.$res_session.' session Or update your profile.';
    }else{
        if (isset($r_f_name)) {
            if (!in_array($ext, $resultExt_array)) {
                $error_feed_r="Select your .csv result file.";
            }else{
                $handle=fopen($tmp_name, 'r');$count=0;$c=0;$repeat=0;
                while ($row=fgetcsv($handle)) {
                  if (mysqli_real_escape_string($mysqli,strtolower($row[5]))=="class"){continue;}

                    $r_class=trim(mysqli_real_escape_string($mysqli,strtolower($row[5])));
                    $r_student_id=trim(mysqli_real_escape_string($mysqli,strtolower($row[1])));
                    $r_class_ca=(int)trim(mysqli_real_escape_string($mysqli,strtolower($row[3])));
                    $r_exam_score=(int)trim(mysqli_real_escape_string($mysqli,strtolower($row[4])));
                    $r_total_score=$r_class_ca+$r_exam_score;
                    $r_grade=checkGrade($r_total_score);
                    $r_date_uploaded=time();

                    if (($r_class!=$res_class)) {$c++;continue;}

                    $r_check_if_inserted=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM result_upload WHERE teachers_id ='{$r_teachers_id}' AND subject= '$res_subject' AND class='$res_class' AND student_id='$r_student_id' AND session='$res_session' AND school_term='$res_term' "));
                    if (empty($r_check_if_inserted)) {
                        $r_insert=mysqli_query($mysqli, "INSERT INTO result_upload (result_id,teachers_id,subject,class,student_id,students_c_a,exam_score,total_score,grade,session,school_term,date_uploaded)
                            VALUES ('{}','{$r_teachers_id}','{$res_subject}','{$res_class}','{$r_student_id}', '{$r_class_ca}','{$r_exam_score}','{$r_total_score}','{$r_grade}','{$res_session}', '{$res_term}','{$r_date_uploaded}') ");
                        if ($r_insert) {
                            $count+=1;
                        }
                    }else{$repeat++;}
                }

                // $error_feed_r= "Result of ".$count." students uploaded. $c discarded because of mismatch of input field and uploaded result. $repeat repetitions remove. ";
                // if ($count>0) {
                    $error_feed_r.="<p class='fSuccess'>Result of ".$count." students uploaded. </p>";
                // }
                if ($c>0) {
                    $error_feed_r.="<p class='fError'>$c results discarded because of mismatch of input field and uploaded result. </p>";
                }if ($repeat>0) {
                    $error_feed_r.="<p class='fError'>$repeat result repetitions remove.</p>";
                }
            }
        }else{
            $error_feed_r='Select .csv result file.';
        }
    }
    echo ucfirst($error_feed_r);
}
//assigment

if (isset($_POST['ass_class'])) {
    $a_teachers_id  =trim(strtolower($_POST['a_teachers_id']));
    $ass_class=trim(strtolower($_POST['ass_class']));
    $ass_subject=trim(strtolower($_POST['ass_subject']));
    $ass_session=trim(strtolower($_POST['ass_session']));
    $ass_term=trim(strtolower($_POST['ass_term']));
    $ass_uploaded_date=time();
    $main_subject=strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT subject FROM subjects WHERE subject_code ='{$ass_subject}'"))['subject']);

    $ass_f_name= $_FILES["upload_ass_input"]["name"];
    $ass_f_name_explode=explode('.', $ass_f_name);
    $ext     =strtolower(end($ass_f_name_explode));
    $type     =$_FILES['upload_ass_input']['type'];
    $size     =$_FILES['upload_ass_input']['size'];
    $tmp_name   =$_FILES['upload_ass_input']['tmp_name'];
    $location= '../upload/assignment-upload/';
    $curriculumExt_array = array('docx','doc','pdf');

    if (empty($a_teachers_id)) {
        $error_feed='Enter the teachers ID.';
    }elseif (!checkExist("*","teachers","teachers_id", $a_teachers_id)) {
        $error_feed='Teachers ID not registered.';
    }elseif ((!preg_match('/^[a-zA-Z]{3}[1-6]{1}[a-zA-Z]{1}$/', $ass_class))&&(!preg_match('/^[a-zA-Z]{3}[1-6]{1}$/', $ass_class))) {
        $error_feed='Enter the class. E.g JSS1A OR JSS1.';
    }elseif ($ass_term=='none') {
        $error_feed='Select the term.';
    }elseif ($ass_subject=='none') {
        $error_feed='Select the subject.';
    }elseif ($ass_session=='none') {
        $error_feed='Select the session.';
    }else{
        if (isset($ass_f_name)) {
            if ((!in_array($ext, $curriculumExt_array))||($size>4097676)) {
                $error_feed="Select .pdf or docx assignment file less than 4Mb.";
            }else{
                $session_put=substr($ass_session, 0,4).'-'.substr($ass_session, 5);
                $end_path=$ass_class."-".$ass_term."-".$main_subject.'-'.$session_put.time().".".$ext;
                $ass_name=$location.$end_path;
                $check_if_inserted=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM assignment WHERE subject ='{$ass_subject}' AND session= '$ass_session' AND class='$ass_class' AND class_term='$ass_term' "));
                if (move_uploaded_file($tmp_name, $ass_name)) {
                    if (mysqli_query($mysqli,"INSERT INTO assignment 
                        VALUES('{}','{$a_teachers_id}','{$ass_subject}','{$ass_session}','{$ass_term}','{$ass_class}','{$end_path}','{$ass_uploaded_date}')")) {
                        echo"ok";
                    }else{
                        $error_feed="An error occured, try again.";
                    }
                }else{
                    $error_feed="Counld not upload assignment, try again.";
                }
            }
        }else{
            $error_feed='Select .pdf or docx curriculum file less than 4Mb.';
        }
    }
    echo $error_feed;
}
?>