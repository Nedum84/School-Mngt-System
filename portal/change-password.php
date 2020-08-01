<?php
include("inc/header.inc.php");

?>	<title>Edit Your Profile</title>
	<div class="left_divs">
		<?php include 'inc/left_menu.inc.php'; ?>
	</div><!-- 
	--><div class="contents">
		<center>
	<div id="welcome" class="home_welcome">
		<h4>Change your password
		<span><?php if (isset($_SESSION['update'])) {echo $_SESSION['update'];}unset($_SESSION['update']); ?></span></h4>
	</div>
	<div class="edit_user_wrapper">
		<div class="edit_user">
			<div class="profile_img_show">
				<label><img src="<?php if(!empty($passport)){echo "upload/passport-upload/".$passport;}else{ echo "upload/passport-upload/"."both.png";} ?>"></label><span><?php echo $id; ?></span>
			</div>
			<div class="input_with_icon">
				<label for="password">Old password</label>
				<input type="password" name="" placeholder="******" id="password">
				<span class="error" id="password_error"></span>
			</div>		
			<div class="input_with_icon">
				<label for="n_password">New password</label>
				<input type="password" name="" placeholder="******" id="n_password">
				<span class="error" id="n_passowrd_error"></span>
			</div>		
			<div class="input_with_icon">
				<label for="c_n_password">Retype new password</label>
				<input type="password" name="" placeholder="******" id="c_n_password">
				<span class="error" id="c_n_password_error"></span>
			</div>
			<div class="input_with_icon">
				<label class="remove_hide">&nbsp;</label>
				<button id="passBtn">Update password <i class=""></i></button>
				<p><a href="profile"><i class="fa fa-key"></i> Edit your profile</a></p>
			</div>
		</div>
	</div>
		</center>
	</div>
</div>

<?php
include("inc/footer.inc.php");
?>
<script type="text/javascript">
(function() {
	$(document).ready(function() {

		  var passBtn=_('passBtn')
		  passBtn.addEventListener('click', function(e) {
		  	var password=$('#password').val();
		  	var n_password=$('#n_password').val();
		  	var c_n_password=$('#c_n_password').val();
		  	$.post('ajax/st-process.php',
		  		{password:password,n_password:n_password,c_n_password:c_n_password},
		  		function(data) {
		  			if (data=="ok") {
		  				$('#error_feed').fadeIn(150).text(data).delay(10000).fadeOut(50);
		  				window.location.reload(true);
		  			}else{
		  				$('#error_feed').fadeIn(150).text(data).delay(10000).fadeOut(50);
		  			}
		  		});
		  });

		function _(x){
			return document.getElementById(x);
		}
	});
})();
</script>
<div id="error_feed"></div>
</body>
</html>