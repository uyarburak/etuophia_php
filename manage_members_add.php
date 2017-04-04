<?php
	if(isset($_POST['add_member_id'])){
		$enroll_type = $_POST['enroll_type'];
		$add_member_id = $_POST['add_member_id'];
		$add_course_id = $_POST['add_course_id'];
		$util -> addMemberToCourse($add_member_id, $add_course_id, $enroll_type);
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
			<div class="panel-heading green-bg">
				<h3 class="panel-title">Add List</h3>
				<ul class="pull-right toolbar"><li><a href="#" class="icon-button mini-max"><i class="icon-">&#xf0aa;</i></a></li></ul>
			</div>
			<div class="panel-body">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="student_table3">
					<thead><tr><th>Name</th><th>Student #</th><th>Mail</th><th>Gender</th><th>Year</th><th>Department</th><th>Actions</th></tr></thead>
					<tbody>
					<?php 
						$result = $util -> getStudentsNotInCourse($course_id);
						while($row = mysqli_fetch_assoc($result)){
							echo "<tr>";
							echo "<td>".$row['NAME']."</td>";
							echo "<td>".$row['STUDENT_ID']."</td>";
							echo "<td><a href ='mailto:".$row['MAIL']."' >".$row['MAIL']."</a></td>";
							echo "<td>".$row['SEX']."</td>";
							echo "<td>".$row['YEAR']."</td>";
							echo "<td>".$row['DEPARTMENT']."</td>";
							echo '<td><a onclick="addStudent('.$row['M_ID'].',\''.$row['NAME'].'\', 0)" role="button" class="btn btn-med blue-bg">+ Student</a>';
							if($row['YEAR'] > 4){
									echo '<a onclick="addStudent('.$row['M_ID'].',\''.$row['NAME'].'\', 1)" role="button" class="btn btn-med red-bg">+ Assistant</a>';
							}
							echo '</td>';
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
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      <h4 class="modal-title">Confirm enrollment</h4>
     </div>
     <div class="modal-body">
      Are you sure you want to enroll <span id="member_name">asd</span> to <?php echo $course_id; ?>?
     </div>
     <div class="modal-footer">
	  <form action="" method="POST" enctype="multipart/form-data" >
      <button type="button" class="btn gray-bg" data-dismiss="modal">Close</button>
		<input type="hidden" id="enroll_type" name="enroll_type" value="">
		<input type="hidden" name="add_course_id" value="<?php echo $course_id; ?>">
		<button type="submit" id="add_button" name="add_member_id" value="" type="button" class="btn green-bg">Enroll</button>
	  </form>
     </div>
    </div>
    <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  	    <script>

	function addStudent (member_id, member_name, enroll_type) {
		$("#add_button").val( member_id );
		$("#member_name").html( member_name );
		$("#enroll_type").val( enroll_type );
		$('#addModal').modal('show');
	}
  </script>