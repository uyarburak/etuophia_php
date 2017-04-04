<?php
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
		$course_id = $_SESSION['course_id'];
		
		$hw_id = $_POST['hw_id'];
		$return_url = $_POST['return_url'];
		$member_info = $util -> getMemberInfo($member_id, $course_id);
		if($member_info['IS_ADMIN']){
			if(isset($_POST['duedate'])){
					$date = DateTime::createFromFormat('d/m/Y H:i:s', $_POST['duedate'].':00');
					$mysql_date_string = $date->format('Y-m-d H:i:s');
					if(isset($_POST['auto_lock'])){
						$lock_type = 2;
					}else{
						$lock_type = 0;
					}
					$util -> extendDueDateHomework($hw_id, $mysql_date_string, $lock_type);
			}else if(isset($_POST['lock_button'])){
				$util -> changeLockType($hw_id, 1);
			}else if(isset($_POST['unlock_button'])){
				$util -> changeLockType($hw_id, 0);
			}
			header("Location: ".$return_url);
			die();
		}
?>