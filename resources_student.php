      <div class="col-md-12">
        <div class="panel colored">
          <div class="panel-heading green-bg">
            <h3 class="panel-title">General Resources</h3>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
							<tr>
							  <th>Title</th>
							  <th>Upload Time</th>
							  <th>Uploader</th>
							</tr>
              </thead>
              <tbody>
				<?php
							foreach ($resources[0] as $row){
								echo '<tr>';
								echo '<td><a href="resource.php?id='.$row['RESOURCE_ID'].'" target="_blank">'.$row['RESOURCE_TITLE'].'</a></td>';
								echo '<td>'.$row['UPLOAD_TIME'].'</td>';
								echo '<td>'.$row['NAME'].'</td>';
								echo '</tr>';
							}
				?>
              </tbody>
            </table>
          </div>

        </div>

      </div>
	  
	  <div class="col-md-12">
        <div class="panel colored">
          <div class="panel-heading red-bg">
            <h3 class="panel-title">Homeworks</h3>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
							<tr>
							  <th>Title</th>
							  <th>Upload Time</th>
							  <th>Due Date</th>
							  <th>Uploader</th>
							  <th>Actions</th>
							</tr>
              </thead>
              <tbody>
				<?php
							$homeworks = $util -> getHomeworksWithMember($course_id, $member_id);
							
							while($row = mysqli_fetch_assoc($homeworks)){
								echo '<tr>';
								echo '<td><a href="resource.php?id='.$row['RESOURCE_ID'].'" target="_blank">'.$row['RESOURCE_TITLE'].'</a></td>';
								echo '<td>'.$row['UPLOAD_TIME'].'</td>';
								echo '<td>'.$row['DEADLINE_TIME'].'</td>';
								echo '<td>'.$row['NAME'].'</td>';
								if($row['IS_LOCK']){
									echo '<td>';
									if(!empty($row['STUDENT_HW_ID'])){
										echo '<a href="resource.php?id='.$row['STUDENT_HW_ID'].'" target="_blank" class="btn btn-med blue-bg"><i class="icon-search"></i></a>';
									}
									echo '<span class="label label-info">Locked</span></td>';
								}else{
									if(empty($row['STUDENT_HW_ID'])){
										echo '<td><a onclick="uploadHomework('.$row['HW_ID'].')" role="button" class="btn btn-med green-bg"><i class="icon-upload-alt"></i></a></td>';
									}else{
										echo '<td>
										<a href="resource.php?id='.$row['STUDENT_HW_ID'].'" target="_blank" class="btn btn-med blue-bg"><i class="icon-search"></i></a>
										<a onclick="uploadHomework('.$row['HW_ID'].')" role="button" class="btn btn-med orange-bg"><i class="icon-edit"></i></a>
										<a onclick="deleteResource('.$row['STUDENT_HW_ID'].')" role="button" class="btn btn-med red-bg"><i class="icon-trash"></i></a>
										</td>';
									}
								}
								echo '</tr>';
							}
				?>
              </tbody>
            </table>
          </div>

        </div>

      </div>
	  
	        <div class="col-md-12">
        <div class="panel colored">
          <div class="panel-heading blue-bg">
            <h3 class="panel-title">Lecture Notes</h3>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
							<tr>
							  <th>Title</th>
							  <th>Upload Time</th>
							  <th>Uploader</th>
							</tr>
              </thead>
              <tbody>
				<?php
							foreach ($resources[2] as $row){
								echo '<tr>';
								echo '<td><a href="resource.php?id='.$row['RESOURCE_ID'].'" target="_blank">'.$row['RESOURCE_TITLE'].'</a></td>';
								echo '<td>'.$row['UPLOAD_TIME'].'</td>';
								echo '<td>'.$row['NAME'].'</td>';
								echo '</tr>';
							}
				?>
              </tbody>
            </table>
          </div>

        </div>

      </div>
	  
	        <div class="col-md-12">
        <div class="panel colored">
          <div class="panel-heading orange-bg">
            <h3 class="panel-title">HW Solutions</h3>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
							<tr>
							  <th>Title</th>
							  <th>Upload Time</th>
							  <th>Uploader</th>
							</tr>
              </thead>
              <tbody>
				<?php
							foreach ($resources[3] as $row){
								echo '<tr>';
								echo '<td><a href="resource.php?id='.$row['RESOURCE_ID'].'" target="_blank">'.$row['RESOURCE_TITLE'].'</a></td>';
								echo '<td>'.$row['UPLOAD_TIME'].'</td>';
								echo '<td>'.$row['NAME'].'</td>';
								echo '</tr>';
							}
				?>
              </tbody>
            </table>
          </div>

        </div>

      </div>
	  
<!-- uploadHomework Modal -->
  <div class="modal fade" id="uploadHomeworkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      <h4 class="modal-title">Upload homework</h4>
     </div>
	 
	  <form action="upload_homework.php" method="POST" enctype="multipart/form-data" >
     <div class="modal-body">
      Choose File:
	  <input type="file" name="homework_file" class="styled col-lg-12" />
	  </div>
     <div class="modal-footer">
      <button type="button" class="btn gray-bg" data-dismiss="modal">Close</button>
		<input type="hidden" name="return_url" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
		<button type="submit" id="homework_id" name="hw_id" value="" type="button" class="btn blue-bg">Send Homework</button>
	  </form>
     </div>
    </div>
    <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  
<!-- deleteResource Modal -->
  <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      <h4 class="modal-title">Confirm deletion</h4>
     </div>
     <div class="modal-body">
      It will remove chosen resource!
     </div>
     <div class="modal-footer">
	  <form action="delete_resource.php" method="POST" enctype="multipart/form-data" >
      <button type="button" class="btn gray-bg" data-dismiss="modal">Close</button>
		<input type="hidden" name="return_url" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
		<button type="submit" id="delete_button" name="res_id" value="" type="button" class="btn blue-bg">Delete</button>
	  </form>
     </div>
    </div>
    <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
	  
	  
	    <script>
	function uploadHomework (hw_id) {
		$("#homework_id").val( hw_id );
		$('#uploadHomeworkModal').modal('show');
	}
	function deleteResource (res_id) {
		$("#delete_button").val( res_id );
		$('#confirmModal').modal('show');
	}
  </script>