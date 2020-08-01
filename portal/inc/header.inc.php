<?php
include("plan_connect.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,user-scalable=no">
  <meta name="author" content="APTECH Computer Education">
  <meta name="description" content="Building responsive website designs using media queries">
  <meta name="keywords" content="responsive,design,HTML5,CSS3,media,queries, media queries, viewport,apps">
  <!-- <title>HOME</title> -->
  <!-- // bootstrap high fonts -->
  <link href="css/content/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="css/content/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Droid+Serif|Lora|Noto+Sans|Nunito|Roboto|Saira|Saira+Extra+Condensed|Ubuntu" rel="stylesheet">
    <!-- <link href="../Content/Styles/style.css" rel="stylesheet" type="text/css" />  -->

    <!-- other links -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/home.css">
  <link rel="stylesheet" type="text/css" href="css/upload.css">
  <link rel="stylesheet" type="text/css" href="css/edit-results.css">
  <link rel="stylesheet" type="text/css" href="css/teacher-management.css">
  <link rel="stylesheet" type="text/css" href="css/view-all-result.css">
  <link rel="stylesheet" type="text/css" href="css/view-result.css">
  <link rel="stylesheet" type="text/css" href="css/students-teachers.css">
  <link rel="stylesheet" type="text/css" href="css/profile.css">
  <link rel="stylesheet" type="text/css" href="css/information.css">
  <link rel="stylesheet" type="text/css" href="css/check-result.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="css/flickity.css">
  <!-- vendors -->
    <!-- Bootstrap -->
    <link href="../js/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../js/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../js/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../js/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../js/vendors/build/css/custom.css" rel="stylesheet">

</head>
<body>
<div id="loader"></div>
<div id="loaderWrapper"></div>
<div class="container_div">
<div class="header_div">
  <ul id="left">
    <li id="faculty"> <img src="../images/logo.jpg" id="home_logo"> </li>
    <li id="sch_name"> <?php echo strtoupper($schDetails['school_name']); ?> </li>
    <li id="userImg"><a href="profile"> 
      <img src="<?php if(!empty($passport)){echo "upload/passport-upload/".$passport;}
            else{ echo "upload/passport-upload/"."both.png";} ?>"> 
      <span><?php if(isset($id)){echo $id;} ?></span></a>
    </li>

  </ul>
</div>
<div class="mobile_div">
  <ul id="mobile">
    <li id="m_logo_li"  style="width: 10%;"> <img src="../images/unizik-logo.jpg" id="home_logo"></li>
    <li style="width: 85%;"><span id="bars" ><i class="fa fa-bars" id="mobile-menu"></i></span>
      <ul id="modile_ul_container">
        <li id="faculty"><a href="home.php"><i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i></a></li>
        <li><a href="profile.php"><i class="fa fa-edit"></i> Edit profile <i class="fa fa-angle-right"></i></a></li>
        <?php 
        if ($status!="teachers") {
          echo '<li><a href="view-curriculum"><i class="fa fa-book"></i> View curriculum <i class="fa fa-angle-right"></i></a></li><li><a href="view-assignment"><i class="fa fa-eye"></i> View Assignment <i class="fa fa-angle-right"></i></a></li>';
        }if ($status=="students") {
              echo '<li id="student"><a href="check-result"><i class="fa fa-certificate"></i> Check result <i class="fa fa-angle-right"></i></a></li>
              <li id="student"><a href="school-fees"><i class="fa fa-briefcase"></i> School Fees<i class="fa fa-angle-right"></i></a></li>
              <li id="student"><a href="info-view"><i class="fa fa-info"></i> Notifications<i class="fa fa-angle-right"></i></a></li>';
        }if ($status=="teachers") {
          echo '<li id="faculty"><a href="uploads"><i class="fa fa-upload"></i> Upload <i class="fa fa-angle-right"></i></a></li>
              <li id="student"><a href="info-view.php"><i class="fa fa-info"></i> Notifications<i class="fa fa-angle-right"></i></a></li>';
        }
        if (!empty($f_class)) {
          echo '<li id="student"><a href="teacher-management.php"><i class="fa fa-users"></i> Your Class <i class="fa fa-angle-right"></i></a></li>';
        }
         ?>       
        <li><a href="process/logout"><i class="fa fa-power-off"></i> Logout <i class="fa fa-angle-right"></i></a></li>
      </ul>      
    </li>
  </ul>
</div>