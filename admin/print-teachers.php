<?php include_once 'inc/header.inc.php'; 

	$count_students=mysqli_query($mysqli,"SELECT * FROM teachers ORDER BY teachers_id ");
?>
		<title>..::<?php echo strtoupper($show_set)." TEACHERS"; ?></title>
		<div class="contents">
			<div id="welcome" class="home_welcome">
				<h4> Teachers in  <?php echo "<span>".ucfirst($schDetails['school_name'])."</span>"; ?></h4>
			</div>
			<center class="white_background">
				<div class="student_table " id="student_table">
					<table id="datatable-buttons" class="table table-bordered">
						<thead>							
							<tr>
								<th>
									S/N
								</th>
								<th>
									Teachers REG NO.
								</th>
								<th>
									Name
								</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$x=1;
						while ($row=mysqli_fetch_assoc($count_students)) {
							if ($row['status']=='1') {$st_status="UNBLOCK";}else{$st_status="BLOCK";}
							
						?>
						<tr class="editable">
							<td >
								<?php echo $x; ?>
							</td>
							<td >
								<?php echo strtoupper($row['teachers_id']); ?>
							</td>
							<td >
								<?php echo ucwords($row['name']); ?>
							</td>
						</tr>
						<?php 						
						$x++;}
						 ?>
						</tbody>
					</table>

				</div>
			</center>

		</div>
		
<?php include_once 'inc/footer.inc.php'; ?>
<script type="text/javascript">
	(function() {
		$(document).ready(function() {      

			$(document).on('click','#print_class',function() {
		        window.print();
			});
		});
	})();
</script>
