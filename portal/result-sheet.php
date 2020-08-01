<?php include_once 'inc/header.inc.php'; 

	
	if (isset($_GET['f'])) {
		$show_set=$_GET['f'];		
	}else{
		$show_set="all";
	}
	if ($show_set!="all") {
		$count_students=mysqli_query($mysqli,"SELECT * FROM students WHERE class LIKE '%".$show_set."%'");
	}else{
		$count_students=mysqli_query($mysqli,"SELECT * FROM students ORDER BY class ");
	}
?>
		<title>..::<?php echo strtoupper($show_set); ?> EXAM SHEET IN  
						<?php echo "<span>".strtoupper($school_name." ".$school_term." TERM"." ".$school_session." SESSION")."</span>"; ?>
		</title>
		<div class="left_divs">
			<?php include 'inc/left_menu.inc.php'; ?>
		</div><!-- 
		--><div class="contents">
			<center>
				<div class="edit_header">
					<h5 style="font-size: 1.5em;">
						<?php echo $show_set; ?> Result Sheet in  
						<?php echo "<span>".strtoupper($school_name." ".$school_term." TERM"." ".$school_session." SESSION")."</span>"; ?>							
					</h5>
				<form method="get" id="show_set_form">
					<select name="f" id="show_set" style="border-radius:0px;width:98%;margin:8px 0px;">		
						<?php 
						if (isset($_GET['f'])&&$_GET['f']!='all') {
							echo '<option value="'.$_GET['f'].'">'.strtoupper($_GET['f']).' STUDENTS</option>';
						}else{
							echo '<option value="all">SELECT CLASS</option>';
						}
						$get_class=mysqli_query($mysqli,"SELECT DISTINCT class FROM students WHERE graduate_status='0' ORDER BY class ASC ");
						while ($row=mysqli_fetch_assoc($get_class)) {
							echo '<option value="'.$row['class'].'">'.strtoupper($row['class']).' STUDENTS</option>';
						}
						?>
					</select>
				</form>
				
				</div>
				<div class="edit_r_table" id="student_table">
					<table  id="datatable-buttons" class="table table-striped table-bordered">
						<thead>							
							<tr>
								<th>
									S/N
								</th>
								<th>
									Students REG NO.
								</th>
								<th>
									Name
								</th>

<!-- 								<th>
									HAS
								</th>
								<th>
									1<sup>st</sup> CA
								</th>
								<th>
									2<sup>nd</sup> CA
								</th>
								<th>
									3<sup>rd</sup> CA
								</th> -->

<!-- 								<th>
									Student CA
								</th> -->

								<th>
									Student CA
								</th>
								<th>
									Exam Score
								</th>
								<th>
									Class
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
								<?php echo strtoupper($row['st_id']); ?>
							</td>
							<td >
								<?php echo ucwords($row['name']); ?>
							</td>
							<td>

<!-- 							</td>
							<td >

							</td>
							<td >

							</td>
							<td >

							</td>
							<td > -->

							</td>
							<td >

							</td>
							<td>
								<?php echo strtoupper($row['class']); ?>								
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
	</div>
<?php include_once 'inc/footer.inc.php'; ?>
<script type="text/javascript">
	(function() {
		$(document).ready(function() {    

			//submit on change
			$(document).on('change select','#show_set',function() {
				$('#show_set_form').submit();
			});
			//on submit run this
			document.getElementById('show_set_form').addEventListener('submit', function(e) {
				var search=$('#search').val();
				if (search!='') {
					$('#show_set').html('<option value="'+search+'">'+search+' STUDENTS</option>');
				}
		  	},false);

		});
	})();
</script>
