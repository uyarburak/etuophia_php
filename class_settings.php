<?php
	include("header.php");
	if(!$isAdmin){
		header("Location: index.php");
		die();
	}
	$isResources = false;
	$isNewTopic = false;
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}else{
		$page = 'default';
	}
?>
<nav id="main_topnav">
  <div class="container-fluid"><a href="javascript:;" class="pull-left toggle-aside"><i class="icon-">&#xf0a9; </i></a><a href="javascript:;" class="pull-right toggle-topmenu"><i class="icon-">&#xf0c9; </i></a>
    <ul>
      <li><a href="index.php" title="Q/A"><i class="icon-comments"></i> Q/A</a></li>
      <li><a href="index.php?class=<?php echo $course_id;?>&page=resources" title="RESOURCES"><i class="icon-folder-open"></i> RESOURCES</a></li>
	  <li><a href="class_settings.php?class=<?php echo $course_id; ?>" title="Class Settings"><i class="icon-cog"></i> Class Settings</a></li>
    </ul>
  </div>
</nav>

<!--TOP NAV ENDS-->
<aside id="left_panel">
  <div class="container-fluid">
	  <div class="btn-group" style="margin-bottom:20px;width: 100%;">
		  <a href="#" style="width: 100%;" class="pink-bg btn btn-med" data-toggle="dropdown"><?php echo $course_id; ?>  <i class="pull-right icon-angle-down"></i></a>
		  <ul style="width: 100%;" class="dropdown-menu">
				<?php
				$result = $util ->getCoursesAdmin($member_id, $course_id);
				while($row = mysqli_fetch_assoc($result)) 
				{
					echo '<li><a href="?class='.$row['COURSE_ID'].'">'.$row['COURSE_ID'].'</a></li>';
				}
			?>
		  </ul>
	  </div>
  </div>
  <nav id="aside_nav">
    <ul>
	<?php
		if($member_type == 'Instructor'){
			?>
		<li><a href="javascript:;">Manage Members <i class="pull-right icon-angle-down"></i></a>
		  <ul>
		   <li><a href="?class=<?php echo $course_id; ?>&page=members">Manage Students</a></li>
		   <li><a href="?class=<?php echo $course_id; ?>&page=members_add">Add Students</a></li>
		  </ul></li>
			<?php
		}
	?>
			<li><a href="javascript:;">Homeworks<i class="pull-right icon-angle-down"></i></a>
		  <ul>
		  <?php
			$result = $util -> getHomeworksForManagement($course_id);
			if($result->num_rows){
				while($row = mysqli_fetch_assoc($result)){
						echo '<li><a href="?class='.$course_id.'&page=homeworks&hw_id='.$row['HW_ID'].'">Homework ('.$row['RESOURCE_TITLE'].')</a></li>';
				}
			}else{
				echo '<li style="margin:20px;"><span> There is no homework assigned for this class.</span></li>';
			}
		  ?>
		  </ul></li>
		<li>
    </ul>
  </nav>
</aside>
<!--ASIDE LEFT PANNEL ENDS-->
<?php 
	if($page == 'members'){
		include("manage_members.php");
		echo '<script src="assets/js/scripts.js"></script>';
	}else if($page == 'members_add'){
		include("manage_members_add.php");
		echo '<script src="assets/js/scripts.js"></script>';
	}else if($page == 'homeworks'){
		$hw_id = $_GET['hw_id'];
		include("manage_homeworks.php");
	}else{
		include("edit_class_atts.php");
		echo '<script src="assets/js/scripts.js"></script>';
	}
?>

</body>
</html>