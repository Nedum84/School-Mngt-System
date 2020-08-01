<?php include_once 'inc/header.inc.php'; ?>
		
		<title>School Information</title>
		<div class="contents" style="padding-bottom: 50px;">
			<div id="welcome" class="home_welcome">
				<h4>Edit School Information</h4>
			</div>
			<div class="panel_info white_background">
				<div class="each_val">
					<span>Term :</span>  
					<i class="fa fa-spin fa-refresh"></i> <?php echo $schDetails['school_term']." Term"; ?> 
					&nbsp;<a href="edit-school-info?e=term"><i class="fa fa-pencil"> </i>update</a>
				</div>
				<div class="each_val">
					<span>Session :</span>  
					<i class="fa fa-building"></i> <?php echo $schDetails['school_session']; ?> 
					&nbsp;<a href="edit-school-info?e=session"><i class="fa fa-pencil"> </i>update</a>
				</div>
				<div class="each_val">
					<span>School Name :</span>  
					<i class="fa fa-home"></i> <?php echo $schDetails['school_name']; ?>
					&nbsp;<a href="edit-school-info?e=school"><i class="fa fa-pencil"> </i>update</a>
				</div>
				<div class="each_val">
					<span>School Email :</span>  
					<i class="fa fa-envelope"></i> <?php echo $schDetails['school_email']; ?>
					&nbsp;<a href="edit-school-info?e=school"><i class="fa fa-pencil"> </i>update</a>
				</div>
				<div class="each_val">
					<span>School Mobile :</span>  
					<i class="fa fa-phone"></i> <?php echo $schDetails['school_tel']; ?>
					&nbsp;<a href="edit-school-info?e=school"><i class="fa fa-pencil"> </i>update</a>
				</div>
				<div class="each_val">
					<span>School Address :</span>  
					<i class="fa fa-map-marker"></i> <?php echo $schDetails['school_address']; ?>
					&nbsp;<a href="edit-school-info?e=school"><i class="fa fa-pencil"> </i>update</a>
				</div>
				<div class="each_val">
					<span>School Motto :</span>  
					<i class="fa fa-bullhorn"></i> <?php echo $schDetails['school_motto']; ?>
					&nbsp;<a href="edit-school-info?e=school"><i class="fa fa-pencil"> </i>update</a>
				</div>
				<div class="each_val">
					<span>School Subjects :</span>  
					<i class="fa fa-book"></i> <?php echo $sub_numbers." Subjects"; ?>
					&nbsp;<a href="view-school-subjects?e=school"><i class="fa fa-pencil"> </i>update</a>
				</div>
				<div class="each_val">
					<span>School Anthem :</span>  
					<i class="fa fa-legal"></i> <?php echo $schDetails['school_anthem']; ?> 
					&nbsp;<a href="edit-school-info?e=school"><i class="fa fa-pencil"> </i>update</a>
				</div>

				<div class="edit_school_info">
					<a href="edit-school-info?e=classes"> <i class="fa fa-pencil"> </i> Raise student's class</a>
				</div>
			</div>
		</div>
		
<?php include_once 'inc/footer.inc.php'; ?>
