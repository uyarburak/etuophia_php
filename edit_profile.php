<?php
	if(isset($_POST['member_id'])){
		session_start();
		if(isset($_SESSION['member_id']) && ($_POST['member_id'] == $_SESSION['member_id']) ){
			// include db connect class
			require_once __DIR__ . '/common/util.php';
			// connecting to db
			$util = new Util();
			$id = $_POST['member_id'];
			if(isset($_POST['password'])){
				$current_password = $_POST['current_password'];
				$new_password = $_POST['password'];
				$dbHash = $util -> getPassword($id);
				if(password_verify($current_password, $dbHash)){
					$util -> updatePassword($id, password_hash($current_password, PASSWORD_BCRYPT));
					echo 'Password has changed.';
				}else{
					echo 'Password is wrong';
				}
			}else{
				$email = $_POST['email'];
				$image_url = $_POST['image_url'];
				$util -> updateMember($id, $email, $image_url);
			}
			if(isset($_POST['office'])){
				$office = $_POST['office'];
				$tel = $_POST['tel'];
				$website = $_POST['website_url'];
				$util -> updateInstructor($id, $office, $tel, $website);
			}
			header('Location: edit_profile.php');
			die();
		}
	}
	include("header.php");
	$member_email = $member_info['MAIL'];
	if($member_info['ins']){
		$ins_info = $util -> getInstructorInfo($member_id);
		$member_office = $ins_info['OFFICE'];
		$member_tel = $ins_info['TEL'];
		$member_website = $ins_info['WEBSITE'];
	}
?>

<nav id="main_topnav">
  <div class="container-fluid"><a href="javascript:;" class="pull-left toggle-aside"><i class="icon-">&#xf0a9; </i></a><a href="javascript:;" class="pull-right toggle-topmenu"><i class="icon-">&#xf0c9; </i></a>
    <ul>
      <li><a href="index.php" title=""><i class="icon-home"></i> Home</a></li>
    </ul>
  </div>
</nav>
<aside id="left_panel">
  <nav id="aside_nav">
	<h1><small style="padding:8px 20px;">Image Preview:</small></h1><img id="image_preview" src="<?php echo $member_image; ?>" style="margin-left:10px;" title="User Pic" alt="User Pic" width="250px" height="250px">
  </nav>
</aside>
<!--ASIDE LEFT PANNEL ENDS-->
<section id="main_content">
	<div class="container-fluid">
		<div class="page-header">
		  <h1>Edit Profile <small>Edit your personal info or change your password</small></h1>
		</div>
		<div class="row">
		 <div class="panel colored col-md-8">
		  <div class="panel-heading red-bg">
		   <h3 class="panel-title">Edit Profile</h3>
		   <ul class="pull-right toolbar">
			<li><a href="#" class="icon-button"><i class="icon-"></i></a></li>
			<li><a href="#" class="icon-button mini-max"><i class="icon-"></i></a></li>
		   </ul>
		  </div>
		  <form class="form-horizontal" action="" method="POST" id="advanced-validation">
		   <div class="panel-body">
			<div class="row">
			 <div class="col-md-12">
			  <div class="form-group">
			   <label class="control-label col-lg-2">Email</label>
			   <div class="col-lg-4">
				<input type="email" name="email" class="form-control" value="<?php echo $member_email; ?>"/>
			   </div>
			  </div>
			 </div>
			</div>
			<div class="row">
			 <div class="col-md-12">
			  <div class="form-group">
			   <label class="control-label col-lg-2">Image URL</label>
			   <div class="col-lg-10">
				<input type="text" name="image_url" id="url" onchange="updateImage(this.value)" class="form-control" value="<?php echo $member_image; ?>"></input>
			   </div>
			  </div>
			 </div>
			</div>
			<?php if($member_info['ins']){ ?>
			<div class="row">
			  <div class="col-md-6">
			  <div class="form-group">
			   <label class="control-label col-lg-4">Office</label>
			   <div class="col-lg-8">
				<input type="text" name="office" class="form-control" value="<?php echo $member_office; ?>"/>
			   </div>
			  </div>
			 </div>
			 <div class="col-md-6">
			  <div class="form-group">
			   <label class="control-label col-lg-4">Tel</label>
			   <div class="col-lg-8">
				<input type="text" name="tel" class="form-control" value="<?php echo $member_tel; ?>"/>
			   </div>
			  </div>
			 </div>
			</div>
			<div class="row">
			 <div class="col-md-12">
			  <div class="form-group">
			   <label class="control-label col-lg-2">Website URL</label>
			   <div class="col-lg-10">
				<input type="text" name="website_url" class="form-control" value="<?php echo $member_website; ?>"></input>
			   </div>
			  </div>
			 </div>
			</div>
			<?php } ?>
		   </div>
		   <div class="panel-footer">
			<div class="form-group">
			 <div class="col-lg-12">
			  <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
			  <button type="submit" class="btn btn-sm btn-success">Submit Details</button>
			  <a href="#" class="btn gray-bg">Cancel</a>
			 </div>
			</div>
		   </div>
		  </form>
		 </div>	
		</div>
		<div class="row">
				 <div class="panel colored col-md-8">
		  <div class="panel-heading black-bg">
		   <h3 class="panel-title">Change Password</h3>
		   <ul class="pull-right toolbar">
			<li><a href="#" class="icon-button"><i class="icon-"></i></a></li>
			<li><a href="#" class="icon-button mini-max"><i class="icon-"></i></a></li>
		   </ul>
		  </div>
		  <form class="form-horizontal" action="" method="POST" id="advanced-validation2">
		   <div class="panel-body">
			<div class="row">
			 <div class="col-md-6">
			  <div class="form-group">
			   <label class="control-label col-lg-4">Current Password</label>
			   <div class="col-lg-8">
				<input type="password" id="current_password" name="current_password" class="form-control"></input>
			   </div>
			  </div>
			 </div>
			</div>
			<div class="row">
			 <div class="col-md-6">
			  <div class="form-group">
			   <label class="control-label col-lg-4">New Password</label>
			   <div class="col-lg-8">
				<input type="password" id="password" name="password" class="form-control"></input>
			   </div>
			  </div>
			 </div>
			 <div class="col-md-6">
			  <div class="form-group">
			   <label class="control-label col-lg-4">Re-enter New Password</label>
			   <div class="col-lg-8">
				<input type="password" id="password_again" name="password_again" class="form-control"></input>
			   </div>
			  </div>
			 </div>
			</div>
		   </div>
		   <div class="panel-footer">
			<div class="form-group">
			 <div class="col-lg-12">
			  <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
			  <button type="submit" class="btn btn-sm btn-success">Change Password</button>
			  <a href="#" class="btn gray-bg">Clear</a>
			 </div>
			</div>
		   </div>
		  </form>
		 </div>	
		</div>
	</div>
</section>
<script>
function updateImage(ish){
    document.getElementById("image_preview").src = ish;
}
</script>
<script src="assets/js/scripts.js"></script>