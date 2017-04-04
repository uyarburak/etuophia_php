<?php
session_start();
	if(!isset($_SESSION['member_id'])){
		header("Location: login.php");
		die();
	}
	if(isset($_POST['res_id'])){
		// include db connect class
		require_once __DIR__ . '/common/util.php';
		// connecting to db
		$util = new Util();
		$member_id = $_SESSION['member_id'];
		$course_id = $_SESSION['course_id'];
		
		$member_info = $util -> getMemberInfo($member_id, $course_id);
		if($member_info['IS_ADMIN']){
			$res_id = $_POST['res_id'];
			$return_url = $_POST['return_url'];
			$new_res_type = $_POST['new_res_type'];
			
			$util -> changeResourceType($res_id, $new_res_type);
			header("Location: ".$return_url);
			die();
		}
	}
?>