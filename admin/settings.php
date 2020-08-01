 <?php
include("inc/header.inc.php");

if (isset($_GET['type'])) {
  $type=trim($_GET['type']);
}
$u=$user_id;
$get_user=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM principal WHERE principal_id = '$u' "));

if (isset($_POST['submit'])) {
  $name=sanitize($_POST['name']);
  $email=sanitize($_POST['email']);
  $mobile_no=sanitize($_POST['mobile_no']);
  $age=sanitize($_POST['age']);
  $gender=sanitize($_POST['gender']);

  if (isset($name)&&empty($name)) {
    $err[]="Please provide your full name.";
  }
  if (isset($mobile_no)&&!empty($mobile_no)&&!preg_match('/^[\d +]+$/', $mobile_no)) {
    $err[]="Please provide a valid telephone number.";
  }elseif (checkExist("*","principal",'mobile_no',$mobile_no)&&($mobile_no!=$get_user['mobile_no'])) {
    $err[]="A user with the mobile number <b>".$mobile_no."</b> exists.";
  }
  if (isset($email)&&!empty($email)&&!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    $err[]="Please provide a valid email address.";
  }elseif (checkExist("*","principal",'email',$email)&&($email!=$get_user['email'])) {
    $err[]="A user with the email address <b>".$email."</b> exists.";
  }

  if (count($err)==0) {

    $age=intval($age);
    $sql = "UPDATE principal SET name='$name', email='$email', mobile_no='$mobile_no', gender='$gender', age='$age' WHERE principal_id  ='$u' ";
    $query=mysqli_query($mysqli,$sql);
    if ($query) {
      $msg = "Profile updated succesfully";
      $get_user=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM principal WHERE principal_id = '$u' "));
    }else{
      $msg2 = "Sorry, Your details couldn't be edited. Please try again.";
    }
  }
}

if (isset($_POST['passport_submit'])) {

  $upload_passport_tmp_name=$_FILES['passport']['tmp_name'];
  $upload_passport_name=$_FILES['passport']['name'];
  $upload_passport_size=$_FILES['passport']['size'];

  $file_location="../portal/upload/passport-upload/";
  $upload_exts=array("jpg","jpeg","png");
  $err=array();
  $upload_passport_ext=strtolower(pathinfo($_FILES['passport']['name'],PATHINFO_EXTENSION));
  if (!in_array($upload_passport_ext, $upload_exts)) {
    $err[]="Select a photo in jpeg or png format";
  }elseif ($upload_passport_size>3000000) {
    $err[]="Photo size too large, select a photo that is not more than 3Mb";
  }else{
    @unlink($file_location.'/'.$get_user['passport']);
    $hash=md5(time().mt_rand(10,99).$user_id);
    $file_path_name=$hash.'.'.$upload_passport_ext;
    if (move_uploaded_file($upload_passport_tmp_name, $file_location.$file_path_name)) {
          $insert_passport=mysqli_query($mysqli,"UPDATE principal SET passport= '{$file_path_name}' WHERE principal_id='{$u}' ");
          resizeImg($file_location.'/'.$file_path_name,$upload_passport_size,$upload_passport_ext);
          if ($insert_passport) {
            $msg="Profile photo changed successfully";
            $get_user=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM principal WHERE principal_id = '$u' "));
          }else{
            $err[]="An error occured, try again";
          }
        }
  }
  
}


