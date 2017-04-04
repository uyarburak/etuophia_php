<?php
	$studentCount = $util -> getStudentCount($course_id);
	$adminCount = $util -> getAdminCount($course_id);
	$topicCount = $util -> getTopicCount($course_id);
	$commentCount = $util -> getCommentCount($course_id);
	$courseRow = $util -> getCourse($course_id);
	$course_description = $courseRow['DESCRIPTION'];
	$course_syllabus = $courseRow['SYLLABUS'];
	$course_title = $courseRow['COURSE_TITLE'];
?>
<section id="main_content">
  <div class="container-fluid">
    <div class="page-header">
      <h1><?php echo $course_id;?> <small><?php echo $course_title; ?></small></h1>
    </div>
	<br>
    <div class="row responsive-tab">
      <ul class="stats clearfix">
        <li class="col-md-3">
          <div class="blue-bg"><i class="icon-group"></i>
            <h5><?php echo $studentCount; ?> Students</h5>
           </div>
        </li>
        <li class="col-md-3">
          <div class="mehroon-bg"><i class="icon-user"></i>
            <h5><?php echo $adminCount; ?> Instructors & Assistants</h5>
          </div>
        </li>
        <li class="col-md-3">
          <div class="green-bg"><i class="icon-list"></i>
            <h5><?php echo $topicCount; ?> Topics</h5>
          </div>
        </li>
        <li class="col-md-3">
          <div class="yellow-bg"><i class="icon-comments"></i>
            <h5><?php echo $commentCount; ?> Comments</h5>
          </div>
        </li>
      </ul>
    </div>
	    <div class="row">
      <div class="panel col-md-12">
        <div class="panel-heading">
          <h3 class="panel-title">Course Description</h3>
        </div>
        <div class="panel-body stats_charts">
			<?php echo $course_description; ?>
		</div></div>
	  
      </div>
    <div class="row">
      <div class="panel col-md-8">
        <div class="panel-heading">
          <h3 class="panel-title">ETU Portal</h3>
        </div>
        <div class="panel-body stats_charts">
			<div id="demo2" class="carousel slide">
			<!-- Carousel items -->
			<div class="carousel-inner">
			<?php
				$result = $util ->getNews();
				$count = 0;
							while($row = mysqli_fetch_assoc($result)){
								if($count == 0){
									echo '<div class="active item"><a href="'.$row['URL'].'" target="_blank"><img style="display: block;margin: 0 auto;" src="'.$row['IMAGE_URL'].'" alt="" height="449px"><div class="carousel-caption"><h4>'.$row['TITLE'].'</h4><p>'.$row['SUMMARY'].'</p></div></a></div>';
									$count = -1;
								}else{
									echo '<div class="item"><a href="'.$row['URL'].'" target="_blank"><img style="display: block;margin: 0 auto;" src="'.$row['IMAGE_URL'].'" alt="" height="449px"><div class="carousel-caption"><h4>'.$row['TITLE'].'</h4><p>'.$row['SUMMARY'].'</p></div></a></div>';
								}
							}
			?>
			</div>
			<a class="left carousel-control" href="#demo2" data-slide="prev"><span class="icon-prev"></span></a><a class="right carousel-control" href="#demo2" data-slide="next"><span class="icon-next"></span></a></div>
		</div></div>
		      <div class="panel col-md-4">
	  <div class="panel-heading">
          <h3 class="panel-title">Syllabus</h3>
        </div>
        <div class="panel-body">
			<a href="<?php echo $course_syllabus; ?>" target="_blank" class="red-bg btn btn-med showcase-btn">Click to See</a>
		</div>
      </div>
      <div class="panel col-md-4">
	  <div class="panel-heading">
          <h3 class="panel-title">Upcoming Assigments</h3>
        </div>
        <div class="panel-body no-padding">
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 285px;"><ul class="feeds overflow-scroll visible-scroll" style="height: 285px; overflow: hidden; width: auto;">
            		  <?php
							$result = $util ->getHomeworksByDeadline($course_id);
							while($row = mysqli_fetch_assoc($result)){
								$date = new DateTime($row['DEADLINE_TIME']);
								$dateString = $date->format('d/m/Y');
								echo '<li><a href="resource.php?id='.$row['RESOURCE_ID'].'" target="_blank"><span class="blue-bg"><i class="icon-pushpin"></i></span>'.$row['RESOURCE_TITLE'].' ('.$dateString.')</a></li>';
							}
		  ?>
          </ul><div class="slimScrollBar ui-draggable" style="background: rgb(102, 102, 102); width: 4px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 4px; z-index: 99; right: 0px; height: 141.507px;"></div><div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 4px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 0px;"></div></div>
        </div>
      </div>
	  
      </div>
	<div class="row"><div class="col-md-12">
	       <div class="panel-body">
        <ul class="nav nav-tabs" id="myTab">
         <li><a data-toggle="tab" href="#staff">Staff</a></li>
         <li class="active"><a data-toggle="tab" href="#students">Students</a></li>
        </ul>
        <div class="tab-content" id="myTabContent">
         <div id="staff" class="tab-pane fade">
				  <div class="panel colored">
					<div class="panel-heading blue-bg">
						<h3 class="panel-title">Staff List</h3>
						<ul class="pull-right toolbar"><li><a href="#" class="icon-button mini-max"><i class="icon-">&#xf0aa;</i></a></li></ul>
					</div>
					<div class="panel-body">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
							<thead><tr><th>Type</th><th>Name</th><th>Mail</th><th>Office</th><th>Tel</th></tr></thead>
							<tbody>
							<?php 
								$result = $util -> getAdminsOfCourse($course_id);
								while($row = mysqli_fetch_assoc($result)){
									echo "<tr>";
									echo "<td>".$row['TYPE']."</td>";
									if(empty($row['WEBSITE'])){
										echo "<td>".$row['NAME']."</td>";
									}else{
										echo "<td><a target='_blank' href='".$row['WEBSITE']."'>".$row['NAME']."</a></td>";
									}
									echo "<td><a href ='mailto:".$row['MAIL']."' >".$row['MAIL']."</a></td>";
									echo "<td>".$row['OFFICE']."</td>";
									echo "<td>".$row['TEL']."</td>";
									echo "</tr>";
								}
							?>
							
							</tbody>
						</table>

					</div></div>          



		  </div>
         <div id="students" class="tab-pane fade in active">
          
				  <div class="panel colored">
					<div class="panel-heading blue-bg">
						<h3 class="panel-title">Student List</h3>
						<ul class="pull-right toolbar"><li><a href="#" class="icon-button mini-max"><i class="icon-">&#xf0aa;</i></a></li></ul>
					</div>
					<div class="panel-body">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="student_table2">
							<thead><tr><th>Name</th><th>Student #</th><th>Mail</th><th>Gender</th><th>Year</th><th>Department</th></tr></thead>
							<tbody>
							<?php 
								$result = $util -> getStudentsOfCourse($course_id);
								while($row = mysqli_fetch_assoc($result)){
									echo "<tr>";
									echo "<td>".$row['NAME']."</td>";
									echo "<td>".$row['STUDENT_ID']."</td>";
									echo "<td><a href ='mailto:".$row['MAIL']."' >".$row['MAIL']."</a></td>";
									echo "<td>".$row['SEX']."</td>";
									echo "<td>".$row['YEAR']."</td>";
									echo "<td>".$row['DEPARTMENT']."</td>";
									echo "</tr>";
								}
							?>
							
							</tbody>
						</table>

					</div></div>
		  </div>
        </div> 
       </div>
	
	</div>
	</div>
    </div>
  </div>
</section>