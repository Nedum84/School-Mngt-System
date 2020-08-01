<?php include_once 'inc/header.inc.php'; 

?>
<title>Profile</title>
		<div class="contents">
			<div id="welcome" class="home_welcome">
				<h4>Profile Details</h4>
			</div>
			<center>
				<div class="profile_wrapper white_background">
					<h3><?php echo ucwords($school_name) ?></h3>
					<p>(<?php echo $schDetails['school_motto']; ?>)</p>
					<h4><?php echo ucwords($schDetails['school_address']) ?></h4>
					<span class="u_p_details">User's Profile Details</span>
					<hr>
					<div class="profile_cols">
						Name: <?php echo ucwords($name); ?>
					</div>
					<div class="profile_cols">
						Identity: <?php echo strtoupper($usersz['principal_id']); ?>
					</div>
					<div class="profile_cols">
						Email: <?php echo strtolower($email); ?>
					</div>
					<div class="profile_cols">
						Mobile No.: <?php echo ucwords($mobile_no); ?>
					</div>
					<div class="profile_cols">
						Gender: <?php echo ucwords($gender); ?>
					</div>
					<div class="profile_cols">
						Term: <?php echo ucwords($usersz['term']); ?>
					</div>
					<div class="profile_cols">
						Session: <?php echo ucwords($usersz['session']); ?>
					</div>
					<div class="profile_cols">
						Date of Birth: <?php echo ucwords(date('d M',$usersz['birth_date'])); ?>
					</div>
					<div class="profile_cols">
						Address: <?php echo ucwords($usersz['address']); ?>
					</div>
					<div class="profile_cols">
						User Level: <?php echo ucwords($usersz['user_level']); ?>
					</div>
					<br>
					<br>
					<br>
					<hr>
					<div class="panel_welcome" style="padding:0px">
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
					</div>
				</div>
			</center>

		</div>
		
<?php include_once 'inc/footer.inc.php'; ?>
