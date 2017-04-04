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
		$res_id = $_POST['res_id'];
		$return_url = $_POST['return_url'];
		if(!$member_info['IS_ADMIN']){
			$isOwner = $util -> isOwner($member_id, $res_id);
			if(!$isOwner){
				header("Location: ".$return_url);
				die();
			}
		}
		$file_url = $util -> deleteResource($res_id);
		unlink($file_url);
		header("Location: ".$return_url);
		die();
	}
?>