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
		<title>:: 
			<?php echo strtoupper("<< $show_set >> "); ?>RESULT SHEET IN <?php echo strtoupper($school_name." ".$school_term." TERM"." ".$school_session." SESSION"); ?>
		</title>
		<div class="contents">
			<div id="welcome" class="home_welcome">
				<h4>DOWNLOAD RESULT SHEET <span><?php echo strtoupper($school_term." TERM"." ".$school_session." SESSION"); ?></span></h4>
			</div>
			
			<center class="white_background">
				<div class="edit_header">
					<form method="get" id="show_set_form">
						<label style="text-align:left;display:block">Select the class *</label>
						<select name="f" id="show_set" style="border-radius:0px;width:100%;margin:8px 0px;">		
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
				
				<div class="student_table">
					<table id="datatable-buttons" class="table table-bordered">
						<thead>							
							<tr>
								<th>
									Class
								</th>
								<th>
									Student ID
								</th>
								<th>
									Name
								</th>
								<th>
									Term
								</th>
								<th>
									Session 
								</th>
								<th>
									CA score
								</th>
								<th>
									Ecam Score 
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
									<?php echo strtoupper($row['class']); ?>
								</td>
								<td >
									<?php echo strtoupper($row['st_id']); ?>
								</td>
								<td>
									<?php echo ucwords($row['name']); ?>							
								</td>
								<td>
									<?php echo ucwords($school_term); ?>							
								</td>
								<td>
									<?php echo ucwords($school_session); ?>							
								</td>
								<td>

								</td>
								<td >

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
