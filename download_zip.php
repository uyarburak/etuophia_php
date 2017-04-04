<?php
	session_start();
	if(!isset($_SESSION['member_id'])){
		header("Location: login.php");
		die();
	}
	if(isset($_GET['hw_id'])){
		$hw_id = $_GET['hw_id'];
		// include db connect class
		require_once __DIR__ . '/common/util.php';
		// connecting to db
		$util = new Util();
	
		$member_id = $_SESSION['member_id'];
		if($util -> hasAccessToZip($hw_id, $member_id)){
			
			$hw_info = $util -> getHomeworkInfo($hw_id);
			$deadline = new DateTime($hw_info['DEADLINE_TIME']);
			
			require_once __DIR__ . '/lib/ZipStream.php';
			# create a new zipstream object
			$zipName = preg_replace('/\/+/', '-', $hw_info['RESOURCE_TITLE'].' - '.$hw_info['COURSE_ID'].'('.$deadline->format('d/m/Y').').zip');
			$zip = new ZipStream\ZipStream($zipName);

			# create a file named 'hello.txt' 
			#$zip->addFile('hello.txt', 'This is the contents of hello.txt');

			
			$result = $util -> getHomeworkURLS($hw_id);
			while($row = mysqli_fetch_assoc($result)){
				$upload_time = new DateTime($row['UPLOAD_TIME']);
				$title = $row['NAME'].'('.$upload_time->format('d/m/Y - H:i').')'.$row['RESOURCE_TITLE'];
				$title = preg_replace('/\/+/', '-', $title);
				if($upload_time > $deadline){
					$title = 'Late/'.$title;
				}else{
					$title = 'In Time/'.$title;
				}
				$zip->addFileFromPath($title, $row['URL']);
			}

			# finish the zip stream
			$zip->finish();
			
			
			
			
			
		}else{
			echo 'You dont have permission to see it';
		}
	}else{
		echo 'You are in wrong place';
	}
?>