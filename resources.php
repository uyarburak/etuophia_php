<section id="main_content">
  <div class="container-fluid">
    <div class="page-header">
      <h1>Resources
      <small>Resources and Homeworks</small></h1>
    </div>
    <div class="row">
		<?php
			$allResources = $util ->getAllResources($course_id);
			$resources = array(array(), array(), array(), array(), array());
			while($row = mysqli_fetch_assoc($allResources)){
				array_push($resources[$row['TYPE']], $row);
			}
			if($isAdmin){
				include("resources_admin.php");
			}else{
				include("resources_student.php");
			}
		?>
    </div>
  </div>
</section>