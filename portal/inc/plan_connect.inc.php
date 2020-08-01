<?php
// include("inc/connect.inc.php");
require_once 'connect.inc.php';
if ((!isset($_SESSION['is_logged_in'])||empty($_SESSION["id"]))) {
  $_SESSION['error'][]='You are not logged in. Log In.';
  die(header('Location:../login'));
  echo ("<SCRIPT LANGUAGE='Javascript'> window.location.href='../login';</SCRIPT>");
}

    $id=$_SESSION['id'];
    $status=$_SESSION['status'];

    // $id="t/stc/001";
    // $status="teachers";
    if ($status=="students") {
      $usersz=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id='$id'"));
    }elseif ($status=="teachers") {
      $usersz=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id='$id'"));
      if (!empty($usersz['class'])) {
        $f_class=$usersz['class']."/".$usersz['no_of_subject'];
      }
    }elseif ($status=="principal") {
      $usersz=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM principal WHERE principal_id='$id'"));
    }
    $class          =$usersz['class'];
    $class_set      =substr($class, 0,4);
    $term           =$usersz['term'];
    $session        =$usersz['session'];
    $name           =$usersz['name'];
    $email          =$usersz['email'];
    $mobile_no      =$usersz['mobile_no'];
    $gender         =$usersz['gender'];
    $age            =$usersz['age'];
    $no_of_subject  =$usersz['no_of_subject'];
    $teaching_class  =$usersz['teaching_class'];
    $teaching_subject  =$usersz['teaching_subject'];
    $guardian_mobile_no  =$usersz['guardian_mobile_no'];
    $guardian_name  =$usersz['guardian_name'];

    if(!empty($usersz['passport'])){$passport= $usersz['passport'];}
    else{ $passport= "both.png";}

  if (isset($schDetails)) {
    $school_name= $schDetails['school_name'];
    $school_session= $schDetails['school_session'];
    $school_term= $schDetails['school_term'];
    $school_code= $schDetails['school_code'];
    $school_address= $schDetails['school_address'];
    $school_email= $schDetails['school_email'];
    $school_motto= $schDetails['school_motto'];
    $school_anthem= $schDetails['school_anthem'];
    $school_tel= $schDetails['school_tel'];
  }
    function checkGrade($grade){
      if ($grade >= 70) {return "a";}
      else if ($grade >= 60 && $grade < 70) {return "b";}
      else if ($grade >= 50 && $grade < 60) {return "c";}
      else if ($grade >= 40 && $grade < 50) {return "p";}
      else if ($grade < 40 && $grade >= 0) {return "f";}
      else{return "NULL";}
    }
  function showPosition($position){
    $position=(string)$position;
    $array_int_last_val=strtolower(substr($position,strlen($position)-1,(strlen($position))));

    while ($position > 0) {
      if (($position == 11)||($position == 12)||($position == 13)) {return "$position<sup>th</sup>";}
      if($position%2 == 0){
        if ($array_int_last_val == 2) {return "$position<sup>nd</sup>";}
        else{return "$position<sup>th</sup>";}
      }else{
        if ($array_int_last_val == 1) {return "$position<sup>st</sup>";}
        else if($array_int_last_val == 3) {return "$position<sup>rd</sup>";}
        else{return "$position<sup>th</sup>";}
      }
      if ($position <= 0) {return;}
    }   
  }
//session select
  function sessionSelect()
  {
    global $session;
    if(isset($session)&&(!empty($session))){echo '<option value="'.$session.'">'.$session.' </option>';}
      else{echo '<option value="none">Select session</option>';}
      echo '
      <option value="2017/2018">2017/2018</option>
      <option value="2018/2019">2018/2019</option>
      <option value="2019/2020">2019/2020</option>
      <option value="2020/2021">2020/2021</option>
      <option value="2021/2022">2021/2022</option>
      <option value="2022/2023">2022/2023</option>
      <option value="2023/2024">2023/2024</option>
      <option value="2024/2025">2024/2025</option>
      <option value="2025/2026">2025/2026</option>
      ';
  }
//term select
  function termSelect()
  {
    global $term;
    if(isset($term)&&!empty($term)){echo '<option value="first">'.strtoupper($term).' TERM</option>';}
            else{echo '<option value="none">Select term</option>';}
      echo '
        <option value="first">First term</option>
        <option value="second">Second term</option>
        <option value="third">Third term</option>
        ';
  }
//teachers/students information count
  function countInfo()
  {
    global $status;
    global $mysqli;
    return mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM notice WHERE for_who='{$status}'"));
  }
  function resizeImg($imgFile,$imgSize,$imgExt)
  {
    // $imgFile :: Image full file path from here(this current location)
    $compress_img;
    if (($imgExt=="jpg")||($imgExt=="jpeg")) {
      $compress_img=imagecreatefromjpeg($imgFile);
      if ($imgSize>2000000) {
        imagejpeg($compress_img,$imgFile,10);
      }elseif ($imgSize>1000000) {
        imagejpeg($compress_img,$imgFile,15);
      }elseif ($imgSize>500000) {
        imagejpeg($compress_img,$imgFile,20);
      }else{imagejpeg($compress_img,$imgFile,45);}
    }else{
      // $compress_img=imagecreatefrompng($imgFile);
      // if ($imgSize>2000000) {
      //   imagepng($compress_img,$imgFile,50);
      // }elseif ($imgSize>1000000) {
      //   imagepng($compress_img,$imgFile,100);
      // }elseif ($imgSize>500000) {
      //   imagepng($compress_img,$imgFile,100);
      // }else{imagepng($compress_img,$imgFile,100);}
    }
  return false;
  }
//funtion to check existence of email or others in the database
// function checkExist($db_val,$in,$value,$comparator)
// { global $mysqli;
//   $checking= mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT $db_val FROM $in WHERE $value = '{$comparator}'"));
//   if (empty($checking)) {
//     return false;
//   }else{
//     return true;
//   }
// }

?>