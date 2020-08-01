<?php
include("inc/header.inc.php");

?>	<title>Home</title>
	<div class="left_divs">
		<?php include 'inc/left_menu.inc.php'; ?>
	</div><!-- 
	--><div class="contents" style="background-color: rgba(253,253,253,1);">
		<div id="welcome" class="home_welcome">
				<h4><?php if ($status=="students"||$status=="teachers") {
					echo "Welcome ".$name;
				}elseif ($status=="principal") {
					echo "Welcome the Principal ".$name;
				} ?></h4>
		</div>
		<div class="contain">			
			<!-- <marquee>gsdgdsgdsgdsgds dsfgdgfdgfdsfg fdsgds</marquee> -->
			<div class="content">			
				<div class="show_content">
					<!-- <div class="clear">gfg</div> -->
					<div class="indivi_content">
						<div class="profile_container">							
							<div class="profile">
								<?php 
								if (!empty($name)) {
									echo '<p class="pleft"><span>Name:</span> '.$name.'</p>';}
								if (!empty($class)&&($status=="students")) {
									echo '<p class="pleft"><span>Class:</span> '.strtoupper($class).'</p>';}
								if (!empty($class)&&($status=="teachers")) {
									echo '<p class="pleft"><span>Form teacher:</span> '.$class.'</p>';}
								if (!empty($term)) {
									echo '<p class="pleft"><span>Term:</span> '.$term.'</p>';}
								if (!empty($session)) {
									echo '<p class="pleft"><span>Session:</span> '.$session.'</p>';}
								if (!empty($gender)) {
									echo '<p class="pleft"><span>Gender:</span> '.$gender.'</p>';}
								if (!empty($age)) {
									echo '<p class="pleft"><span>Age:</span> '.$age.' years</p>';}
								if (!empty($email)) {
									echo '<p class="pleft"><span>Email:</span> <a href="mailto:'.$email.'"><i class="fa fa-envelope"></i> '.$email.'</a></p>';}
								if (!empty($mobile_no)) {
									echo '<p class="pleft"><span>Mobile No.:</span> <a href="tel:'.$mobile_no.'"><i class="fa fa-phone"></i> '.$mobile_no.'</a></p>';}
								
									echo '<p class="pleft"><span>School Name:</span> '.$schDetails['school_name'].'</p>';
								 ?>
								<div class="clear"></div>
								<marquee class="marquee_home" style="text-transform:capitalize">Enjoy Our Limitless Service By Subscribing With <a href="http://www.pacuss.com" style="color:rgb(40, 96, 156)">PACUSS GLOBAL VENTURES</a></marquee>
							</div>
						</div>
					</div>
				</div>
				<div class="sh_profile">
					<div class="profile_image">
						<img src="<?php echo("upload/passport-upload/".$passport); ?>">
					</div>
					<div class="sh_text">
						<h3><?php if(isset($id)){echo $id;} ?></h3>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<?php
include("inc/footer.inc.php");
?>
</body>
</html>