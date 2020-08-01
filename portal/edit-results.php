<?php
include("inc/header.inc.php");
if (isset($_GET['teachers_id'],$_GET['class_id'],$_GET['session_id'],$_GET['term_id'],$_GET['subject_id'])) {
	$teachers_id=$_GET['teachers_id'];
	$class_id=$_GET['class_id'];
	$session_id=$_GET['session_id'];
	$term_id=$_GET['term_id'];
	$subject_id=$_GET['subject_id'];
	if ($teachers_id!=$id) {
		header('Location:home');
	}else{
		$main_subject	=strtolower(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects 
					WHERE subject_code ='{$subject_id}'"))['subject']);
		$count_Num=mysqli_query($mysqli,"SELECT * FROM result_upload WHERE teachers_id='{$teachers_id}' AND class='{$class_id}' AND session='{$session_id}' AND school_term='{$term_id}' AND subject='{$subject_id}' ");
	}	
}
?>	
<title>Edit Result</title>
	<div class="left_divs" style="display: ;">
		<?php include 'inc/left_menu.inc.php'; ?>
	</div><!-- 
	--><div class="contents" style="display: ;">
		<center>
			<div class="edit_header">
				<h4  style="text-transform: ;">Edit the Result for 
					<span style="text-transform: uppercase;"><?php echo ucwords($class_id); ?></span> 
					<?php echo ucfirst($main_subject); ?>
				</h4>
			</div>
			<div class="edit_r_table">
				<span style="color: #E72C33;font-size: 1.2em;font-style: italic;">
					* To edit the result, focus on any field and enter the value carefully.
				</span>
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
							<th>
								Remove
							</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					while ($row=mysqli_fetch_assoc($count_Num)) {
					?>
					<tr class="editable">
						<td contenteditable="true" data-type="edit_teachers_id" data-r_id='<?php echo $row['result_id']; ?>'>
						<?php echo strtoupper($row['teachers_id']); ?>
						</td>
						<td contenteditable="true" data-type="edit_student" data-r_id='<?php echo $row['result_id']; ?>'>
						<?php echo strtoupper($row['student_id']); ?>
						</td>
						<td contenteditable="true" data-type="edit_subject" data-r_id='<?php echo $row['result_id']; ?>'>
						<?php echo strtoupper($main_subject); ?>
						</td>
						<td contenteditable="true" data-type="edit_class" data-r_id='<?php echo $row['result_id']; ?>'>
						<?php echo strtoupper($row['class']); ?>
						</td>
						<td contenteditable="true" data-type="edit_ca" data-r_id='<?php echo $row['result_id']; ?>'>
						<?php echo $row['students_c_a']; ?>
						</td>
						<td contenteditable="true" data-type="edit_exam" data-r_id='<?php echo $row['result_id']; ?>'>
						<?php echo $row['exam_score']; ?>
						</td>
						<td contenteditable="true" data-type="edit_total" data-r_id='<?php echo $row['result_id']; ?>'>
						<?php echo $row['total_score']; ?>
						</td>
						<td contenteditable="true" data-type="edit_grade" data-r_id='<?php echo $row['result_id']; ?>'>
						<?php echo strtoupper($row['grade']); ?>
						</td>
						<td contenteditable="true" data-type="edit_term" data-r_id='<?php echo $row['result_id']; ?>'>
						<?php echo strtoupper($row['school_term']); ?>
						</td>
						<td contenteditable="true" data-type="edit_session" data-r_id='<?php echo $row['result_id']; ?>'>
						<?php echo $row['session']; ?>
						</td>
						<td data-removeId='<?php echo $row['result_id']; ?>' class="removeId">
						<i class="fa fa-trash"></i> Remove
						</td>
					</tr>
					<?php 						
					}
					 ?>
					 </tbody>
				</table>
				<div>
					<button id="addStudent"><i class="fa fa-plus"></i> Add Student</button>
					<button id="insertStudent"><i class="fa fa-check"></i> Insert Student</button>
					<button id="deleteResult" style="display: "><i class="fa fa-trash"></i> Delete Result</button>
					<button id="goBack" style="display: "><i class="fa fa-arrow-left"></i> Go Back</button>
				</div>

			</div>
		</center>
	</div>


</div>

<?php
include("inc/footer.inc.php");
?>

<script type="text/javascript">
	(function() {
		$(document).ready(function() {
			$(document).on('blur','tr.editable td',function() {
				var type=$(this).attr('data-type').trim();
				var r_Id=$(this).attr('data-r_id').trim();
				var dValue=$(this).text().trim().toLowerCase();
				// alert(value)
				$.post('ajax/misc.php',{type:type,r_Id:r_Id,dValue:dValue},function(data) {
					$('#error_feed').fadeIn(100).text(data).delay(2000).fadeOut(50);
				});
			});
			var start=1;
			$(document).on('click','#addStudent',function() {
				var newRow='<tr class="new_file"><td contenteditable class="t_id"> <?php echo strtoupper($teachers_id); ?></td>  <td contenteditable></td>  <td contenteditable><?php echo strtoupper($main_subject); ?></td> <td contenteditable><?php echo strtoupper($class_id); ?></td>   <td contenteditable></td>  <td contenteditable></td>  <td contenteditable></td><td contenteditable></td> <td contenteditable><?php echo strtoupper($term_id); ?></td> <td contenteditable><?php echo strtoupper($session_id); ?></td>  <td class="removeIdP" disabled><i class="fa fa-trash"></i> Remove</td></tr>';
				$('table').append(newRow);
				$('#insertStudent').css({'display':'block'});
				$('#addStudent').css({'display':'none'});
			});
			$(document).on('click','#insertStudent',function() {
				var t_id=$('tr:last-child td:nth-child(1)').text().trim();
				var st_id=$('tr:last-child td:nth-child(2)').text().trim();
				var sub_id=$('tr:last-child td:nth-child(3)').text().trim();
				var cla_id=$('tr:last-child td:nth-child(4)').text().trim();
				var ca_id=$('tr:last-child td:nth-child(5)').text().trim();
				var ex_id=$('tr:last-child td:nth-child(6)').text().trim();
				var tot_id=$('tr:last-child td:nth-child(7)').text().trim();
				var gra_id=$('tr:last-child td:nth-child(8)').text().trim();
				var tem_id=$('tr:last-child td:nth-child(9)').text().trim();
				var ses_id=$('tr:last-child td:nth-child(10)').text().trim();
				$.post('ajax/misc.php',{t_id:t_id,	st_id:st_id,  sub_id:sub_id, 	cla_id:cla_id,
								ca_id:ca_id,	ex_id:ex_id,	tot_id:tot_id,		gra_id:gra_id,
								tem_id:tem_id,	ses_id:ses_id},function(data) {
					if (data=="ok") {
						$('#insertStudent').css({'display':'none'});
						$('#addStudent').css({'display':'block'});
						$('#error_feed').fadeIn(100).text("Student added successfully.").delay(4000).fadeOut(50);
					}else{
						$('#error_feed').fadeIn(100).html(data).delay(4000).fadeOut(50);
					}
				});
			});
			//remove student
			$(document).on('click','.removeId',function() {
				var removeId=$(this).attr('data-removeId');
				if (confirm("Remove this student's Result?")) {
					if (confirm('Sure?')) {
						$.post('ajax/misc.php',{removeId:removeId},function(data) {
							$('#error_feed').fadeIn(100).text(data).delay(2000).fadeOut(50);
						});
					}
				}
			});
			$(document).on('click','#deleteResult',function() {
				if (confirm("Delete all the Result?")) {
					if (confirm('All the uploaded data for <?php echo strtoupper("$class_id, $main_subject, $term_id term, $session_id session"); ?> will be lost permenently?')) {
						$.post('ajax/misc.php',{
							teachers_id_d:"<?php echo $teachers_id; ?>",
							class_id_d:"<?php echo $class_id; ?>",
							term_id_d:"<?php echo $term_id; ?>",
							session_id_d:"<?php echo $session_id; ?>",
							subject_id_d:"<?php echo $subject_id; ?>"
						},function(data) {
							if (data=="ok") {
								$('#error_feed').fadeIn(100).text("Result successfully deleted.").delay(5000).fadeOut(50);
								$('#insertStudent, #addStudent, #deleteResult, table').css({'display':'none'});
								$('#goBack').css({'display':'block'});
							}
						});
					}
				}
			});
			$(document).on('click','#goBack',function() {history.back();});

		});
	})();
</script>
<div id="error_feed"></div>
</body>
</html>