<?php
   if(isset($_FILES['homework_file'])){
	   session_start();
	   $member_id = $_SESSION['member_id'];
		$course_id = $_SESSION['course_id'];
	  // include db connect class
	  require_once __DIR__ . '/common/util.php';
	  // connecting to db
	  $util = new Util();
	  $hw_id = $_POST['hw_id'];
	  $return_url = $_POST['return_url'];
      $errors= array();
      $file_name = $_FILES['homework_file']['name'];
      $file_size =$_FILES['homework_file']['size'];
      $file_tmp =$_FILES['homework_file']['tmp_name'];
      $file_type=$_FILES['homework_file']['type'];
	  $zaa = explode('.',$file_name);
      $file_ext=strtolower(end($zaa));
      
      $expensions= array("jpeg","jpg","png","zip","rar","pdf","doc","docx","txt");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 10485760){
         $errors[]='File size must be less than 10 MB';
      }
	  $file_name_without_ext = $zaa[0];
      
      if(empty($errors)==true){
		$url = "uploads/".$file_name_without_ext."-".uniqid().".".$file_ext;
        move_uploaded_file($file_tmp,$url);
        echo "<br>Success<br>: http://etustalk.club/piazza/".$url;
		$util -> insertStudentHomework($file_name, $url, $member_id, $course_id, $hw_id);
		
      }else{
         print_r($errors);
      }
	  header("Location: ".$return_url);
		die();
   }else{
	   header("Location: login.php");
		die();
   }
?>