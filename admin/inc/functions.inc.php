<?php 
require_once 'connect.inc.php';
// include_once ('../portal/inc/connect.inc.php');
if ((!isset($_SESSION['user_id'])||empty($_SESSION["user_id"]))) {
  die(header('Location:index'));
  echo ("<SCRIPT LANGUAGE='Javascript'> window.location.href='index';</SCRIPT>");
}

$user_id=$_SESSION['user_id'];
$usersz=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM principal WHERE principal_id = '$user_id' "));
if ($usersz) {
    $term     	=$usersz['term'];
    $session  	=$usersz['session'];
    $name     	=ucwords($usersz['name']);
    $email    	=$usersz['email'];
    $mobile_no	=$usersz['mobile_no'];
    $gender   	=$usersz['gender'];
    $age      	=$usersz['age'];
    $passport 	=$usersz['passport'];
    $school   	=$usersz['school'];
    $time       =time();


    if(!empty($usersz['passport'])){$passport= $usersz['passport'];}
    else{ $passport= "both.png";}
	if ($usersz['current']!=1) {
		$user_level="Staff";
	}else{
		$user_level="Principal";
	}
}

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
//count dashboard numbers
$sub_numbers=mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM subjects "));
$st_numbers=mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM students WHERE graduate_status='0' "));
$t_numbers=mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM teachers WHERE status='0' "));
$info_numbers=mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM news "));


// functions...

//session select
  function sessionSelect()
  {
    global $school_session;
    $session=$school_session;

      for ($i=2017; $i < 2025; $i++) {
        $session_val=$i."/".($i+1);
        if(isset($session)&&(!empty($session))&&($session==$session_val)){
          echo '<option value="'.$session.'" selected>'.$session.' </option>';
        }else{
          echo '<option value="'.$session_val.'">'.$session_val.' </option>';
        }
      }

  }
//term select
  function termSelect()
  {
    global $school_term;
    $term=$school_term;
    if(isset($term)&&!empty($term)){echo '<option value="'.$term.'">'.strtoupper($term).' TERM</option>';}
            else{echo '<option value="none" disabled>Select term</option>';}
      echo '
        <option value="first">First term</option>
        <option value="second">Second term</option>
        <option value="third">Third term</option>
        ';
  }

// sanitize input
function sanitize($input)
{
	global $mysqli;
	$input=trim($input);
	$input=strip_tags($input,"<a><b><p><i><img><h1>");
	$input=mysqli_real_escape_string($mysqli,$input);

	return $input;
}
//resize img
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
  //generating students Id
function getStId($st_Class)
{
    global $school_code;
    global $mysqli;

    $st_Level=substr($st_Class, 0,3);//jss or sss
    $current_class=(int)substr($st_Class, 3,1);//resturns 1 to 3
    $pattern=(string)strtolower($school_code."/".returnStartYr($st_Level,$current_class));
    $highest=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT MAX(st_id) FROM students WHERE st_id LIKE '%".$pattern."%' "))['MAX(st_id)'];
    $explode=explode('/', $highest);
    $get_Int     =(int)end($explode);
    if (empty($highest)) {
      return $stIdRequired=strtolower($school_code).'/'.returnStartYr($st_Level,$current_class).'01';
    }else{
      return $stIdRequired=strtolower($school_code).'/'.($get_Int+1);
  }

}
  function returnStartYr($st_Level,$current_class)
  {
    global $school_session;
    $session_Yr=substr($school_session, 2,2);
    if ($st_Level=='jss') {
      if ($current_class==1) {
        return $session_Yr;
      }elseif ($current_class==2) {
        return $session_Yr-1;
      }elseif ($current_class==3) {
        return $session_Yr-2;
      }
    }elseif ($st_Level=='sss') {
      if ($current_class==1) {
        return $session_Yr-3;
      }elseif ($current_class==2) {
        return $session_Yr-4;
      }elseif ($current_class==3) {
        return $session_Yr-5;
      }
    }
  }

  //generating teachers Id
function getTId($t_Year)
{
    global $school_code;
    global $mysqli;
    global $school_session;

    $session_Yr=substr($t_Year, 2,2);
    $pattern=(string)strtolower("t/".$school_code."/".$session_Yr);
    $highest=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT MAX(teachers_id) FROM teachers WHERE teachers_id LIKE '%".$pattern."%' "))['MAX(teachers_id)'];
    $explode=explode('/', $highest);
    $get_Int     =(int)end($explode);
    if (empty($highest)) {
      return $stIdRequired=strtolower("t/".$school_code).'/'.$session_Yr.'01';
    }else{
      return $stIdRequired=strtolower("t/".$school_code).'/'.($get_Int+1);
  }

}
  //generating staff/principal Id
function getPrincipalId($t_Year,$user_level_code)
{
    global $school_code;
    global $mysqli;
    global $school_session;

    $session_Yr=substr($t_Year, 2,2);
    $pattern=(string)strtolower($user_level_code."/".$school_code."/".$session_Yr);
    $highest=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT MAX(principal_id) FROM teachers WHERE principal_id LIKE '%".$pattern."%' "))['MAX(principal_id)'];
    $explode=explode('/', $highest);
    $get_Int     =(int)end($explode);
    if (empty($highest)) {
      return $stIdRequired=strtolower($user_level_code."/".$school_code).'/'.$session_Yr.'1';
    }else{
      return $stIdRequired=strtolower($user_level_code."/".$school_code).'/'.($get_Int+1);
  }

}

//funtion to check existence of email or others in the database
function checkExist($db_val,$in,$value,$comparator)
{ global $mysqli;
  $checking= mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT $db_val FROM $in WHERE $value = '{$comparator}'"));
  if (empty($checking)) {
    return false;
  }else{
    return true;
  }
}
//funtion to details in a database
function getDetails($db_val,$in,$value,$comparator)
{ global $mysqli;
  $checking= mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT $db_val FROM $in WHERE $value = '{$comparator}'"));
  if (empty($checking)) {
    return false;
  }else{
    return $checking;
  }
}
//check grade
function checkGrade($grade){
  if ($grade >= 70) {return "a";}
  else if ($grade >= 60 && $grade < 70) {return "b";}
  else if ($grade >= 50 && $grade < 60) {return "c";}
  else if ($grade >= 40 && $grade < 50) {return "p";}
  else if ($grade < 40 && $grade >= 0) {return "f";}
  else{return NULL;}
}



?>