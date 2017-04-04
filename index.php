<?php
	include("header.php");
	
	$hasEnroll = $util -> hasEnrollment($member_id, $course_id);
	$topic = -1;
	$isResources = false;
	$isNewTopic = false;
	if(isset($_GET['topic'])){
		$topic = $_GET['topic'];
	}else if(isset($_GET['page'])){
		$page = $_GET['page'];
		if($page == 'resources'){
			$isResources = true;
		}else if($page == 'new_topic'){
			$isNewTopic = true;
		}
	}
?>
<nav id="main_topnav">
  <div class="container-fluid"><a href="javascript:;" class="pull-left toggle-aside"><i class="icon-">&#xf0a9; </i></a><a href="javascript:;" class="pull-right toggle-topmenu"><i class="icon-">&#xf0c9; </i></a>
    <ul>
      <li><a href="index.php" title="Q/A"><i class="icon-comments"></i> Q/A</a></li>
      <li><a href="?class=<?php echo $course_id;?>&page=resources" title="RESOURCES"><i class="icon-folder-open"></i> RESOURCES</a></li>
	  <?php
		if($isAdmin){
			echo '<li><a href="class_settings.php?class='.$course_id.'" title="Class Settings"><i class="icon-cog"></i> Class Settings</a></li>';
		}
	  ?>
    </ul>
  </div>
</nav>

  <?php 
if(!$hasEnroll){
	
	include("403.php");
	$_SESSION['course_id'] = null;
}else{
?>

<!--TOP NAV ENDS-->
<aside id="left_panel">
  <div class="container-fluid">
	  <div class="btn-group" style="margin-bottom:20px;width: 100%;">
		  <a href="#" style="width: 100%;" class="pink-bg btn btn-med" data-toggle="dropdown"><?php echo $course_id; ?>  <i class="pull-right icon-"></i></a>
		  <ul style="width: 100%;" class="dropdown-menu">
				<?php
				$result = $util ->getCourses($member_id, $course_id);
				while($row = mysqli_fetch_assoc($result)) 
				{
					echo '<li><a href="?class='.$row['COURSE_ID'].'">'.$row['COURSE_ID'].'</a></li>';
				}
			?>
		  </ul>
	  </div>
  </div>
<a style="width:85%; margin-left:7.5%; margin-bottom:20px;" class="green-bg btn btn-med" href="?class=<?php echo $course_id;?>&page=new_topic">New Topic <i class="icon-plus pull-right"></i> </a>
  <nav id="aside_nav">
    <ul>
		  	<?php

							if($topic != -1){
								$row = $util ->getTopic($topic);
								$topicContent = $row['CONTENT'];
								$topicWriter = $row['NAME'];
								$topicDate = $row['CREATE_TIME'];
								$topicTitle = $row['TITLE'];
							}
							$result = $util ->getTopics($course_id, $member_id);
							if($result->num_rows == 0){
								echo '<li style="margin:20px;"><span> There is no topic for this class.</span></li>';
							}else{
								$rows = array(array(), array(), array());
								$counter = 0;
								$hasMonth = false;
								$hasOlder = false;
								$row = null;
								while($row = mysqli_fetch_assoc($result)){
									if(time_ago($row['CREATE_TIME']) < 7){
										$rows[0][$counter++] = $row;
									}else if(time_ago($row['CREATE_TIME']) < 31){
										$hasMonth = true;
										break;
									}else{
										$hasOlder = true;
										break;
									}
								}
								if($hasMonth){
									$counter = 0;
									do{
										if(time_ago($row['CREATE_TIME']) < 31){
											$rows[1][$counter++] = $row;
										}else{
											$hasOlder = true;
											break;
										}
									}while($row = mysqli_fetch_assoc($result));
								}
								if($hasOlder){
									$counter = 0;
									do{
										$rows[2][$counter++] = $row;
									}while($row = mysqli_fetch_assoc($result));
								}

								?>
								<div class="panel-body">
									<?php if(!empty($rows[0])){
										?>
										
									<div class="panel-group">
										<div class="panel colored">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
										  <div class="panel-heading blue-bg">
										   <h4 class="panel-title">this week</h4>
										  </div>
										  </a>
										  <div id="collapseOne" class="panel-collapse collapse in">
										   <div class="panel-body" style="padding: 5px;">
										   <?php printTopics($rows[0], $topic, $course_id); ?>
										   </div>
										  </div>
										 </div>
										 </div>
										<?php
									}if(!empty($rows[1])){?>
									<div class="panel-group">
										 <div class="panel colored">
										 <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
										  <div class="panel-heading blue-bg">
										   <h4 class="panel-title">this month</h4>
										  </div>
										  </a>
										  <div id="collapseTwo" class="panel-collapse collapse in">
										   <div class="panel-body" style="padding: 5px;">
										   <?php printTopics($rows[1], $topic, $course_id); ?>
										   </div>
										  </div>
										 </div>
										 </div>
										<?php
									}if(!empty($rows[2])){?>
									<div class="panel-group">
									 <div class="panel colored">
									 <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
									  <div class="panel-heading blue-bg">
									   <h4 class="panel-title">older</h4>
									  </div>
									  </a>
									  <div id="collapseThree" class="panel-collapse collapse in">
									   <div class="panel-body" style="padding: 5px;">
										<?php printTopics($rows[2], $topic, $course_id); ?>
									   </div>
									  </div>
									 </div>
									 </div>
								
								
									<?php } ?>
									
									
									</div>
									<?php						
							}
		?>
    </ul>
  </nav>
</aside>
<!--ASIDE LEFT PANNEL ENDS-->
<?php 
	if($isResources){
		include("resources.php");
	}else if($isNewTopic){
		include("new_topic.php");
	}
	else{
		include("topics.php");
	}
}
?>

<script src="assets/js/scripts.js"></script>
  
      <script type="text/javascript">
    function myfunc2(comment_id) {
 var selectedobj=document.getElementById(comment_id);

  if(selectedobj.className=='hide'){  //check if classname is hide 
    selectedobj.style.display = "block";
    selectedobj.readOnly=true;
    selectedobj.className ='panel panel-default';
  }else{
    selectedobj.style.display = "none";
    selectedobj.className ='hide';
 }
}
    </script>
</body>
</html>


<?php
	function time_ago($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		return $diff->y*365 + $diff->m *30 + $diff->d;
	}
	function printTopicTitle($row, $topic, $course_id) {
									$icon = '';
									if(!$row['IS_ADMIN']){
										$icon = '<span style="background-color:#1171a1;">S</span>';
									}
									if($row['TOPIC_ID'] == $topic){
										echo '<li class="active" style="background: #fff1f1;""><a href="?class='.$course_id.'&topic='.$row['TOPIC_ID'].'">'.$row['TITLE'].$icon.'</a></li>';
									}else{
										if(is_null($row['IS_NEW'])){ // NULL ISE
											$icon .= '<span style="background-color:#009688;">New</span>';
										}else if($row['IS_NEW']){
											$icon .= '<span style="background-color:#e91e63;">Unread</span>';
										}
										echo '<li><a href="?class='.$course_id.'&topic='.$row['TOPIC_ID'].'">'.$row['TITLE'].$icon.'</a></li>';
									}
	}
	function printTopics($array, $topic, $course_id){
		foreach($array as $row){
			printTopicTitle($row, $topic, $course_id);
		}
	}
?>