<?php
include("inc/header.inc.php");

?>	<title>Edit Your Profile</title>
	<div class="left_divs">
		<?php include 'inc/left_menu.inc.php'; ?>
	</div><!-- 
	--><div class="contents">
		<center>
	<div id="welcome" class="home_welcome">
		<h4>Edit your profile
		<span style="text-transform: capitalize;"><?php if (isset($_SESSION['update'])) {echo $_SESSION['update'];}unset($_SESSION['update']); ?></span></h4>
	</div>
	<div class="edit_user_wrapper">
		<div class="edit_user">
			<div class="profile_img_show">
				<label><img src="<?php if(!empty($passport)){echo "upload/passport-upload/".$passport;}else{ echo "upload/passport-upload/"."both.png";} ?>"></label><span><?php echo $id; ?></span>
			</div>
			<form enctype="multipart/form-data" method="post" id="edit_profile">
				<div class="input_with_icon">
					<label for="name">Full name</label>
					<input type="text" placeholder="Full name" id="name" name="name" value="<?php if(isset($name)){echo strtoupper($name);} ?>" disabled>
				</div>
				<?php if ($status=="students") {?>
				<div class="input_with_icon">
					<label for="class">Your class</label>
					<input type="text" id="class" name="class" placeholder="E.g JSS1B" value="<?php if(isset($class)){echo strtoupper($class);} ?>" >
				</div>
				<?php }?>
				<div class="input_with_icon">
					<label for="email">Email address</label>
					<input type="email" placeholder="Email address" id="email" name="email"  value="<?php if(isset($email)){echo strtoupper($email);} ?>">
				</div>
				<div class="input_with_icon">
					<label for="gender">Gender</label>
					<select id="gender" name="gender">
						<?php if(!empty($gender)){ echo "<option>".ucwords($gender)."</option>";
							if($gender=='male'){
							 	 echo "<option>Female</option>";
							}else{
							 	echo "<option>Male</option>";
							}
						}else{ ?>
						<option>Male</option>
						<option>Female</option>
						<?php } ?>
					</select>
				</div>
				<div class="input_with_icon">
					<label for="age">Age</label>
					<input type="number" placeholder="Your blood group" id="age" name="age" value="<?php if(isset($age)){echo strtoupper($age);} ?>">
				</div>
				<div class="input_with_icon">
					<label for="mobile_no">Mobile number</label>
					<input type="tel" placeholder="Eg. 080899988765" id="mobile_no" name="mobile_no" value="<?php if(isset($mobile_no)){echo strtoupper($mobile_no);} ?>">
				</div>
				<?php if ($status=="students") {?>
				<div class="input_with_icon">
					<label for="guardian_name">Your Guardian Name</label>
					<input type="text" id="guardian_name" name="guardian_name" placeholder="Guardian name" value="<?php if(isset($guardian_name)){echo strtoupper($guardian_name);} ?>" >
				</div>
				<div class="input_with_icon">
					<label for="guardian_mobile_no">Your Guardian Mobile No.</label>
					<input type="tel" id="guardian_mobile_no" name="guardian_mobile_no" placeholder="Eg. 080899988765" value="<?php if(isset($guardian_mobile_no)){echo strtoupper($guardian_mobile_no);} ?>" >
				</div>
				<?php }?>
				<div class="input_with_icon">
					<label for="upload_res_input">Change your passport</label>
					<label for="upload_res_input" id="browse_label"><i class="fa fa-image"></i> Browse passport</label><input type="file" id="upload_res_input" name="passport" accept="image/*" style="display: none;">
					<label class="remove_hide">&nbsp;</label>
					<span class="" id="passport_upload_s" style="font-size: 1em;"></span>
				</div>
				<div class="input_with_icon">
					<label class="remove_hide">&nbsp;</label>
					<button id="updateBtn" type="submit">Update profile <i class=""></i></button>
					<p><a href="change-password"><i class="fa fa-key"></i> Change your password</a></p>
				</div>
			</form>
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
		  var feed = _("error_feed");
		  var form = _("edit_profile");
		  form.addEventListener('submit', function(e) {
		    var ajax = new XMLHttpRequest();
		    ajax.open("POST", "ajax/st-process.php", true);
		    ajax.onload = function(event) {
		      if (ajax.status == 200 && ajax.readyState == 4) {
		      	if (ajax.responseText=="ok") {
		      		$('#error_feed').fadeIn(150).text(ajax.responseText).delay(10000).fadeOut(50);
		      		window.location.reload(true);
		      	}else{
		      		$('#error_feed').fadeIn(150).text(ajax.responseText).delay(10000).fadeOut(50);
		      	}		        
		      } else {$('#error_feed').fadeIn(150).text("Error " + ajax.status + " occurred when trying to edit your pofile, try again.").delay(10000).fadeOut(50);}
		    };
		    var data=new FormData(form);
		    data.append('name',"<?php echo $name; ?>")
		    ajax.send(data);
		    e.preventDefault();return false;
		  },false);

		var upload_res_input=_('upload_res_input');
		upload_res_input.onchange=function() {
		  	var ext_array=upload_res_input.value.split('.');
		  	ext=ext_array[(ext_array.length)-1].toLowerCase();
		  	if ((ext=='jpeg')||(ext=='png')||(ext=='jpg')) {
		  		_('passport_upload_s').innerHTML="<p style='color:green;display:inline;font-weight:bold;'>Passport selected</p>";
		  	}else{
		  		_('passport_upload_s').innerHTML="<p style='color:red;display:inline;font-weight:bold;'>Invalid file formate. select jpg or png image</p>";
		  	}
		  }
		function _(x){
			return document.getElementById(x);
		}
	});
})();
</script>
<div id="error_feed"></div>
</body>
</html>