<?php include_once 'inc/header.inc.php'; 

// $students=mysqli_query($mysqli,"SELECT * FROM students");
// while ($c=mysqli_fetch_assoc($students)) {

//     $st_id_explode=explode('/',$c['st_id']);
//     $new_val=$schDetails['school_code'].'/'.end($st_id_explode);
//     $name=strtolower($c['name']);

// 	$update_st= mysqli_query($mysqli,"UPDATE students SET st_id = '{$new_val}',name='{$name}' WHERE st_id='{$c['st_id']}' ");
// }
	
	$count_students=mysqli_query($mysqli,"SELECT * FROM students ORDER BY class ");
?>
		<title>..::STUDENTS</title>
		<div class="contents">
			<div id="welcome" class="home_welcome">
				<h4> Students in  <?php echo "<span>".ucfirst($schDetails['school_name'])."</span>"; ?></h4>
			</div>
			<center class="white_background">
				<div class="student_table">
					<table id="datatable-buttons" class="table table-bordered">
						<thead>							
							<tr>
								<th>
									Student ID
								</th>
								<th>
									Name
								</th>
								<th>
									Class
								</th>
								<th>
									Email
								</th>
								<th>
									Status 
								</th>
								<th>
									Password
								</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						while ($row=mysqli_fetch_assoc($count_students)) {
							if ($row['status']=='1') {$st_status="UNBLOCK";}else{$st_status="BLOCK";}
						?>
						<tr class="editable">
							<td >
								<?php echo strtoupper($row['st_id']); ?>
							</td>
							<td >
								<?php echo ucwords($row['name']); ?>
							</td>
							<td contenteditable="true" data-type="edit_st_class" data-name="<?php echo ucwords($row['name']); ?>" data-r_id='<?php echo $row['st_id']; ?>' data-ini='<?php echo $row['class']; ?>'>
								<?php echo strtoupper($row['class']); ?>
							</td>
							<td >
								<?php echo $row['email']; ?>
							</td>
							<td class="block_un_block" data-r_id='<?php echo $row['st_id']; ?>' data-name='<?php echo strtoupper($row['name']); ?>'>
								<?php echo $st_status; ?>
							</td>
							<td class="reset_password" data-r_id='<?php echo $row['st_id']; ?>' data-name='<?php echo strtoupper($row['name']); ?>'>
								<?php echo "RESET"; ?>
							</td>
						</tr>
						<?php 						
						}
						 ?>
						</tbody>
					</table>
					<div class="st_button_div">
						<button id="registerStudent"><i class="fa fa-plus"></i> Register Student</button>
						<button id="uploadStudent"><i class="fa fa-upload"></i> Upload Student</button>
						<a href="print-students" style="display: inline-block;float: right;color: #0073AA"> <i class="fa fa-print"></i> Print Students</a>
					</div>

				</div>
			</center>

		</div>
		
