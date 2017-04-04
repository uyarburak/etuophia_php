<?php
function redirect($url){ 
    echo '<script type="text/javascript">'; 
        echo 'window.location.href="'.$url.'";'; 
        echo '</script>'; 
        echo '<noscript>'; 
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />'; 
        echo '</noscript>'; exit; 
} 

	session_start();
	if(!isset($_SESSION['member_id'])){
		header("Location: login.php");
		die();
	}
	// include db connect class
    require_once __DIR__ . '/common/util.php';
	// connecting to db
    $util = new Util();
	$member_id = $_SESSION['member_id'];
	if(isset($_GET['class'])){
		$_SESSION['course_id'] = $course_id = $_GET['class'];
	}else{
		if(isset($_SESSION['course_id'])){
			$course_id = $_SESSION['course_id'];
		}else{
			$_SESSION['course_id'] = $course_id = $util ->getFirstCourse($member_id);
		}
	}
	$member_info = $util -> getMemberInfo($member_id, $course_id);
	$member_name = $member_info['NAME'];
	$member_image = $member_info['IMAGE_URL'];
	$isAdmin = $member_info['IS_ADMIN'];
	
	if($member_info['ins']){
		$member_type = 'Instructor';
	}else if($isAdmin){
		$member_type = 'Assistant';
	}else{
		$member_type = 'Student';
	}
?>
<html lang="en">
<head>
<title>ETU Piazza - <?php echo $course_id;?></title>
<!-- Meta Tags -->
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="shortcut icon" href="assets/images/favicon.ico" />
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=Standards"><![endif]-->
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<!-- Bootstrap Version 3.0-->
<link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css" />
<!-- Datetime 3.0-->
<link rel="stylesheet" href="assets/css/bootstrap/bootstrap-datetimepicker.min.css" />
<!--Base style sheet-->
<link href="assets/css/base.css" type="text/css" rel="stylesheet">

<link href="assets/css/fontawesome/font-awesome.min.css" rel="stylesheet"/>
			  
<script src="//cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>

<link href="assets/css/data-tables/data-table.css" type="text/css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]><script src="assets/js/html5shiv/html5shiv.js" type="text/javascript"></script><script src="assets/js/respond/respond.min.js" type="text/javascript"></script><![endif]-->
</head>
<body>
<header>
  <div class="container-fluid clearfix"><a href="index.php" title="Metro Admin" class="pull-left"><img src="assets/images/logo.png" height="39px" ></a>
    <div class="user pull-right"><a href="#" title="User Options" data-toggle="dropdown" class="pull-right">
      <div class="pull-left">
        <h5><?php echo $member_name;?></h5>
        <p><?php echo $member_type;?></p>
      </div>
	  
      <div class="pull-right"><img src="<?php if(empty($member_image)){echo 'assets/images/user_pic/user.jpg';}else{echo $member_image;}?>" width="38px" title="User Pic" alt="User Pic"></div>
      </a>
      <ul class="dropdown-menu pull-right">
        <li><a href="edit_profile.php">Edit profile</a></li>
        <li><a href="profile.php?m=<?php echo $member_id;?>">Show profile</a></li>
        <li><a href="logout.php">Sign out</a></li>
      </ul>
    </div>
  </div>
</header>
<!--HEADER ENDS-->