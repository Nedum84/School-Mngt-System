<?php 
include_once("../inc/functions.inc.php");
$new_password=md5(123456);
$time=time();

//blocking/unblocking students
if (isset($_POST['st_r_Id'])) {
  $st_r_Id=$_POST['st_r_Id'];
  $block_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
      SELECT status,name FROM students WHERE st_id = '{$st_r_Id}'"));
  if ($block_check['status']==0) {
    $block_up=mysqli_query($mysqli,"UPDATE students SET status='1' WHERE st_id='{$st_r_Id}'");
    if ($block_up) {
      echo strtoupper($block_check['name'])." blocked";
    }else{
      echo "an error occured, try again.";
    }
  }else{
    $block_up=mysqli_query($mysqli,"UPDATE students SET status='0' WHERE st_id='{$st_r_Id}'");
    if ($block_up) {
      echo strtoupper($block_check['name'])." unblocked";
    }else{
      echo "an error occured, try again.";
    }
  }
}
//reseting student password
if (isset($_POST['reset_password_id'])) {
  $reset_password_id=$_POST['reset_password_id'];
  $reset_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
      SELECT name FROM students WHERE st_id = '{$reset_password_id}'"));
  if (!empty($reset_check)) {
    $reseted=mysqli_query($mysqli,"UPDATE students SET password='{$new_password}' WHERE st_id='{$reset_password_id}'");
    if ($reseted) {
      echo strtoupper($reset_check['name'])." password reset to 123456";
    }else{
      echo "an error occured, try again.";
    }
  }else{
    echo "Invalid user.";
  }
}
//upload adding student file
if (isset($_FILES['st_file'])) {
    $st_file= $_FILES["st_file"]["name"];
    $explode=explode('.', $st_file);
    $ext     =end($explode);
    $type     =$_FILES['st_file']['type'];
    $size     =$_FILES['st_file']['size'];
    $tmp_name   =$_FILES['st_file']['tmp_name'];
    $st_file_array = array('csv');
    if (!in_array($ext, $st_file_array)) {
        $error_feedBack_st="Select excel(.csv) student register file.";
    }else{
        $handle=fopen($tmp_name, 'r');$count=0;$none=0;
        while ($row=fgetcsv($handle)) {
          if (mysqli_real_escape_string($mysqli,strtolower($row[0]))=="class") {continue;}

            $st_class=trim(mysqli_real_escape_string($mysqli,strtolower($row[0])));
            $st_name=trim(mysqli_real_escape_string($mysqli,ucwords($row[1])));

            if (preg_match('/^[jss|sss]{3}[1-6]{1}[a-zA-Z]{1}$/', $st_class)) {
				        $st_id= getStId($st_class);
                $st_insert=mysqli_query($mysqli, "INSERT INTO students (st_id,name,class,password,date_registered)
                      VALUES ('{$st_id}','{$st_name}','{$st_class}','{$new_password}','{$time}') ");
                if ($st_insert) {
                      $count+=1;
                }
            }else{$none++;}
        }$error_feedBack_st= " <span class='success'>$count new  student registered.</span> ";
        if ($none>0) {
        	$error_feedBack_st.="$none discarded because of wrong student class entered.";
        }
    }
    echo $error_feedBack_st;
}
//getting students ID
if (isset($_POST['st_Class'])) {
  $st_Class=trim(strtolower($_POST['st_Class']));

  echo getStId($st_Class);
}
// editing students profile
if (isset($_POST['student_edit_type'])) {
  	$student_edit_type=$_POST['student_edit_type'];
  	$student_edit_id=$_POST['student_edit_id'];
  	$student_edit_value=$_POST['student_edit_value'];

	$get_st_details=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id='$student_edit_id'"));

  if ($student_edit_type=="edit_st_class") {
    if ((!preg_match('/^[jss|sss]{3}[1-6]{1}[a-zA-Z]{1}$/', $student_edit_value))) {
      echo "Invalid class format. E.g: JSS1A.";
    }else{
      if (mysqli_query($mysqli,"UPDATE students SET class='{$student_edit_value}' WHERE st_id='{$student_edit_id}'")) {
          echo "$student_edit_value Class assigned to <b>".ucwords($get_st_details['name'])." (".$student_edit_id.")</b>";
        }
    }
  }



}

//register suddent
if (isset($_POST['register_st_name'])) {
  $register_st_name=strtolower(trim($_POST['register_st_name']));
  $register_st_id=strtolower(trim($_POST['register_st_id']));
  $register_st_class=strtolower(trim($_POST['register_st_class']));
  $check_if_reg=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id ='{$register_st_id}'"));

  if (empty($register_st_class)||empty($register_st_name)) {
    echo "Enter the class and full name of the student.";
  }elseif (!preg_match('/^[-a-zA-Z0-9 , \. , \' \s]+$/', $register_st_name)) {
    echo "Student name should contain letters or numbers only.";
  }elseif ((!empty($register_st_class)&&(!preg_match('/^[jss|sss]{3}[1-6]{1}[a-zA-Z]{1}$/', $register_st_class)))) {
    echo "Invalid class format. E.g: JSS1A.";
  }elseif (!empty($check_if_reg)) {
    echo "Student ID already registered. Enter another one";
  }elseif ($register_st_id!=getStId($register_st_class)) {
    echo "Invalid student ID entered. Use <strong>".getStId($register_st_class)."</strong>";
  }else{
    $register=mysqli_query($mysqli, "INSERT INTO students (id,st_id,name,class,password,date_registered)
      VALUES ('{}','{$register_st_id}','{$register_st_name}','{$register_st_class}','{$new_password}','{$time}') ");
    if ($register) {
      echo "<span class='success'>Student (<strong>".ucwords($register_st_name)."</strong>) registered successfully with the ID <strong>$register_st_id</strong> and password <strong>123456</strong>.</span>";
    }
  }
}
// getting teachers id
if (isset($_POST['t_Year'])) {
  $t_Year=trim(strtolower($_POST['t_Year']));

  echo getTId($t_Year);
}
//block Teachers
if (isset($_POST['t_r_Id'])) {
  $t_r_Id=$_POST['t_r_Id'];
  $block_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
      SELECT status,name FROM teachers WHERE teachers_id = '{$t_r_Id}'"));
  if ($block_check['status']==0) {
    $block_up=mysqli_query($mysqli,"UPDATE teachers SET status='1' WHERE teachers_id = '{$t_r_Id}'");
    if ($block_up) {
      echo ucwords($block_check['name'])." blocked";
    }else{
      echo "an error occured, try again.";
    }
  }else{
    $block_up=mysqli_query($mysqli,"UPDATE teachers SET status='0' WHERE teachers_id = '{$t_r_Id}'");
    if ($block_up) {
      echo ucwords($block_check['name'])." unblocked";
    }else{
      echo "an error occured, try again.";
    }
  }
}
//reset teachers password
if (isset($_POST['reset_password_id_t'])) {
  $reset_password_id_t=$_POST['reset_password_id_t'];
  $reset_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
      SELECT name FROM teachers WHERE teachers_id = '{$reset_password_id_t}'"));
  if (!empty($reset_check)) {
    $reseted=mysqli_query($mysqli,"UPDATE teachers SET password='{$new_password}' WHERE teachers_id='{$reset_password_id_t}'");
    if ($reseted) {
      echo ucwords($reset_check['name'])." password reset to 123456";
    }else{
      echo "an error occured, try again.";
    }
  }else{
    echo "Invalid user.";
  }
}
//upload adding teachers file
if (isset($_FILES['t_file'])) {
    $t_file= $_FILES["t_file"]["name"];
    $explode=explode('.', $t_file);
    $ext     =end($explode);
    $type     =$_FILES['t_file']['type'];
    $size     =$_FILES['t_file']['size'];
    $tmp_name   =$_FILES['t_file']['tmp_name'];
    $t_file_array = array('csv');

    if (!in_array($ext, $t_file_array)) {
        $error_feedBack_st="Select excel(.csv) teachers register file.";
    }else{
        $handle=fopen($tmp_name, 'r');$count=0;$none=0;
        while ($row=fgetcsv($handle)) {
          if (mysqli_real_escape_string($mysqli,strtolower($row[0]))=="name") {continue;}

            $t_name=trim(mysqli_real_escape_string($mysqli,strtolower($row[0])));
            $register_t_year=trim(mysqli_real_escape_string($mysqli,strtolower($row[1])));
            if (empty($register_t_year)) {
              $register_t_year=='2013';
            }

            if (preg_match('/^20\d{2}+$/', $register_t_year)) {
            	$t_id= getTId($register_t_year);
              	$t_insert=mysqli_query($mysqli, "INSERT INTO teachers (id,teachers_id,name,password,date_registered)
                  VALUES ('{}','{$t_id}','{$t_name}','{$new_password}','{$time}') ");
              if ($t_insert) {
                  $count+=1;
              }
            }else{$none++;}

        }$error_feedBack_st= " <span class='success'><b> $count </b> new  teachers registered.</span> ";
        if ($none>0) {
        	$error_feedBack_st.="$none discarded because of wrong year of entrance entered class entered.";
        }
    }
    echo $error_feedBack_st;
}
//register teacher
if (isset($_POST['register_t_name'])) {
  $register_t_name=strtolower(trim($_POST['register_t_name']));
  $register_t_id=strtolower(trim($_POST['register_t_id']));
  $register_t_year=strtolower(trim($_POST['register_t_year']));

  $check_if_reg=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id ='{$register_t_id}'"));
  if (empty($register_t_year)||empty($register_t_name)) {
    echo "Enter the teacher's year of entrance and full name of the teacher.";
  }elseif (!preg_match('/^[-a-zA-Z0-9 , \. , \' \s]+$/', $register_t_name)) {
    echo "Teacher name should contain letters or numbers only.";
  }elseif ((!preg_match('/^20\d{2}+$/', $register_t_year))) {
    echo "Enter a valid year e.g 2015.";
  }elseif (!empty($check_if_reg)) {
    echo "Teacher ID already registered. You can choose <strong>".getTId($register_t_year)."</strong>";;
  }elseif ($register_t_id!=getTId($register_t_year)) {
    echo "Invalid Teacher ID entered. Use <strong>".getTId($register_t_year)."</strong>";
  }else{
    $register=mysqli_query($mysqli, "INSERT INTO teachers (id,teachers_id,name,class,no_of_subject,password,date_registered)
      VALUES ('{}','{$register_t_id}','{$register_t_name}','{$d_class}','{$d_subject}','{$new_password}','{$time}') ");
    if ($register) {
      echo "<span class='success'>Teacher (<strong>".ucwords($register_t_name)."</strong>) registered successfully with the ID <strong>$register_t_id</strong> and password <strong>123456</strong>.</span>";
    }
  }
}
// editing teachers profile
if (isset($_POST['teacher_edit_type'])) {
  $teacher_edit_type=$_POST['teacher_edit_type'];
  $teacher_edit_id=$_POST['teacher_edit_id'];
  $teacher_edit_value=$_POST['teacher_edit_value'];

    $get_t_details=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id='$teacher_edit_id'"));
  if ($teacher_edit_type=="edit_no_of_s") {
    if ((!empty($teacher_edit_value))&&(!preg_match('/^[0-9]+$/', $teacher_edit_value))) {
      echo "Enter No. of Subject as a number. E.g 12";
    }else{
        if (mysqli_query($mysqli,"UPDATE teachers SET no_of_subject='{$teacher_edit_value}' WHERE teachers_id='{$teacher_edit_id}'")) {
          echo "$teacher_edit_value subjects assigned to ".ucwords($get_t_details['name'])." Class";
        }
    }
  }else{
    
	}
}

//editing teachers subjects
if (isset($_POST['edit_sub_t_id'])) {
  $edit_sub_t_id=$_POST['edit_sub_t_id'];
  $get_t_details=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id ='{$edit_sub_t_id}'"));
  $current_Sub=explode(',', $get_t_details['teaching_subject']);
  $allSub=mysqli_query($mysqli,"SELECT * FROM subjects");
  $output='
          <form method="post" id="adding_teachers_sub" style="display: block;">
            <h4>'.ucwords($get_t_details['name'])."'s".' Subject(s)</h4>

            <label for="subject">Select Subject</label><hr>
            ';
  
  while ($row=mysqli_fetch_assoc($allSub)) {
      $value=(in_array($row['subject_code'], $current_Sub))?"checked":"";
      $output.='
        <div>
          <input type="checkbox"  
            id="'.$row['subject_code'].'" 
            name="'.$row['subject_code'].'" 
            '.$value.'>

          <label for="'.$row['subject_code'].'" class="desc">'.ucfirst($row['subject']).'</label>
        </div>
      ';
    }
  $output.='<input type="hidden" value="'.$edit_sub_t_id.'" id="edit_sub_t_id">
            <div class="er">
              <span class="feedback"></span>
            </div>
            <hr>
            <div class="modal_footer">
              <button id="notify_student_button" type="submit">
                <i class="fa fa-check"></i><span> Assign</span>
              </button>
              <button id="footer_close_button" class="modal_close">
                <i class="fa fa-times"></i><span> close</span>
              </button>
            </div>
          </form>';

  echo $output;
}
//Updating teachers table for subject editing
if (isset($_POST['selSubjects'])) {
  $selSubjects=$_POST['selSubjects'];
  $edit_sub_teacher_id=$_POST['edit_sub_teacher_id'];
  $upDate_t_sub=mysqli_query($mysqli,"UPDATE teachers SET teaching_subject= '$selSubjects' 
                            WHERE teachers_id= '$edit_sub_teacher_id' ");
  if ($upDate_t_sub) {
    $eachSub_array=explode(',', $selSubjects);
    
    foreach ($eachSub_array as $key) {
      $get_subNames=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects 
                    WHERE subject_code='$key' "));
      // $eachSub[]=$get_subNames['subject'];
      $eachSub .=ucwords($get_subNames['subject'])."<br>";
    }
    // echo(implode(',', $eachSub)) ;
    echo "$eachSub";
  }else{
    echo "error";
  }

}

//editing teachers class view modal
if (isset($_POST['edit_class_t_id'])) {
  $edit_class_t_id=$_POST['edit_class_t_id'];
  $get_t_details=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id ='{$edit_class_t_id}'"));
  $current_Class=explode(',', $get_t_details['teaching_class']);
  $allClass=mysqli_query($mysqli,"SELECT DISTINCT class FROM students WHERE graduate_status= '0' ");
  $output='
          <form method="post" id="adding_teachers_class" style="display: block;">
            <h4>'.ucwords($get_t_details['name'])."'s".' Class(es)</h4>

            <label for="subject">Select Class(es) Thought by '.ucwords($get_t_details['name']).'</label><hr>
            ';
  
  while ($row=mysqli_fetch_assoc($allClass)) {
      $value=(in_array($row['class'], $current_Class))?"checked":"";
      $output.='
        <div>
          <input type="checkbox"  
            id="'.$row['class'].'" 
            name="'.$row['class'].'" 
            '.$value.'>

          <label for="'.$row['class'].'" class="desc">'.ucfirst($row['class']).'</label>
        </div>
      ';
    }
  $output.='<input type="hidden" value="'.$edit_class_t_id.'" id="edit_class_t_id">
            <div class="er">
              <span class="feedback"></span>
            </div>

            <hr>
            <div class="modal_footer">
              <button id="notify_student_button" type="submit">
                <i class="fa fa-check"></i><span> Assign</span>
              </button>
              <button id="footer_close_button" class="modal_close">
                <i class="fa fa-times"></i><span> close</span>
              </button>
            </div>
          </form>';

  echo $output;
}
//Updating teachers table for subject editing
if (isset($_POST['sel_Classes'])) {
  $sel_Classes=(string)$_POST['sel_Classes'];
  $edit_class_teacher_id=$_POST['edit_class_teacher_id'];
  $upDate_t_sub=mysqli_query($mysqli,"UPDATE teachers SET teaching_class= '$sel_Classes' 
                            WHERE teachers_id= '$edit_class_teacher_id' ");
  if ($upDate_t_sub) {
    echo ucwords(str_replace(',', '<br> ', $sel_Classes));
  }else{
    echo "error";
  }

}

//editing Form teachers class view modal
if (isset($_POST['formT_class_t_id'])) {
  $formT_class_t_id=$_POST['formT_class_t_id'];
  $get_t_details=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id ='{$formT_class_t_id}'"));
  $current_Form_Class=explode(',', $get_t_details['class']);
  $allClass=mysqli_query($mysqli,"SELECT DISTINCT class FROM students WHERE graduate_status= '0' ");
  $output='
          <form method="post" id="adding_form_teachers" style="display: block;">
            <h4>'.ucwords($get_t_details['name'])."'s".' Form Class</h4>

            <label for="subject">Select the Class Headed by '.ucwords($get_t_details['name']).'</label><hr>
            ';
  
  while ($row=mysqli_fetch_assoc($allClass)) {
      $value=(in_array($row['class'], $current_Form_Class))?"checked":"";

      $output.='
        <div>
          <input type="radio"  
            id="'.$row['class'].'" 
            name="formT_class" 
            '.$value.'>

          <label for="'.$row['class'].'" class="desc">'.ucfirst($row['class']).'</label>
        </div>
      ';
    }
    $no_class=(empty($get_t_details['class']))?"checked":"";
  $output.='<div>
            <input type="radio" id="none" name="formT_class" '.$no_class.'>

            <label for="none" class="desc">No Class</label>
          </div>

            <input type="hidden" value="'.$formT_class_t_id.'" id="formT_class_t_id">
            <div class="er">
              <span class="feedback"></span>
            </div>

            <hr>
            <div class="modal_footer">
              <button id="notify_student_button" type="submit">
                <i class="fa fa-check"></i><span> Assign</span>
              </button>
              <button id="footer_close_button" class="modal_close">
                <i class="fa fa-times"></i><span> close</span>
              </button>
            </div>
          </form>';

  echo $output;
}
//Updating teachers table for subject editing
if (isset($_POST['sel_formT_Classes'])) {
  $sel_formT_Classes=$_POST['sel_formT_Classes'];
  $form_class_teacher_id=$_POST['form_class_teacher_id'];

  $check_valid=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE class='$sel_formT_Classes' "));
    if (!empty($check_valid)&&($check_valid['teachers_id']!=$form_class_teacher_id)&&(!empty($sel_formT_Classes))) {
      echo "Class already assigned to ".ucwords($check_valid['name'])." (".$check_valid['teachers_id'].")";
    }else{      
      if (mysqli_query($mysqli,"UPDATE teachers SET class='{$sel_formT_Classes}' WHERE teachers_id='{$form_class_teacher_id}'")) {
          echo "ok";
        }else{
          echo "An erro occured, try again";
        }
    }

}















?>