<?php include_once 'inc/footer.inc.php'; ?>
<script type="text/javascript">
	(function() {
		$(document).ready(function() {
			$(document).on('click','.block_un_block',function() {
				var st_name=$(this).attr('data-name').trim();
				var st_r_Id=$(this).attr('data-r_id').trim();
				var st_value=$(this).text().trim();
				// alert(value)
				if (confirm(st_value+' '+st_name)) {
						$.post('ajax/students-teachers-process.php',{st_r_Id:st_r_Id},function(data) {
						$('#error_feed').fadeIn(100).text(data).delay(2000).fadeOut(50);
					});
				}
			});
			//Reset student password
			$(document).on('click','.reset_password',function() {
				var st_name=$(this).attr('data-name').trim();
				var reset_password_id=$(this).attr('data-r_id').trim();
				if (confirm("Reset "+ st_name+"\'s Password?")) {
					$.post('ajax/students-teachers-process.php',{reset_password_id:reset_password_id},function(data) {
						$('#error_feed').fadeIn(100).text(data).delay(2000).fadeOut(50);
					});
				}
			});
			$(document).on('change select','#show_set',function() {
				$('#show_set_form').submit();
			});

		$('.st_file_input').on('change',function() {
		  	var ext_array=$('.st_file_input').val().split('.');
		  	ext=ext_array[(ext_array.length)-1];
		  	if (ext=='csv') {		  		
		  		$('.feedback').html('<span class="success">Student file selected.</span>');
		  	}else{
		  		$('.feedback').text('Invalid file formate. Upload .csv student file.');
		  	}
		});
		//submiting/upload  students .csv
		var form_student = _("st_upload_form");
		form_student.addEventListener('submit', function(e) {
			$('#st_upload_button').attr({'disabled':'false'}).addClass('addOpacity')
			.html('Please Wait <i class="fa fa-spinner fa-spin"></i>');

		    var ajax = new XMLHttpRequest();
		    ajax.open("POST", "ajax/students-teachers-process.php", true);
		    ajax.onload = function(event) {
		      if (ajax.status == 200 && ajax.readyState == 4) {
		      	$('#st_upload_button').removeAttr('disabled').removeClass('addOpacity')
		      	.html('<i class="fa fa-upload"></i><span> Register</span>');

		      		$('.feedback').html(ajax.responseText);
		      		$('#st_upload_form')[0].reset();		        
		      } else {
		      		$('.feedback').text("Error " + ajax.status + " occurred when trying to upload your file.");
		      	}
		    };
		    ajax.send(new FormData(form_student));
		    e.preventDefault();return false;
		  },false);

		//register a student
		var form_register_st = _("st_register_form");
		form_register_st.addEventListener('submit', function(e) {
			getStId($('#register_st_class').val());
		    var ajax = new XMLHttpRequest();
		    ajax.open("POST", "ajax/students-teachers-process.php", true);
		    ajax.onload = function(event) {
		      if (ajax.status == 200 && ajax.readyState == 4) {
		      	if (ajax.responseText.indexOf('successfully')!=-1) {
		      		$('.feedback').html(ajax.responseText);
		      		$('#st_register_form')[0].reset();		      			
		      	}else{
		      		$('.feedback').html(ajax.responseText);
		      	}		        
		      } else {
		      		$('.feedback').text("Error " + ajax.status + " occurred when trying to upload your file.");
		      	}
		    };
		    ajax.send(new FormData(form_register_st));
		    e.preventDefault();return false;
		  },false);

		//upload students
		$(document).on('click','#uploadStudent',function() {
			$('.modal_wrapper').css({'display':'block'});
			$('#st_upload_form').show(500);
		});
		$(document).on('keyup change focus click','#register_st_class',function() {
			var st_Class=$(this).val();
			getStId(st_Class);
		});
		function getStId(st_Class) {
			$.post('ajax/students-teachers-process.php',{st_Class:st_Class},function(data) {
				$('#register_st_id').val(data);
			});
		}
		// register A Student 
		$(document).on('click','#registerStudent',function() {
			$('.modal_wrapper').css({'display':'block'});
			$('#st_register_form').show(500);
		});
		     
		//edit students class
		$(document).on('blur','tr.editable td',function() {
	        var type=$(this).attr('data-type').trim();
	        var r_Id=$(this).attr('data-r_id').trim();
	        var name=$(this).attr('data-name').trim();
	        var ini=$(this).attr('data-ini').trim();
	        var dValue=$(this).text().trim().toLowerCase();
	        if ((dValue!=ini)) {
	        	edit_students(type,r_Id,dValue);
	        }
	          
	        function edit_students(type,id,value) {
	          $.post('ajax/students-teachers-process.php',{student_edit_type:type,student_edit_id:id,student_edit_value:value},function(data) {
	            if (data!="") {
	              $('#error_feed').fadeIn(100).html(data).delay(5000).fadeOut(50);
	            }
	          });
	        }
	      });

		function _(x){
			return document.getElementById(x);
		}


		});
	})();
</script>
