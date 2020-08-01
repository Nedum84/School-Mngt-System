<?php 

include_once("../inc/plan_connect.inc.php");

if (isset($_POST['curFeedTeacher'])) {
  $feedCount=mysqli_query($mysqli,"SELECT * FROM curriculum WHERE class='$class_set' AND session='$session' AND class_term='$term' "); 
  $curOutput='';
  while ($row=mysqli_fetch_assoc($feedCount)) {
  $main_subject =strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects 
          WHERE subject_code ='{$row['subject']}'"))['subject']);
  $curOutput.='
        <div class="c_cols _cols">
          <h4>Curriculum '.strtoupper($row['class']).'</h4>
          <p style="text-transform:capitalize"><span>Subject: </span> '.$main_subject.'</p>
          <p style="text-transform:capitalize"><span>Term: </span> '.$row['class_term'].' Term</p>
          <p><span>Session: </span> '.$row['session'].'</p>
          <p>
            <button class="c_view" data-type="view" data-viewPath='.$row['file_path'].'> <i class="fa fa-eye"></i> View</button>
            <button class="c_download" data-type="download" data-viewPath='.$row['file_path'].'> <i class="fa fa-download"></i> Download</button>
          </p>
        </div>
        ';
  }
  echo $curOutput;
}
if (isset($_POST['resFeedTeacher'])) {
  $feedCount=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE class='$class' AND session='$session' AND school_term='$term' "); 
  $resOutput='';
  while ($row=mysqli_fetch_assoc($feedCount)) {
  $main_subject =strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects 
          WHERE subject_code ='{$row['subject']}'"))['subject']);

  if (strpos($resOutput, $row['session'].'.'.$row['school_term'].'.'.$row['subject'].'.'
          .$row['class'])==true) {continue;}

  $stdNumber=mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM result_upload WHERE teachers_id='{$row['teachers_id']}' AND session='$session' AND school_term='$term' AND subject='{$row['subject']}' AND class='{$row['class']}' "));
  $teacherName=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT name FROM teachers WHERE teachers_id='{$row['teachers_id']}'"))['name'];
  $resOutput.='
        <div class="r_cols _cols">
          <h4><span style="text-transform:capitalize">'.$main_subject.'</span> Result '.strtoupper($row['class']).'</h4>
          <p style="text-transform:capitalize"><span>Term: </span> '.$row['school_term'].' Term</p>
          <p style="text-transform:capitalize"><span>Session: </span> '.$row['session'].'</p>
          <p style="text-transform:capitalize"><span>Teacher: </span> '.$teacherName.'</p>
          <p style="text-transform:capitalize"><span>Date: </span> '.timer_converter_f($row['date_uploaded']).'</p>
          <p style="text-transform:capitalize"><span>Number of students: </span> '.$stdNumber.'</p>
          <p style="text-transform:lowercase;visibility: hidden;height:0px;">
          <span style="text-transform:capitalize">Result Id: </span> '.$row['session'].'.'.$row['school_term'].'.'.$row['subject'].'.'.$row['class'].'
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

//moving to the position assigning table or updating it OR equivalent of approving result
if (isset($_POST['approve_termly_result'])) {

  $check_if_all_uploaded=mysqli_num_rows(mysqli_query($mysqli,"SELECT DISTINCT subject FROM result_upload WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}' "));
  if (empty($class)) {
    echo "You are not a Form Teacher. Contact the form teacher.";
  }elseif ((int)$check_if_all_uploaded!=(int)$no_of_subject) {
    echo "All teachers have not uploaded their result for ".strtoupper($class)." class ".$session." session. Your class is offering ".$no_of_subject." subjects or update your profile";
  }else {
    $approved=0;
    $select_class=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}' ");
    $inserted_num=0;
    $updated_num=0;
    while ($get_student=mysqli_fetch_assoc($select_class)) {
      if (!empty($get_student)) {
        $sum=0;$count=0;
        $student_id=$get_student['student_id'];
        $student_move=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE student_id= '{$student_id}' AND session='{$session}' AND school_term='{$term}' ");
        while ($row=mysqli_fetch_assoc($student_move)) {
          $sum=$sum+(float)$row['total_score'];
          $count++;   
        }$average=$sum/$count;
        
        $check_if_inserted=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM view_position WHERE 
          student_id= '{$student_id}' AND session='{$session}' AND school_term='{$term}'"));
        if (empty($check_if_inserted)) {
         $insert=mysqli_query($mysqli,"INSERT INTO view_position (student_id,form_teachers_id,class, session,school_term, total_score, average_score,class_position) VALUES('{$student_id}','{$id}','{$class}','{$session}','{$term}','{$sum}','{$average}','{0}')"); 
          if ($insert) {
             $inserted_num++;
          }
        }else{
          $update_total=mysqli_query($mysqli,"UPDATE view_position SET total_score='{$sum}', 
              average_score='{$average}', form_teachers_id='{$id}' WHERE student_id='{$student_id}' AND class='{$class}' AND session='{$session}' AND school_term='{$term}'");
          if ($update_total) {
            $updated_num++;
          }
        }
      }
    }
    echo $inserted_num." Students records approved, ".$updated_num." Students records Updated.";
  }
}

//assigning position
if (isset($_POST['assign_termly_position'])) {

  $get_student=mysqli_query($mysqli,"SELECT * FROM view_position WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}'");
  if (mysqli_num_rows($get_student)>0) {

    $result_store=array();
    while ($row=mysqli_fetch_assoc($get_student)) {
      $result_store[$row['student_id']]=(float)$row['total_score'];
    }
    arsort($result_store);
    if (mysqli_query($mysqli,"UPDATE view_position SET class_position='0' WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}'")) {
        $position=1;
        foreach ($result_store as $key => $value) {
        $equal_checking=mysqli_query($mysqli,"SELECT * FROM view_position WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}' AND total_score='{$value}'");
        if ($x>=1) {$position--;}
        $y=mysqli_num_rows($equal_checking);$x=0;
        while ($equal=mysqli_fetch_assoc($equal_checking)) {
          if ($equal['class_position']==0) {
              $query=mysqli_query($mysqli,"UPDATE view_position SET class_position='{$position}' WHERE student_id= '{$equal['student_id']}' AND  class='{$class}' AND session='{$session}' AND school_term='{$term}'");
          }else{
            $x++;
            break;
          }
        }
        $position=$position+1;
      }
    }
    if($position!=1){echo ($position-1)." student's termly positions assigned. You can now view and add comment to the result";}else{echo "Result not approved yet"; exit();}
    
  }else{
    echo "Result not approved yet"; exit();
  }
}

//Annual approving result
if (isset($_POST['approve_annual_result'])) {

  if (empty($class)) {
    echo "You are not a Form Teacher. Contact the form teacher.";
  }elseif ($school_term=='third') {
    echo "Annual approve result is done on third term only";
  }else {

    $get_student=mysqli_query($mysqli,"SELECT * FROM view_position WHERE class='{$class}' AND session='{$session}' AND school_term != 'annual' ");

    $inserted_num=0;
    $updated_num=0;
    while ($each_student=mysqli_fetch_assoc($get_student)) {
      if (!empty($each_student)) {
        $sum=0;$count=0;
        $student_id=$each_student['student_id'];
        $student_move=mysqli_query($mysqli,"SELECT * FROM view_position WHERE student_id= '{$student_id}' AND session='{$session}' AND school_term != 'annual' ");
        while ($row=mysqli_fetch_assoc($student_move)) {
          $sum=$sum+(float)$row['total_score'];
          $count++;   
        }$average=$sum/$count;
        
        $check_if_inserted=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM view_position WHERE 
          student_id= '{$student_id}' AND session='{$session}' AND school_term='annual' "));
        if (empty($check_if_inserted)) {
          $insert=mysqli_query($mysqli,"INSERT INTO view_position (student_id,form_teachers_id,class, session,school_term, total_score, average_score,class_position) VALUES('{$student_id}','{$id}','{$class}','{$session}','annual','{$sum}','{$average}','{0}')"); 
          if ($insert) {
             $inserted_num++;
          }
        }else{
          $update_total=mysqli_query($mysqli,"UPDATE view_position SET total_score='{$sum}', 
              average_score='{$average}', form_teachers_id='{$id}' WHERE student_id='{$student_id}' AND class='{$class}' AND session='{$session}' AND school_term='annual' ");
          if ($update_total) {
            $updated_num++;
          }
        }
      }
    }
    echo $inserted_num." Students records approved, ".$updated_num." Students records Updated.";
    
  }
}

//assigning annual position
if (isset($_POST['assign_annual_position'])) {

  $get_student=mysqli_query($mysqli,"SELECT * FROM view_position WHERE class='{$class}' AND session='{$session}' AND school_term = 'annual' ");
  if (mysqli_num_rows($get_student)>0) {

    $result_store=array();
    while ($row=mysqli_fetch_assoc($get_student)) {
      $result_store[$row['student_id']]=(float)$row['total_score'];
    }
    arsort($result_store);
    if (mysqli_query($mysqli,"UPDATE view_position SET class_position='0' WHERE class='{$class}' AND session='{$session}' AND school_term='annual' ")) {
        $position=1;
        foreach ($result_store as $key => $value) {
        $equal_checking=mysqli_query($mysqli,"SELECT * FROM view_position WHERE class='{$class}' AND session='{$session}' AND school_term='annual' AND total_score='{$value}'");
        if ($x>=1) {$position--;}
        $y=mysqli_num_rows($equal_checking);$x=0;
        while ($equal=mysqli_fetch_assoc($equal_checking)) {
          if ($equal['class_position']==0) {
              $query=mysqli_query($mysqli,"UPDATE view_position SET class_position='{$position}' WHERE student_id= '{$equal['student_id']}' AND  class='{$class}' AND session='{$session}' AND school_term='annual' ");
          }else{
            $x++;
            break;
          }
        }
        $position=$position+1;
      }
    }
    if($position!=1){echo ($position-1)." student's ANNUAL positions assigned. You can now view and add comment to the annual result";}else{echo "Annual result not approved yet"; }
    
  }else{
    echo "Annual result not approved yet"; exit();
  }
}
//checking for termly comment adding
if (isset($_POST['add_termly_Comment'])) {
  $check_if=mysqli_query($mysqli,"SELECT * FROM view_position WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}'");
  echo mysqli_num_rows($check_if);

}
//checking for annual comment adding
if (isset($_POST['add_annual_Comment'])) {
  $check_if=mysqli_query($mysqli,"SELECT * FROM view_position WHERE class='{$class}' AND session='{$session}' AND school_term='annual' ");
  
  echo mysqli_num_rows($check_if);

}


//comment adding
if (isset($_POST['type'],$_POST['id'],$_POST['dValue'])) {
  $data_type=$_POST['type'];
  $id=$_POST['id'];
  $dValue=$_POST['dValue'];
  if ($data_type=="f_comment") {
    if (preg_match('/^[-a-zA-Z0-9 , \. ! \' "]+$/', $dValue)) {
      $dValue=trim(mysqli_Real_escape_string($mysqli,htmlentities($dValue)));
      if (mysqli_query($mysqli,"UPDATE view_position SET teacher_comment='{$dValue}' WHERE id='{$id}'")) {
          echo "Comment added.";
        }
    }else{
      echo "Comment not updated. Enter letters and numbers as your comment.";
    }
  }
}


?>