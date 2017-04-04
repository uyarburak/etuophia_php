<?php
session_start();
	if(!isset($_SESSION['member_id'])){
		header("Location: login.php");
		die();
	}
	if(isset($_POST['topic_id'])){
		// include db connect class
		require_once __DIR__ . '/common/util.php';
		// connecting to db
		$util = new Util();
		$member_id = $_SESSION['member_id'];
		
		$topic_id = $_POST['topic_id'];
		
		$isAdmin = $util -> isAdminToTopic($member_id, $topic_id);
		
		if($isAdmin){
			$util -> deleteTopic($topic_id);
		}
		header("Location: index.php");
		die();
	}
?>