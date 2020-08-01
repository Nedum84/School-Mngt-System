<?php
require_once 'inc/connect.inc.php';

if (isset($_SESSION['user_id'])) {
	header("location: dashboard");
	exit();
}
?> 
<?php  
if (isset($_POST['submit'])) {
	$identity_err = '';
	$pass_err = '';

	if (isset($_POST['identity'])&&(!empty(trim($_POST['identity'])))){
		$identity = strip_tags(trim($_POST['identity']));
		if (!preg_match('/^[a-zA-Z0-9 \/]+$/', $identity)) {
			$identity_err='Enter a valid Identity No.';
		}
	}else{
		$identity_err="Enter your Identity No.";
	}

	if (isset($_POST['password'])&&(!empty(trim($_POST['password'])))){
		$password_= strip_tags(trim($_POST['password']));
	}else{
		$pass_err="Enter your password";
	}
	if (isset($identity_err,$pass_err)&&empty($identity_err)&&empty($pass_err)) {
		$identity=strtolower($identity);
		$password = md5(strtolower($password_));
		$sql = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM principal WHERE principal_id = '$identity' AND password = '$password'"));
		if (!empty($sql)) {
			$_SESSION['user_id']=$sql['principal_id'];
			header("location: dashboard");
		}else{
			$pass_identity_error="Incorrect login details";
		}
	}
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $schDetails['school_name']; ?></title>
	<link rel="stylesheet" type="text/css" href="css/styles-index.css">
</head>
<body>
<div class="container">
	<div class="header">
		
	</div>
	<div class="box">
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<h1>Welcome to <?php echo $schDetails['school_name']; ?></h1>
			<p>Please provide correct login detals to Login:</p>
			<input type="text" name="identity" required placeholder="Enter your Identity No." value="<?php if(!empty($identity)){echo $identity;} ?>">
			<?php if (isset($identity_err)) {
				echo "<p class='error'>".$identity_err."</p>";			} ?>
			<input type="password" name="password" required placeholder="Enter your password" value="<?php if(!empty($password_)){echo $password_;} ?>">
			<?php if (isset($pass_err)) {
				echo "<p class='error'>".$pass_err."</p>"; } ?>
			<input type="submit" name="submit" value="Login">
			<?php if (isset($pass_identity_error)) {
				echo "<p class='error'>".$pass_identity_error."</p>";
			} ?>
		</form>
	</div>
</div>
</body>
</html>