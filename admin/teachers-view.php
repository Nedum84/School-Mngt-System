<?php include_once 'inc/header.inc.php'; 

	
  $count_teachers=mysqli_query($mysqli,"SELECT * FROM teachers ORDER BY teachers_id ");
?>
<title>Teachers</title>
		<div class="contents">
			<div id="welcome" class="home_welcome">
				<h4>Teachers in  <?php echo "<span>".ucfirst($schDetails['school_name'])."</span>"; ?></h4>
			</div>
			<center class="white_background">
				<div class="student_table">
					<table id="datatable-buttons" class="table table-bordered teachers">
						<thead>
				          <tr>
				            <th>
				              Teachers ID 
				              	<span class="fa fa-question"> 
				              		<span>The teachers unique ID</span> 
				              	</span>
				            </th>
				            <th>
				              Name
				            </th>
				            <th>
				              Classes 
					              <span class="fa fa-question"> 
					              	<span >Enter the Class(es) thought by each teacher below
					              		<a href="#">Learn more?</a><i class="fa fa-close"></i>
					              	</span> 
					              </span>
				            </th>
				            <th>
				              Subjects
					              <span class="fa fa-question"> 
					              	<span >Enter the Subject(s) thought by each teacher below 
					              		<a href="#">Learn more?</a><i class="fa fa-close"></i>
					              	</span> 
					              </span>
				            </th>
				            <th>
				              Form Class
					              <span class="fa fa-question"> 
					              	<span >Indicate the class headed by the teacher if any 
					              		<a href="#">Learn more?</a><i class="fa fa-close"></i>
					              	</span> 
					              </span>
				            </th>
				            <th>
				             Class SUB No.
					              <span class="fa fa-question"> 
					              	<span >For form teachers, indicate the total number of subjects offered by his/her class 
					              		<a href="#">Learn more?</a><i class="fa fa-close"></i>
					              	</span> 
					              </span>
				            </th>
				            <th>
				              Status 
				            </th>
				            <th>
				              Password
				            </th>
				          </tr>
						</thead>
						<?php 
						while ($row=mysqli_fetch_assoc($count_teachers)) {
							if ($row['status']=='1') {$t_status="UNBLOCK";}else{$t_status="BLOCK";}
						?>
						<tr class="editable" style="font-size: 1em;padding:2px 4px" id="<?php echo str_replace("/", "-", $row['teachers_id']); ?>">
				            <td >
				              <?php echo strtoupper($row['teachers_id']); ?>
				            </td>
				            <td >
				              <?php echo ucwords($row['name']); ?>
				            </td>
				            <td data-type="edit_teaching_class" data-r_id='<?php echo $row['teachers_id']; ?>'>
				              <?php echo ucwords(str_replace(',', '<br> ', $row['teaching_class'])); ?>
				            </td>
				            <td data-type="edit_teaching_subject" data-r_id='<?php echo $row['teachers_id']; ?>'>
				              <?php 
				              	if (!empty($row['teaching_subject'])) {
					              	$eachSub_array=explode(',', $row['teaching_subject']);
	    							$eachSub="";
								    foreach ($eachSub_array as $key) {
								      $get_subNames=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM subjects 
								                    WHERE subject_code='$key' "));
								      $eachSub .=ucwords($get_subNames['subject'])."<br>";
								    }
								    echo "$eachSub";
								}else{
									$eachSub="";
								}
							   ?>
				            </td>
				            <td data-type="edit_formT_class" data-r_id='<?php echo $row['teachers_id']; ?>'>
				              <?php echo strtoupper($row['class']); ?>
				            </td>
				            <td  contenteditable="true" data-type="edit_no_of_s" data-r_id='<?php echo $row['teachers_id']; ?>'>
				              <?php echo $row['no_of_subject']; ?>
				            </td>
				            <td class="block_un_block" data-r_id='<?php echo $row['teachers_id']; ?>' data-name='<?php echo ucwords($row['name']); ?>'>
				              <?php echo $t_status; ?>
				            </td>
				            <td class="reset_password" data-r_id='<?php echo $row['teachers_id']; ?>' data-name='<?php echo ucwords($row['name']); ?>'>
				              <?php echo "RESET"; ?>
				            </td>

						</tr>
						<?php 						
						}
						 ?>
					</table>
			        <div class="st_button_div">
				        <button id="registerStudent"><i class="fa fa-plus"></i> Register Teacher</button>
				        <button id="uploadStudent"><i class="fa fa-upload"></i> Upload Teacher</button>
						<a href="print-teachers" style="display: inline-block;float: right;color: #0073AA"> <i class="fa fa-print"></i> Print teachers</a>
			        </div>

				</div>
			</center>

		</div>
		
