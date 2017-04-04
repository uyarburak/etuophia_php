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
							  <th>Actions</th>
							</tr>
              </thead>
              <tbody>
				<?php
							$res_type = 0;
							foreach ($resources[$res_type] as $row){
								echo '<tr>';
								echo '<td><a href="resource.php?id='.$row['RESOURCE_ID'].'" target="_blank">'.$row['RESOURCE_TITLE'].'</a></td>';
								echo '<td>'.$row['UPLOAD_TIME'].'</td>';
								echo '<td>'.$row['NAME'].'</td>';
								echo '<td>
								<a onclick="changeType('.$row['RESOURCE_ID'].', '.$res_type.')" role="button" class="btn btn-med green-bg"><i class="icon-exchange"></i></a>
								<a onclick="deleteResource('.$row['RESOURCE_ID'].')" role="button" class="btn btn-med red-bg"><i class="icon-trash"></i></a>
								</td>';
								echo '</tr>';
							}
				?>
              </tbody>
            </table>
			<?php
				include("resource_upload.php");
			?>
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
							</tr>
              </thead>
              <tbody>
				<?php
							$res_type = 1;
							foreach ($resources[$res_type] as $row){
								echo '<tr>';
								echo '<td><a href="resource.php?id='.$row['RESOURCE_ID'].'" target="_blank">'.$row['RESOURCE_TITLE'].'</a></td>';
								echo '<td>'.(new DateTime($row['UPLOAD_TIME']))->format('d/m/Y - H:i').'</td>';
								echo '<td>'.(new DateTime($row['DEADLINE_TIME']))->format('d/m/Y - H:i').'</td>';
								echo '<td>'.$row['NAME'].'</td>';
								echo '</tr>';
							}
				?>
              </tbody>
            </table>
			<?php
				include("homework_upload.php");
			?>
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
							  <th>Actions</th>
							</tr>
              </thead>
              <tbody>
				<?php
							$res_type = 2;
							foreach ($resources[$res_type] as $row){
								echo '<tr>';
								echo '<td><a href="resource.php?id='.$row['RESOURCE_ID'].'" target="_blank">'.$row['RESOURCE_TITLE'].'</a></td>';
								echo '<td>'.$row['UPLOAD_TIME'].'</td>';
								echo '<td>'.$row['NAME'].'</td>';
								echo '<td>
								<a onclick="changeType('.$row['RESOURCE_ID'].', '.$res_type.')" role="button" class="btn btn-med green-bg"><i class="icon-exchange"></i></a>
								<a onclick="deleteResource('.$row['RESOURCE_ID'].')" role="button" class="btn btn-med red-bg"><i class="icon-trash"></i></a>
								</td>';
								echo '</tr>';
							}
				?>
              </tbody>
            </table>
			<?php
				include("resource_upload.php");
			?>
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
							  <th>Actions</th>
							</tr>
              </thead>
              <tbody>
				<?php
							$res_type = 3;
							foreach ($resources[$res_type] as $row){
								echo '<tr>';
								echo '<td><a href="resource.php?id='.$row['RESOURCE_ID'].'" target="_blank">'.$row['RESOURCE_TITLE'].'</a></td>';
								echo '<td>'.$row['UPLOAD_TIME'].'</td>';
								echo '<td>'.$row['NAME'].'</td>';
								echo '<td>
								<a onclick="changeType('.$row['RESOURCE_ID'].', '.$res_type.')" role="button" class="btn btn-med green-bg"><i class="icon-exchange"></i></a>
								<a onclick="deleteResource('.$row['RESOURCE_ID'].')" role="button" class="btn btn-med red-bg"><i class="icon-trash"></i></a>
								</td>';
								echo '</tr>';
							}
				?>
              </tbody>
            </table>
			<?php
				include("resource_upload.php");
			?>
          </div>

        </div>

      </div>
	  
	  	        <div class="col-md-12">
        <div class="panel colored">
          <div class="panel-heading black-bg">
            <h3 class="panel-title">Unlisted Resources (Only Admins can see)</h3>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
							<tr>
							  <th>Title</th>
							  <th>Upload Time</th>
							  <th>Uploader</th>
							  <th>Actions</th>
							</tr>
              </thead>
              <tbody>
				<?php
							$res_type = 4;
							foreach ($resources[$res_type] as $row){
								echo '<tr>';
								echo '<td><a href="resource.php?id='.$row['RESOURCE_ID'].'" target="_blank">'.$row['RESOURCE_TITLE'].'</a></td>';
								echo '<td>'.$row['UPLOAD_TIME'].'</td>';
								echo '<td>'.$row['NAME'].'</td>';
								echo '<td>
								<a onclick="changeType('.$row['RESOURCE_ID'].', '.$res_type.')" role="button" class="btn btn-med green-bg"><i class="icon-exchange"></i></a>
								<a onclick="deleteResource('.$row['RESOURCE_ID'].')" role="button" class="btn btn-med red-bg"><i class="icon-trash"></i></a>
								</td>';
								echo '</tr>';
							}
				?>
              </tbody>
            </table>
			<?php
				include("resource_upload.php");
			?>
          </div>

        </div>

      </div>
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
  
  <!-- changeType Modal -->
  <div class="modal fade" id="changeTypeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      <h4 class="modal-title">Resource Type Changing</h4>
     </div>
	 
	  <form action="change_resource_type.php" method="POST" enctype="multipart/form-data" >
     <div class="modal-body">
	 New Type:
	  <select class="form-control" id="new_res_type" name="new_res_type"><option value="0" >General Resource</option> <option value="2">Lecture Note</option> <option value="3">HW Solution</option><option value="4">Unlisted</option></select>
     </div>
     <div class="modal-footer">
      <button type="button" class="btn gray-bg" data-dismiss="modal">Close</button>
		<input type="hidden" name="return_url" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
		<button type="submit" id="change_button" name="res_id" value="" type="button" class="btn blue-bg">Change Type</button>
	  </form>
     </div>
    </div>
    <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <script>
	function deleteResource (res_id) {
		$("#delete_button").val( res_id );
		$('#confirmModal').modal('show');
	}
	function changeType (res_id, res_type) {
		$("#change_button").val( res_id );
		$("#new_res_type").val( res_type );
		$('#changeTypeModal').modal('show');
	}
  </script>