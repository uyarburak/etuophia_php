<?php
	session_start();
	if(!isset($_SESSION['member_id']) || !isset($_GET['id'])){
		header("Location: login.php");
		die();
	}
	// include db connect class
    require_once __DIR__ . '/common/util.php';
	// connecting to db
    $util = new Util();
	
	$member_id = $_SESSION['member_id'];
	$res_id = $_GET['id'];
	$row = $util -> hasAccess($res_id, $member_id);
	if($row['COUNT']){
		header("Location: ".$row['URL']);
	}else{
		echo "You have no access to this resource.<br>";
	}
?>