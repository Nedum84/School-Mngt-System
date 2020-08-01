<?php include_once 'inc/header.inc.php'; 

if (isset($_POST['term_submit'])) {
	$school_term_select=sanitize($_POST['school_term_select']);
	$err=array();
	if (empty($school_term_select)) {
		$err[]="Select a term";
	}elseif ($school_term_select==strtolower($school_term)) {
		$msg="School term Updated!";
	}else{
		$update_school_term=mysqli_query($mysqli,"UPDATE school_info SET d_values = '{$school_term_select}' WHERE school_variable='school_term' ");
	    if ($update_school_term) {
	     	$update_others1= mysqli_query($mysqli,"UPDATE students SET term = '{$school_term_select}' ");
	     	$update_others2= mysqli_query($mysqli,"UPDATE teachers SET term = '{$school_term_select}' ");
	     	$update_others3= mysqli_query($mysqli,"UPDATE principal SET term = '{$school_term_select}' ");
	        if ($update_others1&&$update_others2&&$update_others3) {
				$msg="School term Updated!";
				$school_term=$school_term_select;
	        }else{
		    	$err[]="An error occured, try again";
		    }
	    }else{
	    	$err[]="An error occured, try again";
	    }
	}
}
//for session edit
if (isset($_POST['session_submit'])) {
	$school_session_select=sanitize($_POST['school_session_select']);

	$err=array();
	if (empty($school_session_select)) {
		$err[]="Select a session";
	}elseif ($school_session_select==strtolower($school_session)) {
		$msg="School session Updated!";
	}else{
		$update_school_session=mysqli_query($mysqli,"UPDATE school_info SET d_values = '{$school_session_select}' WHERE school_variable='school_session' ");
	    if ($update_school_session) {
	     	$update_others1= mysqli_query($mysqli,"UPDATE students SET session = '{$school_session_select}' ");
	     	$update_others2= mysqli_query($mysqli,"UPDATE teachers SET session = '{$school_session_select}' ");
	     	$update_others3= mysqli_query($mysqli,"UPDATE principal SET session = '{$school_session_select}' ");
	        if ($update_others1&&$update_others2&&$update_others3) {
				$school_session=$school_session_select;
				$msg="School session Updated!";
	        }else{
		    	$err[]="An error occured, try again";
		    }
	    }else{
	    	$err[]="An error occured, try again";
	    }

	}
}
if (isset($_POST['increment'])) {
	$st_num=0;
	$get_st_class=mysqli_query($mysqli,"SELECT * FROM students");
	// $get_st_class=mysqli_query($mysqli,"SELECT DISTINCT class FROM students");
	while ($c=mysqli_fetch_assoc($get_st_class)) {

	    $st_Level=substr($c['class'], 0,3);
	    $current_class=(int)substr($c['class'], 3,1);//resturns 1 to 3
	    $st_aph_class=substr($c['class'], 4,2);
	    if (($st_Level=="jss")&&($current_class==3)) {
			$student_class="sss1";
	    }else{
	    	$student_class=$st_Level.($current_class+1).$st_aph_class;
	    }
	    if (($st_Level=="sss")&&($current_class>=3)) {
	    	$graduate_status=$c['graduate_status']+1;
	    }else{
	    	$graduate_status=0;				    	
	    }
		$update_st= mysqli_query($mysqli,"UPDATE students SET class = '{$student_class}', graduate_status = '{$graduate_status}' WHERE st_id='{$c['st_id']}' ");
		if ($update_st) {
			$st_num++;
		}
	}$msg="All(<b>$st_num</b>) student's class incremented by 1!";
}
if (isset($_POST['decrement'])) {
	$st_num=0;
	$get_st_class=mysqli_query($mysqli,"SELECT * FROM students");
	while ($c=mysqli_fetch_assoc($get_st_class)) {

	    $st_Level=substr($c['class'], 0,3);
	    $current_class=(int)substr($c['class'], 3,1);//resturns 1 to 3
	    $st_aph_class=substr($c['class'], 4,2);
	    if (($st_Level=="sss")&&($current_class==1)) {
			$student_class="jss3";
	    }else{
	    	$student_class=$st_Level.($current_class-1).$st_aph_class;
	    }
	    if (($st_Level=="sss")&&($current_class>=3)) {
	    	$graduate_status=$c['graduate_status']-1;
	    }else{
	    	$graduate_status=0;				    	
	    }
		$update_st= mysqli_query($mysqli,"UPDATE students SET class = '{$student_class}', graduate_status = '{$graduate_status}' WHERE st_id='{$c['st_id']}' ");
		if ($update_st) {
			$st_num++;
		}
	}$msg="All(<b>$st_num</b>) student's class decremented by 1!";
}
if (isset($_POST['submit'])) {
	$err=array();
	$school_name_edit=sanitize($_POST['school_name']);
	$school_tel_edit=sanitize($_POST['school_tel']);
	$school_email_edit=sanitize($_POST['school_email']);
	$school_address_edit=sanitize($_POST['school_address']);
	$school_motto_edit=sanitize($_POST['school_motto']);
	$school_anthem_edit=sanitize($_POST['school_anthem']);

	if (empty($school_name_edit)) {
		$err[]='school name is required'; 
	}elseif (!preg_match('/^[A-Za-z0-9 . \s \t !@#$%^&*(<>?|}{})\.]+$/', $school_name_edit)) {
		$err[]='School name must be characters or numbers only';
	}else{
		$school_name=$school_name_edit;
	}
	if (empty($school_tel_edit)) {
		$err[]='school phone is required'; 
	}elseif (!preg_match('/^[A-Za-z0-9 .]+$/', $school_tel_edit)) {
		$err[]='School phone must be numbers only';
	}else{
		$school_tel=$school_tel_edit;
	}
	if (empty($school_email_edit)) {
		$err[]='Email is required'; 
	}elseif (!filter_var($school_email_edit,FILTER_VALIDATE_EMAIL)) {
		$err[]='Invalid school Email address';
	}else{
		$school_email=$school_email_edit;
	}
	if (empty($school_address_edit)) {
		$err[]='school address is required'; 
	}elseif (!preg_match('/^[A-Za-z0-9 . \s \t !@#$%^&*(<>?|}{})]+$/', $school_address_edit)) {
		$err[]='School address must be characters or numbers only';
	}else{
		$school_address=$school_address_edit;
		$school_motto=$school_motto_edit;
		$school_anthem=$school_anthem_edit;
	}

	if (count($err)==0) {
     	$update_sch_name= mysqli_query($mysqli,"UPDATE school_info SET d_values = '{$school_name_edit}' WHERE school_variable='school_name' ");
     	$update_sch_tel= mysqli_query($mysqli,"UPDATE school_info SET d_values = '{$school_tel_edit}' WHERE school_variable='school_tel' ");
     	$update_sch_email= mysqli_query($mysqli,"UPDATE school_info SET d_values = '{$school_email_edit}' WHERE school_variable='school_email' ");
     	$update_sch_address= mysqli_query($mysqli,"UPDATE school_info SET d_values = '{$school_address_edit}' WHERE school_variable='school_address' ");
     	$update_sch_motto= mysqli_query($mysqli,"UPDATE school_info SET d_values = '{$school_motto_edit}' WHERE school_variable='school_motto' ");
     	$update_sch_anthem= mysqli_query($mysqli,"UPDATE school_info SET d_values = '{$school_anthem_edit}' WHERE school_variable='school_anthem' ");


     	$msg="<b>School info edited!</b>";
		
	}


}
?>

		<title>Edit School Details</title>
		<div class="contents" style="padding-bottom: 50px;">
			<div id="welcome" class="home_welcome">
				<h4>Edit School <?php if (isset($_GET['e'])&&(trim($_GET['e'])=="term")||(trim($_GET['e'])=="session")) {
					echo ucfirst($_GET['e']);}else{ echo "Details";} ?></h4>
			</div>

			<div class="news_panel_wrapper white_background">
				<div class="reg_form" style="border:none;width:100%">

					<?php 
						if (isset($err)) {
							foreach ($err as $error) {
								print("<p class='error'>$error</p>");
							}
						}if (isset($msg)) {
							echo "<p class='success' style='font-weight: bold;''>$msg</p>";
						}
					?>
				<?php if (trim($_GET['e'])=="term") { ?>
					<form method="post">
						<div class="news_panel_each">
							<label for="term">Term</label>
							<select id="term" name="school_term_select">
								<?php termSelect(); ?>
							</select>
						</div>
						<div class="news_panel_each">
							<input type="submit" name="term_submit" value="Update Term">
						</div>
						
					</form>
				<?php }elseif (trim($_GET['e'])=="session") { ?>

					<form method="post">						
						<div class="news_panel_each">
							<label for ="session">Session</label>
							<select id="session" name="school_session_select">
								<?php sessionSelect(); ?>
							</select>
						</div>
						<div class="news_panel_each">
							<input type="submit" name="session_submit" value="Update Session">
						</div>
						
					</form>
				<?php }elseif (trim($_GET['e'])=="classes") { ?>
						<form method="post">
							<p class="error"></p>

						<div class="news_panel_each">
							<label for="name" style="margin-bottom: 12px;padding: 10px;"> Increase or decrease all the student's class to the next class by pressing the buttons below <br> <span class="error">*Update this carefully! It's advisable to increment all the students class yearly!!</span></label>
							<button name="decrement" type="submit"><i class="fa fa-minus"></i> Decrease Class</button>
							<button name="increment" type="submit">Increase Class <i class="fa fa-plus"></i></button>
						</div>
						</form>
				<?php }else{ ?>
					<form method="post" enctype="multipart/form-data">

						<div class="news_panel_each">
							<label for="name">School name</label>
							<input type="text" name="school_name" id="name" placeholder="School name" value="<?php if(isset($school_name)){echo($school_name);} ?>">
						</div>

						<div class="news_panel_each">
							<label for="phone">School mobile number</label>
							<input type="tel" name="school_tel" id="phone" placeholder="School mobile number" value="<?php if(isset($school_tel)){echo($school_tel);} ?>">
						</div>

						<div class="news_panel_each">
							<label for="phone">School email</label>
							<input type="email" name="school_email" id="phone" placeholder="School email" value="<?php if(isset($school_email)){echo($school_email);} ?>">
						</div>
						<div class="news_panel_each">
							<label for="phone">School address</label>
							<input type="text" name="school_address" id="phone" placeholder="School address" value="<?php if(isset($school_address)){echo($school_address);} ?>">
						</div>
						<div class="news_panel_each">
							<label for="phone">School motto</label>
							<input type="text" name="school_motto" id="phone" placeholder="School motto" value="<?php if(isset($school_motto)){echo($school_motto);} ?>">
						</div>
						<div class="news_panel_each">
							<label for="phone">School anthem</label>
							<textarea name="school_anthem" ><?php if(isset($school_anthem)){echo($school_anthem);} ?></textarea>
						</div>


						<div class="news_panel_each">
							<input type="submit" name="submit" value="Update">
						</div>
					</form>
				<?php } ?>
				</div>

			</div>
		</div>
		
<?php include_once 'inc/footer.inc.php'; ?>
