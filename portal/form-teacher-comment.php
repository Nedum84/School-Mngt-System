<?php
include("inc/header.inc.php");
if (isset($_GET['termDDD'])) {
	$termDDD=$_GET['termDDD'];
	if ($termDDD!='termly'&&$termDDD!='annual') {
		header('Location:home');
	}else{
		if ($termDDD=='termly') {
			$count_Num=mysqli_query($mysqli,"SELECT * FROM view_position WHERE class='{$class}' AND session='{$session}' AND school_term='{$term}' ORDER BY class_position ASC");
			
		}else{
			$count_Num=mysqli_query($mysqli,"SELECT * FROM view_position WHERE class='{$class}' AND session='{$session}' AND school_term='annual' ORDER BY class_position ASC");

		}
	}
}else{header('Location:home');}
if ($status!="teachers") {
	header('Location:home');
}
?>	<title>Add Comments</title>
	<div class="left_divs">
		<?php include 'inc/left_menu.inc.php'; ?>
	</div><!-- 
	--><div class="contents">
		<center>
			<div class="edit_header">
				<h4>View and add Comments to <span><?php echo strtoupper($class); ?></span> Result</h4>
			</div>
			<div class="edit_r_table">
				<table id="datatable-buttons" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>
								Student ID
							</th>
							<th>
								Student Name
							</th>
							<th>
								Class
							</th>
							<th>
								Term
							</th>
							<th>
								Session 
							</th>
							<th>
								Average
							</th>
							<th>
								Total
							</th>
							<th>
								Position
							</th>
							<th>
								Comment
							</th>
						</tr>
						
					</thead>
					<?php 
					while ($row=mysqli_fetch_assoc($count_Num)) {
						$getStudentName=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id='{$row['student_id']}'"));
					?>
					<tr class="view_position_row">
						<td class="f_s_id">
						<?php echo strtoupper($row['student_id']); ?>
						</td>
						<td class="f_name" style="text-align: left;">
						<?php echo strtoupper($getStudentName['name']); ?>
						</td>
						<td class="f_class">
						<?php echo strtoupper($row['class']); ?>
						</td>
						<td class="f_term">
						<?php echo strtoupper($row['school_term']); ?>
						</td>
						<td class="f_session">
						<?php echo strtoupper($row['session']); ?>
						</td>
						<td class="f_average">
						<?php echo round($row['average_score'],2); ?>
						</td>
						<td class="f_total">
						<?php echo round($row['total_score'],2); ?>
						</td>
						<td contenteditable="false" class="f_position">
						<?php echo $row['class_position']; ?>
						</td>
						<td contenteditable="true" data-type="f_comment" data-id="<?php echo $row['id']; ?>" style="text-align: left;">
						<?php echo $row['teacher_comment']; ?>
							
						</td>
					</tr>
					<?php 						
					}
					 ?>
				</table>
				<button id="seeAllResult"><i class="fa fa-eye"></i> View Full Results</button>
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
			$(document).on('blur','tr.view_position_row td',function() {
				var type=$(this).attr('data-type').trim();
				var id=$(this).attr('data-id').trim();
				var dValue=$(this).text().trim();
				$.post('ajax/formteacher-process.php',{type:type,id:id,dValue:dValue},function(data) {
					$('#error_feed').fadeIn(100).text(data).delay(2000).fadeOut(50);
				});
			});
			$(document).on('click','#seeAllResult',function() {
				if (confirm("View all the Students Result?")) {
					window.location.href="view-all-result?term_select=<?php echo $termDDD; ?>";
				}
			});
		});
	})();
</script>
<div id="error_feed"></div>
</body>
</html>