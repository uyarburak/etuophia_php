<?php
	$homework_info = $util -> getHomeworkInfo($hw_id);
	$deadline = new DateTime($homework_info['DEADLINE_TIME']);
	$is_lock = $homework_info['IS_LOCK'];
?>
<link rel="stylesheet" href="assets/css/icheck-skins/all.css" /> 
<section id="main_content"> 
 <div class="container-fluid"> 
  <div class="page-header"> 
   <h1>Manage Homework (<?php echo $homework_info['RESOURCE_TITLE']; ?>)</h1> 
  </div> 
  <div class="row">
       <div class="col-md-6">
      <div class="panel">
       <div class="panel-heading">
        <h3 class="panel-title">Information</h3>
        <ul class="pull-right toolbar">
         <li><a href="#" class="icon-button mini-max"><i class="icon-"></i></a></li>
        </ul>
       </div>
       <div class="panel-body">
	     <div class="invoice-details">
		  <div style="background:#f5f5f5;"><span>Academic: </span><strong><?php echo $homework_info['NAME']; ?></strong></div>
		  <div><span>Give Date: </span><strong><?php echo (new DateTime($homework_info['UPLOAD_TIME']))->format('d/m/Y - H:i'); ?></strong></div>
		  <div><span>Due Date: </span><strong><?php echo $deadline->format('d/m/Y - H:i'); ?></strong></div>
		  </div>
		         <div class="col-md-9">
			  <div class="panel">
			   <div class="panel-heading">
				<h3 class="panel-title">Extend Due Date</h3>
			   </div>
			   <div class="panel-body">
					<form action="update_homework_admin.php" method="POST" enctype="multipart/form-data" class="form-horizontal" id="homework-validation">
						<div class="form-group">
							 <label class="col-sm-3 control-label">New Due Date</label>
							 <div id="datetimepicker" class="col-lg-6">
							  <div class="input-group datetimepicker input-append date">
							   <input type="text" name="duedate" class="form-control" value="<?php echo $deadline->modify('+1 day')->format('d/m/Y - H:i');?>"><span class="input-group-addon add-on accordion-toggle"><i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-calendar"></i></span></input>
							  </div>
							 </div>
						</div>
						<div class="form-group">
						 <label class="col-sm-3 control-label"></label>
							 <div class="col-lg-6">
							 
						<label class="checkbox demotest"><input type="checkbox" class="icheck" data-skin="square" data-color="blue" name="auto_lock"> Auto Lock After Duedate </input></label>
							 </div>
						</div>
						<input type="hidden" name="return_url" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
						<input type="hidden" name="hw_id" value="<?php echo $hw_id; ?>">
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
						  <div class="col-sm-4 col-sm-offset-3">
							<button type="submit" class="btn btn-primary">Extend</button>
						  </div>
						</div>
                  </form>
					
				</div>
			  </div>
			 </div>
	        <div class="col-md-3">
			  <div class="panel">
			   <div class="panel-heading">
				<h3 class="panel-title">Freeze</h3>
			   </div>
			   <div class="panel-body">
					<form action="update_homework_admin.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
						<input type="hidden" name="return_url" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
						<input type="hidden" name="hw_id" value="<?php echo $hw_id; ?>">
						<div class="line line-dashed line-lg pull-in"></div>
						<div class="form-group">
						  <div class="col-sm-4 col-sm-offset-3">
							<?php 
								if($is_lock){
									echo '<button type="submit" name="unlock_button" class="btn btn-success">Unlock It</button>';
								}else{
									echo '<button type="submit" name="lock_button" class="btn btn-primary">Lock It</button>';
								}
							?>
						  </div>
						</div>
                  </form>
				</div>
			  </div>
			 </div>
		</div>
      </div>
     </div>
	 <div class="col-md-6">
      <div class="panel">
       <div class="panel-heading">
        <h3 class="panel-title">Stats</h3>
        <ul class="pull-right toolbar">
         <li><a href="#" class="icon-button"><i class="icon-"></i></a></li>
         <li><a href="#" class="icon-button reload-box"><i class="icon-"></i></a></li>
         <li><a href="#" class="icon-button mini-max"><i class="icon-"></i></a></li>
         <li><a href="#" class="icon-button close-box"><i class="icon-"></i></a></li>
        </ul>
       </div>
       <div class="panel-body">
			<div id="PieChart" style="width: 100%; height: 300px;"></div>
       </div>
      </div>
     </div> 
  </div>
  <div class="row"> 
   <div class="col-md-12">
    <div class="panel"> 
     <div class="panel-heading"> 
      <h3 class="panel-title">Assignment</h3> 
      <ul class="pull-right toolbar"> 
       <li><a href="#" class="icon-button mini-max"><i class="icon-"></i></a></li>
      </ul> 
     </div> 
     <div class="panel-body" id="flip-scroll"> 
      <table class="table table-striped"> 
       <thead> 
        <tr> 
         <th>Name</th>
         <th>Student #</th>
		 <th>Mail</th> 
		 <th>Department</th> 
         <th>Upload Date</th>
         <th>Resource</th> 
         <th>Status</th> 
        </tr> 
       </thead> 
       <tbody>
		<?php
			$done_in_time = 0;
			$done_late = 0;
			$not_done = 0;
			
			$result = $util -> getHomeworkResources($hw_id, $course_id);
			while($row = mysqli_fetch_assoc($result)){
					echo "<tr>";
					echo "<td>".$row['NAME']."</td>";
					echo "<td>".$row['STUDENT_ID']."</td>";
					echo "<td><a href ='mailto:".$row['MAIL']."' >".$row['MAIL']."</a></td>";
					echo "<td>".$row['DEPARTMENT']."</td>";
					if(empty($row['RESOURCE_ID'])){
						echo "<td>-</td>";
						echo '<td><i class="icon-ban-circle"></i></td>';
						echo "<td><span class='label label-danger'>Not Done</span></td>";
						$not_done++;
					}else{
						$upload_time = new DateTime($row['UPLOAD_TIME']);
						echo '<td>'.($upload_time->format('d/m/Y - H:i')).'</td>';
						echo '<td><a href="resource.php?id='.$row['RESOURCE_ID'].'" target="_blank" ><i class="icon-ok"></i> Show</a></td>';
						if($upload_time > $deadline){
							echo "<td><span class='label label-warning'>Late</span></td>";
							$done_late++;
						}else{
							echo "<td><span class='label label-success'>Success</span></td>";
							$done_in_time++;
						}
					}
					echo "</tr>";
			}
		?>
       </tbody> 
      </table> 
	  <a href="download_zip.php?hw_id=<?php echo $hw_id; ?>" class="btn btn-large green-bg pull-right">Download <?php echo $done_in_time + $done_late; ?> Homework</a>
     </div> 
    </div> 
   </div> 
  </div> 
 </div> 
</section>
<script src="assets/js/scripts.js"></script>
  <script src="assets/js/plugins/chartjs/globalize.min.js"></script>
  <script src="assets/js/plugins/chartjs/dx.chartjs.js"></script>
<script>
$(function (){

/**********************************
Pie Charts
**********************************/
var PieChartdataSource = [
    { country: "Done in Time", area: <?php echo $done_in_time; ?>},
    { country: "Done Late", area: <?php echo $done_late; ?>},
    { country: "Not Done", area: <?php echo $not_done; ?>}
];

$("#PieChart").dxPieChart({
    size:{ 
        width: 500
    },
    dataSource: PieChartdataSource,
    series: [
        {
            argumentField: "country",
            valueField: "area",
            label:{
                visible: true,
                connector:{
                    visible:true,           
                    width: 1
                }
            }
        }
    ]
});


});
</script>