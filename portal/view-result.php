<?php
include("inc/header.inc.php");
if (isset($_GET['st_class'],$_GET['st_term'],$_GET['st_session'])) {
  $st_class=$_GET['st_class'];
  $st_term=$_GET['st_term'];
  $st_session=$_GET['st_session'];
    $getStudent=mysqli_query($mysqli,"SELECT * FROM view_position WHERE student_id='{$id}' AND class='{$st_class}' AND session='{$st_session}' AND school_term='{$st_term}'");
}else{header('Location:home');}
?>
  <title><?php echo strtoupper("Result $term Term $session Session"); ?></title>
  <div class="left_divs">
    <?php include 'inc/left_menu.inc.php'; ?>
  </div><!-- 
  --><div class="contents">
    <center class="students_container_result_wrapper">
      <div class="students_container_result">
          <?php 
          while ($row=mysqli_fetch_assoc($getStudent)) {
            $getStudentName=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id='{$row['student_id']}'"));
            $form_teacher=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE class='{$class}'"))['name'];
            $principal=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM principal WHERE current='1'"));
            $subNumber=mysqli_num_rows(mysqli_query($mysqli,"SELECT DISTINCT subject FROM result_upload WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}' "));
            $classNum=mysqli_num_rows(mysqli_query($mysqli,"SELECT DISTINCT student_id FROM result_upload WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}' "));
          ?>
        <div class="each_student">
          <div class="student_header">
          	<div class="result_header">
             <div class="logo"><img src="../images/WHSLogo.png"></div><!--  
             --><div class="school_name"><p><?php echo $school_name; ?></p></div><!--  
             --><div class="profile_p"><img src="<?php echo './upload/passport-upload/'.$getStudentName['passport']; ?>"></div>   
            </div>
            <table id="students_details">
              <tr>
                <td>Student Name: </td><td colspan="5"><?php echo $getStudentName['name']; ?> </td>
              </tr>
              <tr>
                <td>Student Gender: </td><td><?php echo $getStudentName['gender']; ?></td>
                <td>Student Age: </td><td  colspan="3"><?php echo $getStudentName['age']; ?></td>
              </tr>
              <tr>
                <td>Student ID: </td><td><?php echo $getStudentName['st_id']; ?></td>
                <td>Class: </td><td  colspan="3"><?php echo $getStudentName['class']; ?></td>
              </tr>
              <tr>
                <td>Academic Year: </td><td><?php echo $getStudentName['session']; ?></td>
                <td>Term: </td><td colspan="3" ><?php echo $getStudentName['term']; ?></td>
              </tr>
              <tr>
                <td>Total Score: </td><td><?php echo round($row['total_score'],2);; ?></td>
                <td>No. of Subject: </td><td  colspan="3"><?php echo $subNumber; ?></td>
              </tr>
              <tr>
                <td>Average: </td><td><?php echo round($row['average_score'],2);; ?></td>
                <td>Class Position: </td><td><?php echo showPosition($row['class_position']); ?></td>
                <td>No. in Class: </td><td><?php echo $classNum; ?></td>
              </tr>
            </table>
          </div>
          <table id="subjects">
            <tr>
              <td colspan="10" class="termly_a_r">
                Termly Academic Result
              </td>
            </tr>
            <tr id="two">
              <td class="first">
                Subject
              </td>
              <td>
                ASSESSMENT
              </td>
              <td>
                Exam Score
              </td>
              <td>
                Total Score
              </td>
              <td>
                Highest Score
              </td>
              <td>
                Lowest Score
              </td>
              <td>
                Average
              </td>
              <td>
                Position
              </td>
              <td>
                Grade 
              </td>
              <td class="last">
                Teacher
              </td>
            </tr>
          <?php 
          $getSub=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}' AND student_id='{$row['student_id']}' ");
          while ($sub=mysqli_fetch_assoc($getSub)) {
            $main_subject =strtoupper(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects WHERE subject_code ='{$sub['subject']}'"))['subject']);
            $highestScore=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT MAX(total_score) FROM result_upload WHERE class='{$sub['class']}' AND session='{$sub['session']}' AND school_term='{$sub['school_term']}' AND subject='{$sub['subject']}' "))['MAX(total_score)'];
            $lowestScore=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT MIN(total_score) FROM result_upload WHERE class='{$sub['class']}' AND session='{$sub['session']}' AND school_term='{$sub['school_term']}' AND subject='{$sub['subject']}' "))['MIN(total_score)'];
            $teacher=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT name FROM teachers WHERE teachers_id ='{$sub['teachers_id']}'"))['name'];
            $student_move=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE class='{$sub['class']}' AND session='{$sub['session']}' AND school_term='{$sub['school_term']}' AND subject='{$sub['subject']}' ");
            $sub_av=array();$sub_position=0;
            $count=0;
            $sum=0;
            while ($av_position=mysqli_fetch_assoc($student_move)) {
              $sum=$sum+(float)$av_position['total_score'];
              $count++;
              $sub_av[]=(float)$av_position['total_score'];
            }$average=$sum/$count;
              rsort($sub_av);
              $sub_position=(array_search($sub['total_score'],$sub_av))+1;
          ?>
            <tr>
              <td>
                <?php echo $main_subject; ?>
              </td>
              <td>
                <?php echo $sub['students_c_a']; ?>
              </td>
              <td>
                <?php echo $sub['exam_score']; ?>
              </td>
              <td>
                <?php echo $sub['total_score']; ?>
              </td>
              <td>
                <?php echo $highestScore; ?>
              </td>
              <td>
                <?php echo $lowestScore; ?>
              </td>
              <td>
                <?php echo round($average,1); ?>
              </td>
              <td>
                <?php echo $sub_position; ?>
              </td>
              <td>
                <?php echo strtoupper($sub['grade']); ?>
              </td>
              <td class="text-nowrap">
                <?php if (strlen($teacher)<=25){echo $teacher;}else{echo substr($teacher,0,22)."...";}?>
              </td>
            <?php
            }
            ?>
          </table>
          <div id="score_letter_grade">
            <center>
              <table>
                <tr>
                  <td>Letter Grade</td><td>A1=Excellent</td><td>B2=Very Good</td><td>B3=Good</td><td>C4=Credit</td><td>C5=Credit</td><td>C6=Credit</td><td>D7=Pass</td><td>E8=Pass</td><td>F9=Fail</td>
                </tr>
                <tr>
                  <td>Score</td><td>80-100</td><td>70-79</td><td>65-69</td><td>60-64</td><td>55-59</td><td>50-54</td><td>45-49</td><td>40-44</td><td>0-39</td>
                </tr>
              </table>
            </center>
          </div>
          <div class="comment">
            <table id="r_footer">
              <tr>
                <td>Form Teacher: </td><td><?php echo strtolower($form_teacher); ?></td>
                <td>Form Teacher's Signature: </td><td>&nbsp;</td>
              </tr>
              <tr>
                <td>Form Teacher's Comment: </td><td  colspan="3"><?php echo $row['teacher_comment']; ?></td>
              </tr>
              <tr>
                <td>Principal: </td><td><?php echo strtolower($principal['name']); ?></td>
                <td>Principals's Signature: </td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              </tr>
            </table>
        </div>
        <?php
        }
        ?>
      </div>
          <div class="down_down"><button id="downloadResult"><i class="fa fa-print"></i> Print Result</button></div>
    </center>
  </div>
</div>

<?php
include("inc/footer.inc.php");
?>
<script type="text/javascript">
  (function() {
    $(document).ready(function() {

      $('#downloadResult').on('click',function() {
        window.print();
      });
    });
  })();
</script>
<div id="error_feed"></div>
</body>
</html>