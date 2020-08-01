<?php
include("inc/header.inc.php");
if (isset($_GET['teachers_id'],$_GET['class_id'],$_GET['session_id'],$_GET['term_id'],$_GET['subject_id'])) {
	$teachers_id=$_GET['teachers_id'];
	$class_id=$_GET['class_id'];
	$session_id=$_GET['session_id'];
	$term_id=$_GET['term_id'];
	$subject_id=$_GET['subject_id'];
	if ($class_id!=$class) {
		header('Location:home');
	}else{
		$main_subject	=strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects WHERE subject_code ='{$subject_id}'"))['subject']);
		$count_Num=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE class='{$class_id}' AND session='{$session_id}' AND school_term='{$term_id}' AND subject='{$subject_id}' ");
	}	
}

?>	<title><?php echo strtoupper("Uploaded Result for  $class_id Class $term Term $session Session"); ?></title>
	<div class="left_divs">
		<?php include 'inc/left_menu.inc.php'; ?>
	</div><!-- 
	--><div class="contents">
		<center class="view-each-uploaded-r-wrapper">
			<div class="edit_header">
				<h4  style="text-transform: capitalize;">Uploaded Result for 
					<span style="text-transform: uppercase;"><?php echo $class_id; ?></span> 
					<?php echo $main_subject; ?>
				</h4>
			</div><?php function uploaded(){
					global $mysqli;
					global $main_subject;
					global $count_Num;
		?>
			<div class="edit_r_table">
				<table id="datatable-buttons" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>
								Teacher ID
							</th>
							<th>
								Student ID
							</th>
							<th>
								Subject
							</th>
							<th>
								Class
							</th>
							<th>
								C. A. 
							</th>
							<th>
								Exam
							</th>
							<th>
								Total
							</th>
							<th>
								Grade
							</th>
							<th>
								Term
							</th>
							<th>
								Session
							</th>
						</tr>
						
					</thead>
					<?php 
					while ($row=mysqli_fetch_array($count_Num)) {
					?>
					<tr class="editable">
						<td>
						<?php echo strtoupper($row['teachers_id']); ?>
						</td>
						<td >
						<?php echo strtoupper($row['student_id']); ?>
						</td>
						<td >
						<?php echo strtoupper($main_subject); ?>
						</td>
						<td >
						<?php echo strtoupper($row['class']); ?>
						</td>
						<td>
						<?php echo $row['students_c_a']; ?>
						</td>
						<td >
						<?php echo $row['exam_score']; ?>
						</td>
						<td >
						<?php echo $row['total_score']; ?>
						</td>
						<td >
						<?php echo strtoupper($row['grade']); ?>
						</td>
						<td >
						<?php echo strtoupper($row['school_term']); ?>
						</td>
						<td >
						<?php echo $row['session']; ?>
						</td>
					</tr>
					<?php 						
					}
					 ?>
				</table>
			</div><?php }  uploaded();?>
		</center>
	</div>
</div>
<?php
include("inc/footer.inc.php");
?>
<script type="text/javascript">
  (function() {
    $(document).ready(function() {

	  $('.downloadResult').on('click',function() {
	    window.print();
	  });
    });
  })();
</script>
</body>
</html>