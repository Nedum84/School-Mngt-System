<?php include_once 'inc/header.inc.php'; 

if (isset($_POST['sub_submit'])) {
	$school_subject_select=sanitize($_POST['school_subject_select']);
	
}
?>
		<title>Subjects</title>
		<div class="contents" style="padding-bottom: 50px;">
			<div id="welcome" class="home_welcome">
				<h4>Registered Subjects</h4>
			</div>

			<div class="register_user white_background">
				<div class="panel_info">
					<?php 
						$get_subjects=(mysqli_query($mysqli,"SELECT * FROM subjects "));
						while ($s=mysqli_fetch_assoc($get_subjects)) {
					?>
					<div class="each_val">
						<span style="display: ;"><?php echo $s['subject_code']; ?>. 
							<?php echo ucwords($s['subject']); ?>:</span>
						&nbsp;
						<a href="view-school-subjects?<?php echo(md5($s['subject'])) ?>" 
							class="edit_each_subject" data-subject="<?php echo(ucwords($s['subject'])); ?>" data-sub_id="<?php echo($s['subject_code']) ?>">
							<i class="fa fa-pencil"> </i>Edit <?php echo ucwords($s['subject']); ?>
						</a>
					</div>
					<?php } ?>


					<div class="user_input">
						<button class="btn btn-info" id="add_subject">Add Subject</button>
					</div>
				</div>

			</div>
		</div>
		
<?php include_once 'inc/footer.inc.php'; ?>

<script type="text/javascript">
	$(document).ready(function() {

		//add subject modal view
		$(document).on('click','#add_subject',function() {
			$('.modal_wrapper').css({'display':'block'});
			$('#add_sub_form').show(500);
			
		});
		//edit subject modal show
		$(document).on('click','.edit_each_subject',function(e) {
			e.preventDefault();
			$('.modal_wrapper').css({'display':'block'});
			$('#edit_sub_form').show(500);
			var data_sub=$(this).attr('data-subject');
			var data_sub_id=$(this).attr('data-sub_id');
			$('input[name=sub_edit_input]').val(data_sub);
			$('input[name=sub_edit_input_id]').val(data_sub_id);
		});
		//edit sub form
		var edit_sub_form = document.getElementById("edit_sub_form");
		edit_sub_form.addEventListener('submit', function(e) {

		    var ajax = new XMLHttpRequest();
		    ajax.open("POST", "ajax/school-info.php", true);
		    ajax.onload = function(event) {
		      if (ajax.status == 200 && ajax.readyState == 4) {
			      	$('.feedback').html(ajax.responseText);
			      	FeedSubjects();	        
		      	}else {
		      		$('.feedback').text("Error " + ajax.status + " occurred when trying to contact the server.");
		      	}
		    };
		    ajax.send(new FormData(edit_sub_form));
		    e.preventDefault();return false;
		  },false);

		//edit sub form
		var add_sub_form = document.getElementById("add_sub_form");
		add_sub_form.addEventListener('submit', function(e) {

		    var ajax = new XMLHttpRequest();
		    ajax.open("POST", "ajax/school-info.php", true);
		    ajax.onload = function(event) {
		      if (ajax.status == 200 && ajax.readyState == 4) {
			      	$('.feedback').html(ajax.responseText);
			      	FeedSubjects();        
		      	}else {
		      		$('.feedback').text("Error " + ajax.status + " occurred when trying to contact the server.");
		      	}
		    };
		    ajax.send(new FormData(add_sub_form));
		    e.preventDefault();return false;
		  },false);
		FeedSubjects();
		function FeedSubjects() {
			$.post('ajax/school-info.php',{feed_back_subjects:"feed_back_subjects"},function(data) {
				$('.school_info').html(data);
			});
		}

	});
</script>
