<?php include_once 'inc/header.inc.php'; ?>
<?php 

if (isset($_POST['submit'])) {
	if (!empty(trim($_POST['name']))) {
		$register_name=sanitize($_POST['name']);
	}else{
		$err[]="Please provide the user's full name.";
	}
	if (empty(trim($_POST['phone']))) {
		$err[]="Please provide  the user's telephone number.";
	}elseif (checkExist("*","principal",'mobile_no',trim($_POST['phone']))) {
		$err[]="A user with the mobile number <b>".$_POST['phone']."</b> exists.";
	}else{
		$phone=sanitize($_POST['phone']);
	}
	if (!empty(trim($_POST['gender']))) {
		$register_gender=sanitize($_POST['gender']);
	}else{
		$err[]="Please indicate the gender.";
	}
	if (!empty(trim($_POST['u_role']))) {
		$u_role=sanitize($_POST['u_role']);
		$explode=explode('-', $u_role);
		$user_level_code=$explode[0];
		$u_role=end($explode);
	}else{
		$err[]="Please select user role.";
	}
	if (!empty(trim($_POST['entry_Year']))) {
		$entry_Year=sanitize($_POST['entry_Year']);
	}else{
		$err[]="Please select the user year of entry.";
	}
	if (!empty(trim($_POST['password']))) {
		$password=sanitize($_POST['password']);
	}else{
		$err[]="Please provide  the user's password.";
	}
	if (!empty(trim($_POST['password2']))) {
		$password2=sanitize($_POST['password2']);
	}else{
		$err[]="Please confirm  the user's password.";
	}
	if (isset($password,$password2)&&($password!=$password2)) {
		$err[]="Password mis-matched! Please try again.";
	}

	if (count($err)==0) {
		$reg_number=getPrincipalId($entry_Year,$user_level_code);
		$password=md5($password);
		$sql = "INSERT INTO principal (principal_id, name,mobile_no,gender,password,user_level) VALUES ('$reg_number','$register_name','$phone','$register_gender','$password','$u_role') ";
		$query=mysqli_query($mysqli,$sql);
		if ($query) {
			$msg = "User registered succesfully";
		}else{
			$msg2 = "Sorry, user couldn't be registered. Please try again.";
		}
	}
}

?>		
		<title>User Register</title>
		<div class="contents">
			<div id="welcome" class="home_welcome">
				<h4>Register New Staff</h4>
			</div>
			<div class="news_panel_wrapper white_background">
				<div class="reg_form">
					<form method="post" enctype="multipart/form-data">
						
						<?php 
							if (isset($err)) {
								foreach ($err as $error) {
									print("<p class='error'>$error</p>");
								}
							}
							if (isset($msg)) {
								echo "<p class='success'>$msg</p>";
							}

						?>
						<div class="news_panel_each">
							<label for="name">Full name</label>
							<input type="text" name="name" id="name" placeholder="Enter your full name" value="<?php if(isset($register_name)){echo($register_name);} ?>" required>
						</div>

						<div class="news_panel_each">
							<label for="phone">Phone number</label>
							<input type="tel" name="phone" id="phone" placeholder="Mobile number" value="<?php if(isset($phone)){echo($phone);} ?>" required>
						</div>

						<div class="news_panel_each">
							<label for="u_role">User Role</label>
							<select name="u_role" required>
								<?php 
									if (isset($u_role)) {
										echo '<option value="'.$u_role.'">'.ucfirst($user_level).'</option>';
									}
								 ?>
								<option value="stf-staff">Staff</option>
								<option value="pr-principal">Principal</option>
								<option value="vp-vice principal">Vice Principal</option>
							</select>
						</div>

						<div class="news_panel_each">
							<label for="entry_Year">Year of Entry to the school</label>
							<select name="entry_Year">
								<?php 
									if (isset($entry_Year)) {
										echo '<option value="'.$entry_Year.'">'.ucfirst($entry_Year).'</option>';
									}
									for ($i=2008; $i < 2018; $i++) { 
										if(($i==2013)&&(!isset($entry_Year))) {
											echo "<option value='$i' selected>$i</option>";
										}else{
											echo "<option value='$i'>$i</option>";
										}
									}
								 ?>
							</select>
						</div>

						<div class="news_panel_each gender_div">						
							<input type="radio" name="gender" id="male" value="male" <?php if (isset($register_gender)&&($register_gender=='male')) {echo "checked";	} ?>>
							<label for="male" style="display: inline;">Male</label>
							<input type="radio" name="gender" id="female" value="female" <?php if (isset($register_gender)&&($register_gender=='female')) {echo "checked";	} ?>>
							<label for="female"  style="display: inline;">Female</label>
						</div>

						<div class="news_panel_each">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" placeholder="Password" value="<?php if(isset($password)){echo($password);} ?>" required>
						</div>

						<div class="news_panel_each">
							<label for="password2">Confirm Password</label>
							<input type="password" name="password2" id="password2" placeholder="Password" value="<?php if(isset($password2)){echo($password2);} ?>" required>
						</div>

						<div class="news_panel_each">
							<input type="submit" name="submit" value="Register">
						</div>
					</form>
				</div><div class="users_prev">
					<div class="users_holder">
						<div id="welcome" class="home_welcome">
							<h4>Registered Staff</h4>
						</div>
							<?php 

							$users=mysqli_query($mysqli,"SELECT * FROM principal WHERE principal_id!='pacuss/1234' ");
							while ($p=mysqli_fetch_assoc($users)) {
								?>
						<div class="each_user">
								<h4>
								<b><?php echo strtoupper($p['principal_id']).'</b> : '.ucwords($p['name']); ?> 
								| <span><?php echo ($p['user_level']); ?></span> 
								<a href=""><i class="fa fa-pencil"></i></a></h4>
						</div>
							<?php }

							?>
					</div>
				</div>
			</div>
		</div>
		
	<script type="text/javascript">
function upload(f) {
	var fiePath = $('#p_picture').val();
	var reader = new FileReader();
	reader.onload = function (e) {
		$('#profileImg').attr('src',e.target.result);
	};
	reader.readAsDataURL(f.files[0]);
}
</script>
<?php include_once 'inc/footer.inc.php'; ?>

<?php if (isset($msg)) {?>
	<script type="text/javascript">
		swal("Good job!", "<?php echo($msg); ?>", "success");
	</script>
<?php }elseif ($msg2) {?>
	<script type="text/javascript">
		swal("Oops!", "<?php echo($msg2); ?>", "error");
	</script>
<?php } ?>