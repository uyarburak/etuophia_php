<head>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8">
</head>
<?php
	session_start();
	if(isset($_SESSION['member_id'])){
		header("Location: index.php");
		die();
	}
	else if(isset($_POST['m_id'])){
		$_SESSION['member_id'] = $_POST['m_id'];
		header("Location: index.php");
		die();
	}else{
		// include db connect class
		require_once __DIR__ . '/common/util.php';
		// connecting to db
		$util = new Util();
		$result = $util ->getAllMembers();
		echo '<form name="Start" method="POST" action=""><select name="m_id">';
			while($row = mysqli_fetch_assoc($result)) 
			{
				echo "<option value = '".$row['M_ID']."'>".$row['NAME']."</option>";
			}
			echo '</select><br>';
			echo '<input type="submit" method="POST" ></form><br>';
			?>
			or
			<form name="Start" method="POST" action="">
			<select name="m_id">
				<option value="386">Tansel Ozyer</option>
				<option value="4905">Yunuscan Kocak</option>
				<option value="856">Kerim Siper</option>
				<option value="2534">Yunus Irhan</option>
				<option value="844">Burak Uyar</option>
			</select>
			<input type="submit" method="POST">
			</form>
			or
			<?php
			$result = $util ->getStudentsOfCourse('BİL 372');
		echo '<form name="Start" method="POST" action=""><select name="m_id">';
			while($row = mysqli_fetch_assoc($result)) 
			{
				echo "<option value = '".$row['M_ID']."'>".$row['NAME']."</option>";
			}
			echo '</select><br>';
			echo '<input type="submit" method="POST" ></form><br>';
	}
?>