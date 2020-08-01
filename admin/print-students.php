<?php include_once 'inc/header.inc.php'; 

	
	if (isset($_GET['f'])) {
		if (isset($_GET['u'])&&(!empty($_GET['u']))) {
			$show_set=$_GET['u'];
		}else{
			$show_set=$_GET['f'];
		}		
	}else{
		$show_set="all";
	}
	if ($show_set!="all") {
		$count_students=mysqli_query($mysqli,"SELECT * FROM students WHERE class LIKE '%".$show_set."%'");
	}else{
		$count_students=mysqli_query($mysqli,"SELECT * FROM students ORDER BY class ");
	}
?>
		<title>..::<?php echo strtoupper($show_set)." STUDENTS"; ?></title>
		<div class="contents">
			<div id="welcome" class="home_welcome">
				<h4><?php echo $show_set; ?> Students in  <?php echo "<span>".ucfirst($schDetails['school_name'])."</span>"; ?></h4>
			</div>
			<center class="white_background">
				<div class="edit_header">
				<form method="get" id="show_set_form">
					<select name="f" id="show_set">		
						<?php 
						if (isset($_GET['f'])&&$_GET['f']!='all') {
							echo '<option value="'.$_GET['f'].'">'.strtoupper($_GET['f']).' STUDENTS</option>';
						}else{
							echo '<option value="all">FILTER</option>';
						}
						 ?>
						<option value="all">ALL STUDENTS</option>
						<option value="jss1">JSS1 STUDENTS</option>
						<option value="jss2">JSS2 STUDENTS</option>
						<option value="jss3">JSS3 STUDENTS</option>
						<option value="sss1">SSS1 STUDENTS</option>
						<option value="sss2">SSS2 STUDENTS</option>
						<option value="sss3">SSS3 STUDENTS</option>
					</select>
					<input type="text" name="u" placeholder="Or enter the class and hit enter" id="search">
				</form>
				<button id="print_class"><i class="fa fa-print"></i> PRINT</button>
				</div>
				<div class="student_table" id="student_table">
					<table id="datatable-buttons" class="table table-striped table-bordered">
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
			$(document).on('click','#print_class',function() {
				// $('.nav_div,.header_div,.footer,#show_set_form').hide();
		          // var restorPage=document.body.innerHTML;
		          // var printContent=document.getElementsByTagName('head').innerHTML;
		          // printContent += document.getElementById('student_table').innerHTML;
		          // document.body.innerHTML=printContent;
		          window.print();
		          // document.body.innerHTML=restorPage;
			});
		});
	})();
</script>
