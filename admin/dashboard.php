<?php include_once 'inc/header.inc.php';

?>
		<title>Dashboard | <?php echo $school_name; ?></title>

		<div class="contents" style="padding-bottom: 50px;">
			<div class="home_welcome">
				<h4>DASHBOARD</h4><span>your limitless service is our concern</span>
				<div class="bread_crumb">					
					<a href=""><i class="fa fa-dashboard"></i> Portal </a>
					<i class="fa fa-angle-double-right"></i>
					Dashboard
				</div>
			</div>
			<div  class="white_background">
				<div class="box_container">
					<div class="box">
						<div class="box-icon">
							<i class="fa fa-users"></i>
						</div><div class="icon_details">
							<h4>No. of Students</h4>
							<b><?php echo $st_numbers; ?></b>
							<div class="progress_div">
			                  <div class="progress-bar" style="width: 70%"></div>
			                </div>
			                <span class="progress-description">
		                      Total No. of Students
		                    </span>
						</div>
					</div>
					<div class="box">
						<div class="box-icon">
							<i class="fa fa-graduation-cap"></i>
						</div><div class="icon_details">
							<h4>Teachers</h4>
							<b><?php echo $t_numbers; ?></b>
							<div class="progress_div">
			                  <div class="progress-bar" style="width: 70%"></div>
			                </div>
			                <span class="progress-description">
		                      Total No. of Teachers
		                    </span>
						</div>
					</div>
					<div class="box">
						<div class="box-icon">
							<i class="fa fa-file-pdf-o"></i>
						</div><div class="icon_details">
							<h4>No Of Subjects</h4>
							<b><?php echo $sub_numbers; ?></b>
							<div class="progress_div">
			                  <div class="progress-bar" style="width: 70%"></div>
			                </div>
			                <span class="progress-description">
		                      No. of subjects registered
		                    </span>
						</div>
					</div>
					<div class="box">
						<div class="box-icon">
							<i class="fa fa-bell-o"></i>
						</div><div class="icon_details">
							<h4>Information</h4>
							<b><?php echo $info_numbers; ?></b>
							<div class="progress_div">
			                  <div class="progress-bar" style="width: 70%"></div>
			                </div>
			                <span class="progress-description">
		                      Total Info Uploaded
		                    </span>
						</div>
					</div>
				</div>

				<center>
					<div class="panel_welcome" style="width: 100%">
						<h2>Welcome to <?php echo ucwords($schDetails['school_name']); ?></h2>
						<h3>Admin Panel</h3>
						<div class="user_img_desc">
							<div class="user_img" style="background-image: ;">
								<img src="<?php if(isset($passport)){echo("../portal/upload/passport-upload/".$passport);} ?>">
							</div><div class="user_desc">
								<h6><?php echo ucwords($name); ?></h6>
								<div class="slide_prog">
									<span>Auth: <?php echo ucwords($usersz['user_level']); ?></span><i class="fa fa-share"></i>
								</div>
							</div>
						</div>
						<div class="wlcm_msg">We are glad to have you back, How have you been </div><hr>
						<div class="code_desc">Citadel of Learning...</div>
					</div>
				</center>
				<hr style="background-color:#EEE;">
				<div class="panel_info">
					<div class="each_val">
						<span>Term :</span>  
						<i class="fa fa-spin fa-refresh"></i> <?php echo $schDetails['school_term']." Term"; ?>
					</div>
					<div class="each_val">
						<span>Session :</span>  
						<i class="fa fa-building"></i> <?php echo $schDetails['school_session']; ?>
					</div>
					<div class="each_val">
						<span>School Name :</span>  
						<i class="fa fa-home"></i> <?php echo $schDetails['school_name']; ?>
					</div>
					<div class="each_val">
						<span>School Email :</span>  
						<i class="fa fa-envelope"></i> <?php echo $schDetails['school_email']; ?>
					</div>
					<div class="each_val">
						<span>School Mobile :</span>  
						<i class="fa fa-phone"></i> <?php echo $schDetails['school_tel']; ?>
					</div>
					<div class="each_val">
						<span>School Address :</span>  
						<i class="fa fa-map-marker"></i> <?php echo $schDetails['school_address']; ?>
					</div>
					<div class="each_val">
						<span>School Motto :</span>  
						<i class="fa fa-bullhorn"></i> <?php echo $schDetails['school_motto']; ?>
					</div>
					<div class="each_val">
						<span>School Subjects :</span>  
						<i class="fa fa-book"></i> <?php echo $sub_numbers." Subjects"; ?>
					</div>
					<div class="each_val">
						<span>School Anthem :</span>  
						<i class="fa fa-legal"></i> <?php echo $schDetails['school_anthem']; ?>
					</div>


					<div class="edit_school_info">
						<a href="view-school-info"> <i class="fa fa-pencil"> </i> Edit School Info</a>
					</div>
				</div>
				
			</div>

		</div>

<?php include_once 'inc/footer.inc.php'; ?>
