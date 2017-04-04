<?php
session_start();
	if(!isset($_SESSION['member_id'])){
		header("Location: login.php");
		die();
	}
	if(isset($_POST['delete_comment_id'])){
		// include db connect class
		require_once __DIR__ . '/common/util.php';
		// connecting to db
		$util = new Util();
		$member_id = $_SESSION['member_id'];
		$course_id = $_SESSION['course_id'];
		
		$member_info = $util -> getMemberInfo($member_id, $course_id);
		$comment_id = $_POST['delete_comment_id'];
		$return_url = $_POST['return_url'];
		$removeComplete = false;
		if(!$member_info['IS_ADMIN']){
			$isOwner = $util -> isCommentOwner($member_id, $comment_id);
			if(!$isOwner){
				header("Location: ".$return_url);
				die();
			}
		}else{
			$removeComplete = isset($_POST['delete_complete']);
		}
		if($removeComplete){
			$util -> deleteComment($comment_id);
		}else{
			$util -> removeCommentContent($comment_id);
		}
		header("Location: ".$return_url);
		die();
	}
?>