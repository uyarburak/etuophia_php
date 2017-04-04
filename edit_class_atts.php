<?php
	if(isset($_POST['syllabus_url'])){
		$syllabus = $_POST['syllabus_url'];
		$description = $_POST['description'];
		$util -> updateCourse($course_id, $syllabus, $description);
	}
	$course_info = $util -> getCourseInfo($course_id);
	$course_syllabus_url = $course_info['SYLLABUS'];
	$course_description = $course_info['DESCRIPTION'];
	$course_title = $course_info['COURSE_TITLE'];
	
?>
<section id="main_content">
	<div class="container-fluid">
		<div class="page-header">
		  <h1>Edit Course <?php echo $course_id;?><small><?php echo $course_title;?></small></h1>
		</div>
		<div class="row">
		 <div class="panel colored col-md-8">
		  <div class="panel-heading red-bg">
		   <h3 class="panel-title">Edit</h3>
		   <ul class="pull-right toolbar">
			<li><a href="#" class="icon-button"><i class="icon-">?</i></a></li>
			<li><a href="#" class="icon-button mini-max"><i class="icon-">?</i></a></li>
		   </ul>
		  </div>
		  <form class="form-horizontal" action="" method="POST" id="edit-course-validation">
		   <div class="panel-body">
			<div class="row">
			 <div class="col-md-12">
			  <div class="form-group">
			   <label class="control-label col-lg-2">Syllabus URL</label>
			   <div class="col-lg-10">
				<input type="text" name="syllabus_url" id="syllabus_url" class="form-control" value="<?php echo $course_syllabus_url; ?>"></input>
			   </div>
			  </div>
			 </div>
			</div>
			<div class="row">
			 <div class="col-md-12">
			  <div class="form-group">
			   <label class="control-label col-lg-2">Course Description</label>
			   <div class="col-lg-10">
			   <textarea id="description" name="description" class="form-control"><?php echo $course_description; ?></textarea>
			   </div>
			  </div>
			 </div>
			</div>
		   </div>
		   <div class="panel-footer">
			<div class="form-group">
			 <div class="col-lg-12">
			  <button type="submit" class="btn btn-sm btn-success">Submit Details</button>
			  <a href="#" class="btn gray-bg">Cancel</a>
			 </div>
			</div>
		   </div>
		  </form>
		 </div>	
		</div>
	  </div>
</section>