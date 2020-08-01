<?php 
include("../inc/connect.inc.php");

$identity		= strtolower(trim($_POST["identity"]));
$password		= $_POST["password"];;
		
	if (!isset($_POST['submit'])) {
		header('location:../../login');
	}
	if (isset($_SESSION['error'])) {
		unset($_SESSION['error']);
	}
		$_SESSION['error'] = array();

	if (empty($identity)||empty($password)) {
		$_SESSION['error'][]='Enter your identity No. and your password.'; 
	}
	if (!empty($identity)) {
		if (!preg_match('/^[a-zA-Z0-9 \/]+$/', $identity)) {
			$_SESSION['error'][]='Invalid login details.';
		}
	}

	if (count($_SESSION['error'])>0) {
		header('Location:../../login');
	}else{
		$incoming_identity		= mysqli_real_escape_string($mysqli,htmlentities($identity));
		$incoming_password	= mysqli_real_escape_string($mysqli,htmlentities(md5($password)));
		
		$result1	=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM students WHERE st_id= '$incoming_identity' AND password = '$incoming_password' "));
		$result2	=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id= '$incoming_identity' AND password = '$incoming_password' "));
		$result3    =mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM principal WHERE principal_id= '$incoming_identity' AND password = '$incoming_password' "));

		if (!empty($result1)) {
			if ($result1['status']==1) {
				$_SESSION['error'][]='Your account is block. Contact the administrator.';
				header('Location:../../login');
			}else{
				$_SESSION['id'] 			=$result1['st_id'];
				$_SESSION['status'] 		="students";
				$_SESSION['is_logged_in']	=true;
				header('Location:../home');
			}
		}elseif (!empty($result2)) {
			if ($result2['status']==1) {
				$_SESSION['error'][]='Your account is block. Contact the administrator.';
				header('Location:../../login');
			}else{
				$_SESSION['id'] 			=$result2['teachers_id'];
				$_SESSION['status'] 		="teachers";
				$_SESSION['is_logged_in']	=true;
				header('Location:../home');
			}
		}elseif (!empty($result3)) {
			if ($result3['status']==1) {
				$_SESSION['error'][]='Your account is block. Contact the administrator.';
				header('Location:../../login');
			}else{
				$_SESSION['id'] 			=$result3['principal_id'];
				$_SESSION['status'] 		="principal";
				$_SESSION['is_logged_in']	=true;
				header('Location:../home');
			}
		}else{
			$_SESSION['error'][]='Incorret login details';
			header('Location:../../login');
		}
	}

?>