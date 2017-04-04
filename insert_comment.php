<?php
if(isset($_POST['comment_content'])){
	$comment_id = $util ->insertComment($_POST['comment_content'], $member_id, $topic, $_POST['parent_id'], $_POST['is_anonymous']);
	$_POST = array();
	header("Location: asd.php");
	exit();
}
?>