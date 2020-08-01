<?php require_once 'functions.inc.php';
?>
 <!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/user-register.css">
	<link rel="stylesheet" type="text/css" href="css/add-post.css">
	<link rel="stylesheet" type="text/css" href="css/students-teachers-view.css">
	<link rel="stylesheet" type="text/css" href="css/modals.inc.css">
	<link rel="stylesheet" type="text/css" href="css/information.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
	<link rel="stylesheet" type="text/css" href="../portal/css/upload.css">
	<link rel="stylesheet" type="text/css" href="../portal/css/edit-results.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  	<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/sweetalert.css">
	<link href="https://fonts.googleapis.com/css?family=Droid+Serif|Lora|Noto+Sans|Nunito|Roboto|Saira|Saira+Extra+Condensed|Ubuntu" rel="stylesheet">


  <!-- vendors -->
    <!-- Bootstrap -->
    <link href="../js/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../js/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../js/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../js/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../js/vendors/build/css/custom.css" rel="stylesheet">

    
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
<div class="container_div">
	<div class="header_div">
		<div class="desc">
			<h1><b><?php echo $schDetails['school_code']; ?></b> <span>Admin Panel</span></h1>
		</div><div class="user_info">
			<div class="menu_icon" id="menu-toggle">MENU</div><!--

		--><div class="profile">
				<a class="slidee">
					<img src="<?php if(isset($passport)){echo("../portal/upload/passport-upload/".$passport);} ?>">
					nedum  <span class="fa fa-angle-down"></span>  
				</a>
				<ul>
					<li><a href="profile"><i class="fa fa-user"></i> Profile</a></li>
					<li><a href="settings"><i class="fa fa-pencil"></i> Settings</a></li>
					<li><a href="process/logout"><i class="fa fa-sign-out"></i> Log out</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="wrapper" style="display:non;">
	<div class="nav_div">
		<div class="theiaStickySidebar">

			<div class="user_nav_desc">
				<div class="user_img" style="background-image: ">
					<img src="<?php if(isset($passport)){echo("../portal/upload/passport-upload/".$passport);} ?>">
				</div><div class="name_online">
					<b><?php echo ucwords($name); ?></b>
					<span><i class="fa fa-circle"></i> Online</span>
				</div>
			</div>
			<div class="search">
				<input type="text" placeholder="Search...">
				<i class="fa fa-search"></i>
			</div>
			<div class="main_navigation">
				Main Navigation
			</div>
			<ul>
				<li>
					<a href="dashboard">
						<i class="fa fa-dashboard"></i> Dasboard <i class="fa fa-cogs"></i>
					</a>
				</li>
				<li>
					<a href="students-view">
						<i class="fa fa-users"></i> Students <i class="fa fa-bomb gg"></i>
					</a>
				</li>
				<li>
					<a href="teachers-view">
						<i class="fa fa-language"></i> Teachers <i class="fa fa-asl-interpreting"></i>
					</a>
				</li>
				<li>
					<a href="result-upload">
						<i class="fa fa-upload"></i> Upload Result <i class="fa fa-share gg"></i>
					</a>
				</li>
				<li>
					<a href="upload-cur-ass">
						<i class="fa fa-file-pdf-o"></i> Upload Curriculum <i class="fa fa-clone gg"></i>
					</a>
				</li>
				<li>
					<a href="information">
						<i class="fa fa-info-circle"></i> Information <i class="fa fa-bell"></i>
					</a>
				</li>
				<li>
					<a href="view-school-subjects">
						<i class="fa fa-paste"></i> Subjects <i class="fa fa-paw"></i>
					</a>
				</li>
				<li>
					<a href="user-register">
						<i class="fa fa-universal-access"></i> Register Staff <i class="fa fa-plus gg"></i>
					</a>
				</li>
				<li>
					<a href="result-sheet">
						<i class="fa fa-book"></i>	Result Sheet <i class="fa fa-print"></i>
					</a>
				</li>
				<li>
					<a href="profile">
						<i class="fa fa-dot-circle-o"></i> Profile Details <i class="fa fa-map-pin"></i>
					</a>
				</li>
				<li>
					<a href="settings">
						<i class="fa fa-history"></i> Settings <i class="fa fa-pencil gg"></i>
					</a>
				</li>
				<li>
					<a href="process/logout">
						<i class="fa fa-sign-out"></i> Logout <i class="fa fa-arrow-circle-o-right"></i>
					</a>
				</li>

			</ul>
		</div>
	</div><div class="right">
		<div class="theiaStickySidebar">
