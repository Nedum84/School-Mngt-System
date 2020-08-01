<?php
include("inc/header.inc.php");
if (isset($_GET['term_select'])) {
  $term_select=$_GET['term_select'];
  if (empty($term_select)) {
    header('Location:home');
  }else{
    if ($term_select!='annual') {
      $getStudent=mysqli_query($mysqli,"SELECT * FROM view_position WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}'  ORDER BY class_position ASC");
    }else{
      $getStudent=mysqli_query($mysqli,"SELECT * FROM view_position WHERE class='{$class}' AND session='{$session}' AND school_term='annual'  ORDER BY class_position ASC");
    }
  }

}else{header('Location:home');}
?>
  <title>Results for <?php echo strtoupper($class); ?> Class</title>
  <div class="left_divs">
    <?php include 'inc/left_menu.inc.php'; ?>
  </div><!-- 
  --><div class="contents">
    <center class="view-all-result-wrappers">
      <div class="edit_view_result_header">
        <h4><?php echo strtoupper($class." Result ".$term ." term ".$session." session"); ?> </h4>
      </div>
      <div class="students_container">
          <?php 
          while ($row=mysqli_fetch_assoc($getStudent)) {
            $getStudentName=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id='{$row['student_id']}'"));
            $subNumber=mysqli_num_rows(mysqli_query($mysqli,"SELECT DISTINCT subject FROM result_upload WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}' "));
            $classNum=mysqli_num_rows(mysqli_query($mysqli,"SELECT DISTINCT student_id FROM result_upload WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}' "));
          ?>
        <div class="each_student">
          <div class="student_header">
            <p><span class="start_h"><span>Name: </span><?php echo $getStudentName['name']; ?></span> 
            <span class="end_h"><span>Student Id: </span><?php echo $row['student_id']; ?></span></p>
            <p><span class="start_h"><span>Term: </span><?php echo $term; ?></span> 
            <span class="end_h"><span>Session: </span><?php echo $session; ?></span></p>
            <p><span class="start_h"><span>No. In Class: </span><?php echo $classNum; ?></span> 
            <span class="end_h"><span>No of Subjects: </span><?php echo $subNumber; ?></span></p>
            <p><span class="start_h"><span>Total Score: </span><?php echo round($row['total_score'],2); ?></span> 
            <span class="end_h"><span>Average: </span><?php echo round($row['average_score'],2); ?></span></p>
            <p><span class="start_h"><span>Class: </span><?php echo $class; ?></span> 
            <span class="end_h"><span>Position: </span><?php echo showPosition($row['class_position']); ?></span></p>
          </div>
          <table>
            <tr>
              <td class="first-col-header">
                Subject
              </td>
              <td>
                C.A
              </td>
              <td>
                Exam Score
              </td>
              <td>
                Total Score
              </td>
              <td>
                Grade 
              </td>
              <td>
                Teacher 
              </td>
            </tr>
          <?php 
          $getSub=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}' AND student_id='{$row['student_id']}' ");
          while ($sub=mysqli_fetch_assoc($getSub)) {
          $main_subject =strtoupper(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects 
          WHERE subject_code ='{$sub['subject']}'"))['subject']);
          $teacher=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT name FROM teachers WHERE teachers_id ='{$sub['teachers_id']}'"))['name'];
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
                <?php echo strtoupper($sub['grade']); ?>
              </td>
              <td class="text-nowrap" style="text-transform: capitalize;">
                <?php if (strlen($teacher)<=25){echo $teacher;}else{echo substr($teacher,0,22)."...";}?>
              </td>
            <?php
            }
            ?>
          </table>
        </div>
        <?php
        }
        ?>
      </div>
          <div class="down_down"><button id="downloadResult"><i class="fa fa-print"></i> Print All Result</button></div>
    </center>
  </div>
</div>

<?php
include("inc/footer.inc.php");
?>
<script type="text/javascript">
  (function() {
    $(document).ready(function() {
    //print the page
    $('#downloadResult').on('click',function() {
      window.print();
    });

    });
  })();
</script>
<div id="error_feed"></div>
</body>
</html>