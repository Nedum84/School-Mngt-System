<?php 

include_once("../inc/plan_connect.inc.php");
$new_password=md5(123456);

//check result
if (isset($_POST['st_class'],$_POST['st_term'],$_POST['st_pin'],$_POST['st_session'])) {
  $st_session=strtolower(trim($_POST['st_session']));
  $st_pin=strtolower(trim($_POST['st_pin']));
  $st_term=strtolower(trim($_POST['st_term']));
  $st_class=strtolower(trim($_POST['st_class']));

  if (!preg_match('/^[a-zA-Z]{3}[1-6]{1}[a-zA-Z]{1}$/', $st_class)) {
      echo "Invalid class format. E.g: JSS1A.";
    }elseif ((!preg_match('/^[0-9]{4}\/[0-9]{4}$/', $st_session))||($st_session=="none")) {
      echo "Enter valid session. E.g 2017/2018.";
    }elseif ((!preg_match('/^[a-zA-Z]+$/', $st_term)||($st_term=="none"))) {
      echo "Invalid Term. Enter first, second or third.";
    }elseif ((!empty($st_pin))&&((!preg_match('/^[0-9]+$/', $st_pin))||(strlen($st_pin)!=12))) {
      echo "Invalid Pin. Enter your 12 digit pin.";
    }else{
      $check_result=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM view_position WHERE student_id='$id' AND session='$st_session' AND school_term='$st_term' AND class='$st_class'"));
      if (!empty($check_result)) {
        if ($check_result['seen']==0) {
          $validity=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM scratch_card WHERE d_pin='$st_pin'"));
          if (!empty($validity)) {
            if (empty($validity['used_by'])) {
                mysqli_query($mysqli,"UPDATE view_position SET seen='1' WHERE id='{$check_result['id']}'");
                mysqli_query($mysqli,"UPDATE scratch_card SET used_by='{$id}' WHERE d_pin='{$st_pin}' ");
                echo "ok";
            }else{
              echo "Pin has already been used.";
            }
          }else{
            echo "Invalid scratch card. Your account will be blocked for five incorrect trials.";     
          }
        }else{
          echo "ok";
        }
      }else{
        echo "Result for ".strtoupper($st_term. " term ". $st_session." session")." Is not yet ready";
      }
    }
}
//edit profile
if (isset($_POST['name'])) {
  $my_name=trim(strtolower($_POST['name']));
  $my_class=trim(strtolower($_POST['class']));
  $my_school_name=trim(strtolower($_POST['school_name']));
  $my_form_teacher=trim(strtolower($_POST['form_teacher']));
  $my_term=trim(strtolower($_POST['term']));
  $my_session=trim(strtolower($_POST['session']));
  $my_email=trim(strtolower($_POST['email']));
  $my_gender=trim(strtolower($_POST['gender']));
  $my_age=trim(strtolower($_POST['age']));
  $my_mobile_no=$_POST['mobile_no'];
  $my_guardian_name=trim(strtolower($_POST['guardian_name']));
  $my_guardian_mobile_no=trim(strtolower($_POST['guardian_mobile_no']));
  $my_teaching_class=trim(strtolower($_POST['teaching_class']));
  $my_teaching_subject=trim(strtolower($_POST['teaching_subject']));
  $teacher_array=explode("/", $my_form_teacher);
  $d_class=$teacher_array[0];
  $d_subject=$teacher_array[1];

    if (!empty($my_email)) {
      $email_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
      SELECT email FROM students WHERE email = '{$my_email}' UNION ALL 
      SELECT email FROM teachers WHERE email = '{$my_email}' UNION ALL 
      SELECT email FROM principal WHERE email = '{$my_email}'"));
    }
    if (!empty($my_mobile_no)) {
      $phone_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
      SELECT mobile_no FROM students WHERE mobile_no = '{$my_mobile_no}' UNION ALL 
      SELECT mobile_no FROM teachers WHERE mobile_no = '{$my_mobile_no}' UNION ALL 
      SELECT mobile_no FROM principal WHERE mobile_no = '{$my_mobile_no}'"));
    }
    if (!empty($my_form_teacher)) {
      $form_teacher_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
      SELECT class FROM teachers WHERE class = '{$d_class}'"));
    }

  if (empty($my_name)) {
    echo "Enter your full name(First and Last name).";
  }elseif ((!preg_match('/^[-a-zA-Z0-9 , \. !]+$/', $my_name))) {
    echo "Enter your full name using, letters or numbers.";
  }elseif (isset($my_class)&&(!empty($my_class)&&(!preg_match('/^[a-zA-Z]{3}[1-6]{1}[a-zA-Z]{1}$/', $my_class)))) {
      echo "Invalid class format. E.g: JSS1A.";
  }elseif (isset($my_email)&&!empty($my_email)&&(!filter_var($my_email,FILTER_VALIDATE_EMAIL)) ) {
    echo 'Enter a valid email. Or leave it blank.';
  }elseif ((!empty($email_check))&&($email_check['email']!=$email)) {
      echo 'Email address already registered.';
  }elseif (!empty($my_gender)&&($my_gender!="male"&&$my_gender!="female")) {
    echo "Enter male or female as your gender.";
  }elseif (!empty($my_age)&&(!preg_match('/^[0-9]+$/', $my_age))) {
    echo "Age must be numbers.";
  }elseif (!empty($my_mobile_no)&&(!preg_match('/^[- 0-9 + ]+$/', $my_mobile_no))) {
      echo "Mobile number must be digits or integers.";
  }elseif ((!empty($phone_check))&&($phone_check['mobile_no']!=$mobile_no)) {
    echo 'Mobile number already registered.';
  }elseif (!empty($my_guardian_name)&&(!preg_match('/^[-a-zA-Z0-9 , \. !]+$/', $my_guardian_name))) {
    echo "Enter your guardian name using, letters or numbers.";
  }elseif (!empty($my_guardian_mobile_no)&&(!preg_match('/^[-a-zA-Z0-9 , \. !]+$/', $my_guardian_mobile_no))) {
    echo "Enter your guardian mobile no. with digits only";
  }else{
    if (!empty($_FILES['passport']['tmp_name'])) {
      $passport_name=$_FILES['passport']['name'];
      $passport_size=$_FILES['passport']['size'];
      $passport_tmp_name=$_FILES['passport']['tmp_name'];
      $explode=explode('.', $passport_name);
      $passport_ext     =strtolower(end($explode));
      $extType=array('jpg','jpeg','png');
      $location= 'upload/passport-upload/';
      if ((!in_array($passport_ext, $extType))||($passport_size>4097676)){
        echo "Image must be less than 4Mb in jpg or png format.";
        exit();
      }
    }
  
  $t_subjects=explode(',', $my_teaching_subject);
  $filter="";
  foreach ($t_subjects as $sub_sub) {
    $filter.=trim($sub_sub);if (end($t_subjects)!=$sub_sub) {$filter.=",";}
  }
  $my_name=trim(mysqli_real_escape_string($mysqli,htmlentities($my_name)));
  $my_email=trim(mysqli_real_escape_string($mysqli,htmlentities($my_email)));
  $my_mobile_no=trim(mysqli_real_escape_string($mysqli,htmlentities($my_mobile_no)));
  $my_class=trim(mysqli_real_escape_string($mysqli,htmlentities($my_class)));
  $my_gender=trim(mysqli_real_escape_string($mysqli,htmlentities($my_gender)));
  $my_age=trim(mysqli_real_escape_string($mysqli,htmlentities($my_age)));
  $my_guardian_name=trim(mysqli_real_escape_string($mysqli,htmlentities($my_guardian_name)));
  $my_guardian_mobile_no=trim(mysqli_real_escape_string($mysqli,htmlentities($my_guardian_mobile_no)));

    if ($status=="students") {
      if (!empty($passport_tmp_name)) {
        if ($usersz['passport']!="both.png") {unlink($location.'/'.$usersz['passport']);}
        $passport_path_name=str_replace('/', '-', $id).".".$passport_ext;
        $passport_path=$location.'/'.$passport_path_name;
        if (move_uploaded_file($passport_tmp_name, $passport_path)) {
          mysqli_query($mysqli,"UPDATE students SET passport='{$passport_path_name}' 
            WHERE st_id='{$id}'");
          resizeImg($location.'/'.$passport_path_name,$passport_size,$passport_ext);
        }
      }
      $update_query=mysqli_query($mysqli,"UPDATE students SET name='{$my_name}', class='{$my_class}', email='{$my_email}', gender='{$my_gender}', age='{$my_age}', mobile_no='{$my_mobile_no}', guardian_name='{$my_guardian_name}', guardian_mobile_no='{$my_guardian_mobile_no}' WHERE st_id='{$id}'");
      if ($update_query) {
        echo "ok";
        $_SESSION['update']="Profile updated!";
      }else{
        echo "An error occured. Try again.";
      }
    }elseif ($status=="teachers") {
      if (!empty($passport_tmp_name)) {
        if ($usersz['passport']!="both.png") { unlink($location.'/'.$usersz['passport']);}

        $passport_path_name=str_replace('/', '-', $id).".".$passport_ext;
        $passport_path=$location.'/'.$passport_path_name;
        if (move_uploaded_file($passport_tmp_name, $passport_path)) {
          mysqli_query($mysqli,"UPDATE teachers SET passport='{$passport_path_name}' 
            WHERE teachers_id='{$id}'");
          resizeImg($location.'/'.$passport_path_name,$passport_size,$passport_ext);
        }
      }
      $update_query=mysqli_query($mysqli,"UPDATE teachers SET name='{$my_name}', email   ='{$my_email}', gender      ='{$my_gender}', 
        age='{$my_age}', mobile_no   ='{$my_mobile_no}' WHERE teachers_id='{$id}'");
      if ($update_query) {
        echo "ok";
        $_SESSION['update']="Profile updated!";
      }else{
        echo "An error occured. Try again.";
      }
    }elseif ($status=="principal") {
      if (!empty($passport_tmp_name)) {
        if ($usersz['passport']!="both.png") {unlink($location.'/'.$usersz['passport']);}

        $passport_path_name=str_replace('/', '-', $id).".".$passport_ext;
        $passport_path=$location.'/'.$passport_path_name;
        if (move_uploaded_file($passport_tmp_name, $passport_path)) {
          mysqli_query($mysqli,"UPDATE principal SET passport='{$passport_path_name}' 
            WHERE principal_id='{$id}'");
          resizeImg($location.'/'.$passport_path_name,$passport_size,$passport_ext);
        }
      }
      $update_query=mysqli_query($mysqli,"UPDATE principal SET name='{$my_name}', email='{$my_email}', gender='{$my_gender}', age='{$my_age}', mobile_no ='{$my_mobile_no}' WHERE principal_id='{$id}'");
      if ($update_query) {
        echo "ok";
        $_SESSION['update']="Profile updated!";
      }else{
        echo "An error occured. Try again.";
      }
    }
  }
}
//change password
if (isset($_POST['password'])) {
  $password=$_POST['password'];
  $n_password=$_POST['n_password'];
  $c_n_password=$_POST['c_n_password'];
  if ((empty($password))||(empty($n_password))||(empty($c_n_password))) {
    echo "Fill all the password fields.";
  }elseif ((!preg_match('/^[-a-zA-Z0-9 _ \.]+$/', $password))||(!preg_match('/^[-a-zA-Z0-9 _ \.]+$/', $n_password)||(!preg_match('/^[-a-zA-Z0-9 _ \. !@#$%^&*()+]+$/', $c_n_password)))) {
    echo "Fill your password characters";
  }elseif ((strlen($password)<6)&&(strlen($n_password)<6)&&(strlen($c_n_password)<6)) {
    echo "All passwords must not be less than 6 characters or numbers";
  }elseif ($n_password!=$c_n_password) {
    echo "New passwords don't match.";
  }else{
    $password=md5($password);
    $n_password=md5($n_password);
    if ($status=="students") {
      $password_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
      SELECT password FROM students WHERE st_id = '{$id}'"));
      if ($password_check['password']!=$password) {
        echo "Incorrect old password";
      }elseif ($password_check['password']==$n_password) {
        echo "Old password can't be the same as new password";
      }else{
        $update_password=mysqli_query($mysqli,"UPDATE students SET password='{$n_password}' 
            WHERE st_id='{$id}'");
        if ($update_password) {
          echo "ok";
          $_SESSION['update']="Password changed successfully!";
        }
      }
    }elseif ($status=="teachers") {
      $password_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
      SELECT password FROM teachers WHERE teachers_id = '{$id}'"));
      if ($password_check['password']!=$password) {
        echo "Incorrect old password";
      }elseif ($password_check['password']==$n_password) {
        echo "Old password can't be the same as new password";
      }else{
        $update_password=mysqli_query($mysqli,"UPDATE teachers SET password='{$n_password}' 
            WHERE teachers_id='{$id}'");
        if ($update_password) {
          echo "ok";
          $_SESSION['update']="Password changed successfully!";
        }
      }
    }elseif ($status=="principal") {
      $password_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
      SELECT password FROM principal WHERE principal_id = '{$id}'"));
      if ($password_check['password']!=$password) {
        echo "Incorrect old password";
      }elseif ($password_check['password']==$n_password) {
        echo "Old password can't be the same as new password";
      }else{
        $update_password=mysqli_query($mysqli,"UPDATE principal SET password='{$n_password}' 
            WHERE principal_id='{$id}'");
        if ($update_password) {
          echo "ok";
          $_SESSION['update']="Password changed successfully!";
        }
      }
    }
  }

}
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
    $location= './support_images/';
    $st_file_array = array('csv');
    if (!in_array($ext, $st_file_array)) {
        $error_feedBack_st="Select excel(.csv) student register file.";
    }else{
        $handle=fopen($tmp_name, 'r');$count=0;$none=0;
        while ($row=fgetcsv($handle)) {
          if (mysqli_real_escape_string($mysqli,strtolower($row[0]))=="student id") {continue;}

            $st_id=trim(mysqli_real_escape_string($mysqli,strtolower($row[0])));
            $st_name=trim(mysqli_real_escape_string($mysqli,strtolower($row[1])));
            $st_class=trim(mysqli_real_escape_string($mysqli,strtolower($row[2])));

            $check_if_added=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id ='{$st_id}'"));
            if (empty($check_if_added)) {
                if (preg_match('/^[a-zA-Z]{3}\/[0-9]{4,}$/', $st_id)) {
                  $st_insert=mysqli_query($mysqli, "INSERT INTO students (id,st_id,name,class,password)
                      VALUES ('{}','{$st_id}','{$st_name}','{$st_class}','{$new_password}') ");
                  if ($st_insert) {
                      $count+=1;
                  }
                }else{$none++;}
            }else{
              $none++;
            }
        }$error_feedBack_st= $count." new  student registered. $none discarded because of either students id repetition or invalid student id.";
    }
    echo $error_feedBack_st;
}
if (isset($_POST['highest_check'])) {
  echo mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT MAX(st_id) FROM students "))['MAX(st_id)'];
}
//register suddent
if (isset($_POST['register_st_name'])) {
  $register_st_name=strtolower(trim($_POST['register_st_name']));
  $register_st_id=strtolower(trim($_POST['register_st_id']));
  $register_st_class=strtolower(trim($_POST['register_st_class']));
  $check_if_reg=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id ='{$register_st_id}'"));
  $highest=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT MAX(st_id) FROM students "))['MAX(st_id)'];
  if (empty($register_st_id)||empty($register_st_name)) {
    echo "Enter the ID and full name of the student.";
  }elseif (!preg_match('/^[a-zA-Z]{3}\/[0-9]{4,}$/', $register_st_id)) {
    echo "Invalid Student ID. E.g stc/1001.";
  }elseif (!preg_match('/^[-a-zA-Z0-9 , \. , \' \s]+$/', $register_st_name)) {
    echo "Student name should contain letters or numbers only.";
  }elseif ((!empty($register_st_class)&&(!preg_match('/^[a-zA-Z]{3}[1-6]{1}[a-zA-Z]{1}$/', $register_st_class)))) {
    echo "Invalid class format. E.g: JSS1A. Or leave the field blank.";
  }elseif (!empty($check_if_reg)) {
    echo "Student ID already registered. You can choose any one above $highest";
  }else{
    $register=mysqli_query($mysqli, "INSERT INTO students (id,st_id,name,class,password)
      VALUES ('{}','{$register_st_id}','{$register_st_name}','{$register_st_class}','{$new_password}') ");
    if ($register) {
      echo "ok";
    }
  }
}
//block Teachers
if (isset($_POST['t_r_Id'])) {
  $t_r_Id=$_POST['t_r_Id'];
  $block_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
      SELECT status,name FROM teachers WHERE teachers_id = '{$t_r_Id}'"));
  if ($block_check['status']==0) {
    $block_up=mysqli_query($mysqli,"UPDATE teachers SET status='1' WHERE teachers_id = '{$t_r_Id}'");
    if ($block_up) {
      echo strtoupper($block_check['name'])." blocked";
    }else{
      echo "an error occured, try again.";
    }
  }else{
    $block_up=mysqli_query($mysqli,"UPDATE teachers SET status='0' WHERE teachers_id = '{$t_r_Id}'");
    if ($block_up) {
      echo strtoupper($block_check['name'])." unblocked";
    }else{
      echo "an error occured, try again.";
    }
  }
}
if (isset($_POST['reset_password_id_t'])) {
  $reset_password_id_t=$_POST['reset_password_id_t'];
  $reset_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
      SELECT name FROM teachers WHERE teachers_id = '{$reset_password_id_t}'"));
  if (!empty($reset_check)) {
    $reseted=mysqli_query($mysqli,"UPDATE teachers SET password='{$new_password}' WHERE teachers_id='{$reset_password_id_t}'");
    if ($reseted) {
      echo strtoupper($reset_check['name'])." password reset to 123456";
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
          if (mysqli_real_escape_string($mysqli,strtolower($row[0]))=="student id") {continue;}

            $t_id=trim(mysqli_real_escape_string($mysqli,strtolower($row[0])));
            $t_name=trim(mysqli_real_escape_string($mysqli,strtolower($row[1])));
            $t_class=trim(mysqli_real_escape_string($mysqli,strtolower($row[2])));
            $t_no_of_s=trim(mysqli_real_escape_string($mysqli,strtolower($row[3])));

            $check_if_added=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id ='{$t_id}'"));
            if (empty($check_if_added)) {
                if (preg_match('/^[a-zA-Z]{1}\/[a-zA-Z]{3}\/[0-9]{3,}$/', $t_id)) {
                  $t_insert=mysqli_query($mysqli, "INSERT INTO teachers (id,teachers_id,name,class,no_of_subject,password)
                      VALUES ('{}','{$t_id}','{$t_name}','{$t_class}','{$t_no_of_s}','{$new_password}') ");
                  if ($t_insert) {
                      $count+=1;
                  }
                }else{$none++;}
            }else{
              $none++;
            }
        }$error_feedBack_st= $count." new  teachers registered. $none discarded because of either teachers id repetition or invalid teacher id.";
    }
    echo $error_feedBack_st;
}
//checking highest teachers id
if (isset($_POST['highest_check_t'])) {
  echo mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT MAX(teachers_id) FROM teachers "))['MAX(teachers_id)'];
}
//register teacher
if (isset($_POST['register_t_name'])) {
  $register_t_name=strtolower(trim($_POST['register_t_name']));
  $register_t_id=strtolower(trim($_POST['register_t_id']));
  $register_t_class=strtolower(trim($_POST['register_t_class']));
  $teacher_array=explode("/", $register_t_class);
  $d_class=$teacher_array[0];
  $d_subject=$teacher_array[1];
  if (!empty($register_t_class)) {
    $form_teacher_check= mysqli_fetch_assoc(mysqli_query($mysqli,"
    SELECT class FROM teachers WHERE class = '{$d_class}'"));
  }

  $check_if_reg=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id ='{$register_t_id}'"));
  $highest=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT MAX(teachers_id) FROM teachers"))['MAX(teachers_id)'];
  if (empty($register_t_id)||empty($register_t_name)) {
    echo "Enter the ID and full name of the teacher.";
  }elseif (!preg_match('/^[a-zA-Z]{1}\/[a-zA-Z]{3}\/[0-9]{3,}$/', $register_t_id)) {
    echo "Invalid Teacher ID. E.g t/stc/001.";
  }elseif (!preg_match('/^[-a-zA-Z0-9 , \. , \' \s]+$/', $register_t_name)) {
    echo "Teacher name should contain letters or numbers only.";
  }elseif (!empty($register_t_class)&&(!preg_match('/^[a-zA-Z]{3}[1-6]{1}[a-zA-Z]{1}\/[0-9]+$/', $register_t_class))) {
    echo "Invalid class format. Class name/No. of Subject. E.g: JSS1A/9. Or leave the field blank.";
  }elseif ((!empty($form_teacher_check))) {
    echo "Form teacher(".strtoupper($d_class).") class already taken. Contact the principal for any issue.";
  }elseif (!empty($check_if_reg)) {
    echo "Teacher ID already registered. You can choose any one above $highest";
  }else{
    $register=mysqli_query($mysqli, "INSERT INTO teachers (id,teachers_id,name,class,no_of_subject,password)
      VALUES ('{}','{$register_t_id}','{$register_t_name}','{$d_class}','{$d_subject}','{$new_password}') ");
    if ($register) {
      echo "ok";
    }
  }
}
if (isset($_POST['teacher_edit_type'])) {
  $teacher_edit_type=$_POST['teacher_edit_type'];
  $teacher_edit_id=$_POST['teacher_edit_id'];
  $teacher_edit_value=$_POST['teacher_edit_value'];
  if ($teacher_edit_type=="edit_class") {
    $valid=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE class='$teacher_edit_value'"));
    if ((!empty($teacher_edit_value))&&(!preg_match('/^[a-zA-Z]{3}[1-6]{1}[a-zA-Z]{1}$/', $teacher_edit_value))) {
      echo "Invalid class format. E.g: JSS1A.";
    }elseif (empty($valid)) {
      if (mysqli_query($mysqli,"UPDATE teachers SET class='{$teacher_edit_value}' WHERE teachers_id='{$teacher_edit_id}'")) {
          echo "Class assigned to ".$teacher_edit_id;
        }
    }elseif($valid['teachers_id']==$teacher_edit_id){
      echo "";
    }else{
      echo "Class already assigned to ".$valid['name'];
    }
  }elseif ($teacher_edit_type=="edit_no_of_s") {
    if ((!empty($teacher_edit_value))&&(!preg_match('/^[0-9]+$/', $teacher_edit_value))) {
      echo "Enter No. of Subject as a number. E.g 12";
    }else{
        if (mysqli_query($mysqli,"UPDATE teachers SET no_of_subject='{$teacher_edit_value}' WHERE teachers_id='{$teacher_edit_id}'")) {
          echo "No of subjects assigned to ".$teacher_edit_id;
        }
    }
  }
}
?>