<?php
	session_start();
	if(isset($_SESSION['member_id'])){
		header("Location: index.php");
		die();
	}
	else if(isset($_POST['mail']) && isset($_POST['password'])){
		// include db connect class
		require_once __DIR__ . '/common/util.php';
		// connecting to db
		$mail = $_POST['mail'];
		$password = $_POST['password'];
		$util = new Util();
		
		if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			$mail .= '@etu.edu.tr';
		}
		
		$dbHash = mysqli_fetch_assoc($util -> getPasswordMail($mail));
		$message = '';
		if(is_null($dbHash)){
			$message = 'Email not found';
		}else if(password_verify($password, $dbHash['PASSWORD'])){
			$_SESSION['member_id'] = $dbHash['M_ID'];
			header("Location: index.php");
			die();
		}else{
			$message = 'Password is wrong';
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <title>Etuophia Login</title>
  <!-- Meta Tags -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <link rel="shortcut icon" href="assets/images/favicon.ico" />
  <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=Standards"><![endif]-->
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <!-- Bootstrap Version 3.0-->
      <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css" />
      <!--Base style sheet-->
      <link href="assets/css/base.css" type="text/css" rel="stylesheet">
       <!-- Styled Checkbox/Radiobuttons-->
       <link rel="stylesheet" href="assets/css/icheck-skins/square/blue.css" /> 
       <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
       <!--[if lt IE 9]><script src="assets/js/html5shiv/html5shiv.js" type="text/javascript"></script><script src="assets/js/respond/respond.min.js" type="text/javascript"></script><![endif]-->
      </link>
     </meta>
    </meta>
   </meta>
  </meta>
 </head>
 <body class="blue-bg">
  <div class="signin">
   <div class="signin-body">
    <h3>Login to your account</h3>
    <form action="" method="POST" enctype="multipart/form-data" id="basic-validation">
     <div class="form-group">
      <input type="text" class="form-control" placeholder="Email ID" name="mail" />
     </div>
     <div class="form-group">
      <input type="password" class="form-control" placeholder="Password" name="password" id="lastname" />
     </div>
     <div class="form-group clearfix">
      <label class="checkbox pull-left"><input type="checkbox" class="icheck" data-skin="square" data-color="blue"> Remember me</input></label>
      <input type="submit" class="btn btn-med blue-bg pull-right" value="Login" />
     </div>
	 <?php
		if(!empty($message)){
			echo '<hr><span class="label label-danger">'.$message.'!</span></hr>';
		}
	 ?>
    </form>
   </div>
  </div>
  <script src="assets/js/scripts.js"></script> 
 </body>
</html>