<?php include_once 'inc/footer.inc.php'; ?>
<script type="text/javascript">
	(function() {
		$(document).ready(function() {
			//Teachers subjects Modal show
			$(document).on('click','tr.editable td[data-type=edit_teaching_subject]',function() {
				var edit_sub_t_id = $(this).attr('data-r_id').trim();
				$.post('ajax/students-teachers-process.php',{edit_sub_t_id:edit_sub_t_id},function(data) {
					$('.modal_wrapper').css({'display':'block'});
					$('.modal_container').html(data);
		        });
			});
			// Teachers subjects register
			$(document).on('submit','#adding_teachers_sub',function(e) {
				e.preventDefault();
				var edit_sub_teacher_id=$('#adding_teachers_sub input[type=hidden]').val();
				var row_ID=edit_sub_teacher_id.replace(/\//gi,"-");

				var selSubjects=[];
		    	$('#adding_teachers_sub input[type=checkbox]').each(function  () {
		    		if ($(this).is(":checked")) {
		    			selSubjects.push($(this).attr('id'));		    			
		    		};
		    	});

		    	selSubjects=selSubjects.toString()
		    	$.post('ajax/students-teachers-process.php',
	    				{selSubjects:selSubjects
	    				,edit_sub_teacher_id:edit_sub_teacher_id}
	    				,function(data) {
		            if (data !="error") {
		              	$('tr#'+row_ID+' td[data-type=edit_teaching_subject]').html(data.toString());
		              	$('.modal_wrapper').css({'display':'none'});
						$('.modal_container').html('');
		            }else{
		            	alert("An error occurred, try again");
		            }
		        });
			});
			//Teachers Class Modal show
			$(document).on('click','tr.editable td[data-type=edit_teaching_class]',function() {
				var edit_class_t_id = $(this).attr('data-r_id').trim();
				$.post('ajax/students-teachers-process.php',{edit_class_t_id:edit_class_t_id},function(data) {
					$('.modal_wrapper').css({'display':'block'});
					$('.modal_container').html(data);
		        });
			});

			// Teachers class register
			$(document).on('submit','#adding_teachers_class',function(e) {
				e.preventDefault();
				var edit_class_teacher_id=$('#adding_teachers_class input[type=hidden]').val();
				var row_ID=edit_class_teacher_id.replace(/\//gi,"-");

				var sel_Classes=[];
		    	$('#adding_teachers_class input[type=checkbox]').each(function  () {
		    		if ($(this).is(":checked")) {
		    			sel_Classes.push($(this).attr('id'));		    			
		    		};
		    	});

		    	sel_Classes=sel_Classes.toString()
		    	$.post('ajax/students-teachers-process.php',
	    				{sel_Classes:sel_Classes
	    				,edit_class_teacher_id:edit_class_teacher_id}
	    				,function(data) {
		            if (data !="error") {
		              	$('tr#'+row_ID+' td[data-type=edit_teaching_class]').html(data.toString());
		              	$('.modal_wrapper').css({'display':'none'});
						$('.modal_container').html('');
		            }else{
		            	alert("An error occurred, try again");
		            }
		        });
			});
			//Teachers Form Class Modal show
			$(document).on('click','tr.editable td[data-type=edit_formT_class]',function() {
				var formT_class_t_id = $(this).attr('data-r_id').trim();
				$.post('ajax/students-teachers-process.php',{formT_class_t_id:formT_class_t_id},function(data) {
					$('.modal_wrapper').css({'display':'block'});
					$('.modal_container').html(data);
		        });
			});
			// Form teaxher class register
			$(document).on('submit','#adding_form_teachers',function(e) {
				e.preventDefault();
				var form_class_teacher_id=$('#adding_form_teachers input[type=hidden]').val();
				var row_ID=form_class_teacher_id.replace(/\//gi,"-");

				var sel_formT_Classes=[];
		    	$('#adding_form_teachers input[type=radio]').each(function  () {
		    		if ($(this).is(":checked")) {
		    			sel_formT_Classes.push($(this).attr('id'));		    			
		    		};
		    	});

		    	sel_formT_Classes=sel_formT_Classes.toString()
		    	sel_formT_Classes=(sel_formT_Classes!="none")?sel_formT_Classes:"";

		    	$.post('ajax/students-teachers-process.php',
	    				{sel_formT_Classes:sel_formT_Classes
	    				,form_class_teacher_id:form_class_teacher_id}
	    				,function(data) {
		            if (data =="ok") {
		              	$('tr#'+row_ID+' td[data-type=edit_formT_class]').html(sel_formT_Classes.toUpperCase());
		              	$('.modal_wrapper').css({'display':'none'});
						$('.modal_container').html('');
		            }else{
		            	$('#adding_form_teachers')[0].reset();
		            	alert(data);
		            }
		        });
			});

			// add teachers class and sub no.
	      $(document).on('blur','tr.editable td[data-type=edit_no_of_s]',function() {
	        var type=$(this).attr('data-type').trim();
	        var r_Id=$(this).attr('data-r_id').trim();
	        var dValue=$(this).text().trim().toLowerCase();

	          $.post('ajax/students-teachers-process.php',{teacher_edit_type:type,teacher_edit_id:r_Id,teacher_edit_value:dValue},function(data) {
	            if (data!="") {
	              $('#error_feed').addClass('bg-success').fadeIn(100).html(data).delay(5000).fadeOut(50);
	            }
	          });
	      });

	      //unblock teachers
	      $(document).on('click','.block_un_block',function() {
	        var t_name=$(this).attr('data-name').trim();
	        var t_r_Id=$(this).attr('data-r_id').trim();
	        var t_value=$(this).text().trim();

	        if (confirm(t_value+' '+t_name)) {
	            $.post('ajax/students-teachers-process.php',{t_r_Id:t_r_Id},function(data) {
		            $('#error_feed').fadeIn(100).text(data).delay(2000).fadeOut(50);
		        });
	        }
	      });
	      //Reset teachers password
	      $(document).on('click','.reset_password',function() {
	        var t_name=$(this).attr('data-name').trim();
	        var reset_password_id_t=$(this).attr('data-r_id').trim();
	        if (confirm("Reset "+ t_name+"\'s Password?")) {
	          $.post('ajax/students-teachers-process.php',{reset_password_id_t:reset_password_id_t},function(data) {
	            $('#error_feed').fadeIn(100).text(data).delay(2000).fadeOut(50);
	          });
	        }
	      });
			$(document).on('change select','#show_set',function() {
				$('#show_set_form').submit();
			});

			$('.t_file_input').on('change',function() {
			  	var ext_array=$('.t_file_input').val().split('.');
			  	ext=ext_array[(ext_array.length)-1];
			  	if (ext=='csv') {		  		
			  		$('.feedback').html('<span class="success">Teachers file selected.</span>')
			  	}else{
			  		$('.feedback').text('Invalid file formate. Upload .csv student file.');
			  	}
			});
			//submiting/upload  TEACHERS .csv
		    var form_teachers = _("t_upload_form");
		    form_teachers.addEventListener('submit', function(e) {
				$('#t_upload_button').attr({'disabled':'false'}).addClass('addOpacity').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');

		        var ajax = new XMLHttpRequest();
		        ajax.open("POST", "ajax/students-teachers-process.php", true);
		        ajax.onload = function(event) {
		          if (ajax.status == 200 && ajax.readyState == 4) {
				      	$('#t_upload_button').removeAttr('disabled').removeClass('addOpacity').html('<i class="fa fa-upload"></i><span> Register</span>');

				      	$('.feedback').html(ajax.responseText);
			      		$('#t_upload_form')[0].reset();
			      		if (ajax.responseText.indexOf('registered')!=-1) {
				      		setTimeout(window.location.reload(true),4000);		      			
				      	}    
		          } else {
		              $('.feedback').text("Error " + ajax.status + " occurred when trying to upload your file.");
		            }
		        };
		        ajax.send(new FormData(form_teachers));
		        e.preventDefault();return false;
		      },false);	
			//register a teacher
		    var form_register_t = _("t_register_form");
		    form_register_t.addEventListener('submit', function(e) {
		    	getTId($('#register_t_year').val());
		        var ajax = new XMLHttpRequest();
		        ajax.open("POST", "ajax/students-teachers-process.php", true);
		        ajax.onload = function(event) {
		          if (ajax.status == 200 && ajax.readyState == 4) {
			      	if (ajax.responseText.indexOf('successfully')!=-1) {
			      		$('.feedback').html(ajax.responseText);
			      		$('#t_register_form')[0].reset();		      			
			      	}else{
			      		$('.feedback').html(ajax.responseText);
			      	}	        
		          } else {
		              $('.feedback').text("Error " + ajax.status + " occurred when trying to upload your file.");
		            }
		        };
		        ajax.send(new FormData(form_register_t));
		        e.preventDefault();return false;
		    },false);

			//upload teachers
			$(document).on('click','#uploadStudent',function() {
				$('.modal_wrapper').css({'display':'block'});
				$('#t_upload_form').show(500);
			});
        	//$(document).on('click','th span.fa i.fa-close',function() {$('tr th span.fa span').hide();});//avoid asc toggling

			$(document).on('keyup change focus','#register_t_year',function() {
				var t_Year=$(this).val();
				getTId(t_Year);
			});
			function getTId(t_Year) {
				$.post('ajax/students-teachers-process.php',{t_Year:t_Year},function(data) {
					$('#register_t_id').val(data);
				});
			}
			// register A teacher 
			$(document).on('click','#registerStudent',function() {
				$('.modal_wrapper').css({'display':'block'});
				$('#t_register_form').show(500);
			});

			function _(x){
				return document.getElementById(x);
			}


		});
	})();
</script>
