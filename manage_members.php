<?php
	if(isset($_POST['remove_member_id'])){
		$remove_member_id = $_POST['remove_member_id'];
		$remove_course_id = $_POST['remove_course_id'];
		$util -> removeMemberFromCourse($remove_member_id, $remove_course_id);
	}
?>
<section id="main_content">
  <div class="container-fluid">
    <div class="page-header">
      <h1>Members
      <small>Add and Remove Students and Assistants</small></h1>
    </div>
    <div class="row">
	  <div class="col-md-12">
		<div class="panel colored">
			<div class="panel-heading blue-bg">
				<h3 class="panel-title">Enroll Student List</h3>
				<ul class="pull-right toolbar"><li><a href="#" class="icon-button mini-max"><i class="icon-">&#xf0aa;</i></a></li></ul>
			</div>
			<div class="panel-body">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="student_table">
					<thead><tr><th>Name</th><th>Student #</th><th>Mail</th><th>Gender</th><th>Year</th><th>Department</th><th>Remove</th></tr></thead>
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
							echo '<td><a onclick="removeStudent('.$row['M_ID'].',\''.$row['NAME'].'\')" role="button" class="btn btn-med red-bg"><i class="icon-trash"></i></a></td>';
							echo "</tr>";
						}
					?>
					
					</tbody>
				</table>

			</div></div>

      </div>
	  
	  <div class="col-md-12">
		<div class="panel colored">
			<div class="panel-heading red-bg">
				<h3 class="panel-title">Assistant List</h3>
				<ul class="pull-right toolbar"><li><a href="#" class="icon-button mini-max"><i class="icon-">&#xf0aa;</i></a></li></ul>
			</div>
			<div class="panel-body">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="student_table">
					<thead><tr><th>Name</th><th>Student #</th><th>Mail</th><th>Gender</th><th>Year</th><th>Department</th><th>Remove</th></tr></thead>
					<tbody>
					<?php 
						$result = $util -> getAssistantsOfCourse($course_id);
						while($row = mysqli_fetch_assoc($result)){
							echo "<tr>";
							echo "<td>".$row['NAME']."</td>";
							echo "<td>".$row['STUDENT_ID']."</td>";
							echo "<td><a href ='mailto:".$row['MAIL']."' >".$row['MAIL']."</a></td>";
							echo "<td>".$row['SEX']."</td>";
							echo "<td>".$row['YEAR']."</td>";
							echo "<td>".$row['DEPARTMENT']."</td>";
							echo '<td><a onclick="removeStudent('.$row['M_ID'].',\''.$row['NAME'].'\')" role="button" class="btn btn-med red-bg"><i class="icon-trash"></i></a></td>';
							echo "</tr>";
						}
					?>
					
					</tbody>
				</table>

			</div></div>

      </div>
	  </div>
  </div>
</section>

  <!-- deleteResource Modal -->
  <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      <h4 class="modal-title">Confirm removing</h4>
     </div>
     <div class="modal-body">
      Are you sure you want to remove <span id="remove_member_name">asd</span> from <?php echo $course_id; ?>?
     </div>
     <div class="modal-footer">
	  <form action="" method="POST" enctype="multipart/form-data" >
      <button type="button" class="btn gray-bg" data-dismiss="modal">Close</button>
		<input type="hidden" name="remove_course_id" value="<?php echo $course_id; ?>">
		<button type="submit" id="remove_button" name="remove_member_id" value="" type="button" class="btn red-bg">Remove</button>
	  </form>
     </div>
    </div>
    <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  	    <script>
	function removeStudent (member_id, member_name) {
		$("#remove_button").val( member_id );
		$("#remove_member_name").html( member_name );
		$('#removeModal').modal('show');
	}
  </script>