if (isset($_POST['password_submit'])) {
    $n_password=$_POST['password'];
    $c_n_password=$_POST['c_password'];
    $err=[];
  if ((empty($n_password))||(empty($c_n_password))) {
    $err[]="All fields are required";
  }elseif (!preg_match('/^[-a-zA-Z0-9 _ \.]+$/', $n_password)||(!preg_match('/^[-a-zA-Z0-9 _ \.]+$/', $c_n_password))) {
    $err[]="Fill the fields with letters or numbers";
  }elseif ((strlen($passport)<6)&&(strlen($n_password)<6)&&(strlen($c_n_password)<6)) {
    $err[]="Password field lenght must not be less than 6";
  }elseif ($n_password!=$c_n_password) {
    $err[]="Passwords don't match.";
  }else{
      $n_password=md5($n_password);

        $update_password=mysqli_query($mysqli,"UPDATE principal SET password='{$n_password}' 
            WHERE principal_id='{$u}'");
        if ($update_password) {
          $msg="Password changed successfully.";
          $get_user=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM principal WHERE principal_id = '$u' "));
        }else{
      $err[]=" An error occured, try again";
    }
  }

}

?>
<title>Update Profile</title>
  <div class="left_divs">
    <?php include 'inc/left_menu.inc.php'; ?>
  </div><!-- 
  --><div class="contents">
	<div id="welcome" class="home_welcome">
			<h4>Update your Profile</h4>
	</div>
    <center>
    <div class="news_panel_wrapper white_background">
      <!-- <form enctype="multipart/form-data" method="post" id="add_audio_form"> -->
        <div>
          <?php 

            if (isset($err)) {
              foreach ($err as $error) {
                print("<p class='error' style='padding:12px'>$error</p><hr>");
              }
            }
            if (isset($msg)) {
              echo "<p class='success'>$msg</p><hr>";
            }
          ?>
        </div>

          <?php if ($type=='w') {?>
          <form method="post" enctype="multipart/form-data">
            
            <div class="news_panel_each">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" placeholder="Enter password" required>
            </div>

            <div class="news_panel_each">
              <label for="c_password">Confirm password</label>
              <input type="password" name="c_password" id="c_password" placeholder="Confirm your password">
            </div>

            <div class="news_panel_each">
              <input type="submit" name="password_submit" value="Change Password">
              <a href="settings?type=g">Edit  Profile</a>
            </div>
          </form>
          <?php }elseif ($type=='p') {?>
          <form method="post" enctype="multipart/form-data">
            
            <div class="news_panel_each">
              <label for="passport">Browse your passport</label>
              <input type="file" name="passport" id="passport" accept="images/*" onchange="upload(this);">
            </div>
            <div class="news_panel_each" style="margin-top:20px;">
              <img src="<?php if (isset($get_user['passport'])&&!empty($get_user['passport'])) {
                echo 'uploads/passports/'.$get_user['passport'];
              } ?>" id="preview_pic_img" alt="PASSPORT PREVIEW" style="width: 100%;height: auto;border: 1px solid #666;padding: 10px;">
            </div>
            <div class="news_panel_each">
              <input type="submit" name="passport_submit" value="Change Picture">
              <a href="settings?type=w">Change password</a>
            </div>
          </form>
          <?php }else{ ?>
          <form method="post" enctype="multipart/form-data">
            <div class="news_panel_each">
              <label for="name">Full name</label>
              <input type="text" name="name" id="name" placeholder="Enter your full name" value="<?php if(isset($get_user['name'])&&!empty($get_user['name'])){echo($get_user['name']);} ?>" required>
            </div>
            <div class="news_panel_each">
              <label for="email">Email Address</label>
              <input type="email" name="email" id="email" placeholder="Enter email address" value="<?php if(isset($get_user['email'])&&!empty($get_user['email'])){echo($get_user['email']);} ?>" >
            </div>

            <div class="news_panel_each">
              <label for="mobile_no">Phone number</label>
              <input type="tel" name="mobile_no" id="mobile_no" placeholder="Mobile number" value="<?php if(isset($get_user['mobile_no'])&&!empty($get_user['mobile_no'])){echo($get_user['mobile_no']);} ?>" >
            </div>

            <div class="news_panel_each">
              <label for="age">Age</label>
              <input type="number" name="age" id="age" value="<?php if(isset($get_user['age'])&&!empty($get_user['age'])){echo($get_user['age']);} ?>">
            </div>

            <div class="news_panel_each gender_div">       
              <label for="gender">Gender</label>
              <select name="gender" id="gender">
                <?php if(isset($get_user['gender'])&&!empty($get_user['gender'])){
                  echo "<option>".ucwords($get_user['gender'])."</option>";
                   if(strtolower($get_user['gender'])=='male'){
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

            <div class="news_panel_each">
              <input type="submit" name="submit" value="Update Profile">
              <a href="settings?type=p">Change profile Picture</a>
            </div>
          </form>
          <?php } ?>
      <!-- </form> -->
    </div>
    </center>
  </div>
  

<?php
include("inc/footer.inc.php");
?>

<script type="text/javascript">
function upload(f) {
  var fiePath = $('#passport').val();
  var reader = new FileReader();
  reader.onload = function (e) {
    $('#preview_pic_img').attr('src',e.target.result);
  };
  reader.readAsDataURL(f.files[0]);
}
</script>
<script type="text/javascript">
  (function() {
    $(document).ready(function() {


    });
  })();
</script>
</body>
</html>