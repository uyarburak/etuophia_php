<?php
   if(isset($_FILES['homework'])){
      $errors= array();
      $file_name = $_FILES['homework']['name'];
      $file_size =$_FILES['homework']['size'];
      $file_tmp =$_FILES['homework']['tmp_name'];
      $file_type=$_FILES['homework']['type'];
	  $zaa = explode('.',$file_name);
      $file_ext=strtolower(end($zaa));
      
      $expensions= array("jpeg","jpg","png","zip","rar","pdf","doc","docx","txt");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 10485760){
         $errors[]='File size must be less than 10 MB';
      }
	  $file_name_without_ext = $zaa[0];
      
      if(empty($errors)==true){
		$url = "uploads/".$file_name_without_ext."-".uniqid().".".$file_ext;
        move_uploaded_file($file_tmp,$url);
        echo "<br>Success<br>: http://etustalk.club/piazza/".$url;
		$date = DateTime::createFromFormat('d/m/Y H:i:s', $_POST['duedate'].':00');
		$mysql_date_string = $date->format('Y-m-d H:i:s');
		if(isset($_POST['auto_lock'])){
			$lock_type = 2;
		}else{
			$lock_type = 0;
		}
		$util -> insertAssignHomework($file_name, $url, $member_id, $course_id, $mysql_date_string, $lock_type);
		redirect('index.php?class='.$course_id.'&page=resources');
      }else{
         print_r($errors);
      }
   }
?>
<link rel="stylesheet" href="assets/css/icheck-skins/all.css" /> 
                <div class="col-lg-12">
				  <!-- .dropdown -->
                  <section class="panel panel-default pos-rlt clearfix">
                    <header class="panel-heading">
                      <ul class="nav nav-pills pull-right">
                        <li>
                          <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
                        </li>
                      </ul>
                      Upload Homework
                    </header>
                    <div class="panel-body clearfix">
						                  <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal" id="homework-validation">
                    
					<div class="form-group">
                      <label class="col-sm-2 control-label">File input</label>
                      <div class="col-sm-10">
                        <input id="homework" name="homework" type="file" class="styled col-lg-3">
                      </div>
                    </div>
					<div class="form-group">
						 <label class="col-sm-2 control-label">Due Date</label>
						 <div id="datetimepicker" class="col-lg-4">
						  <div class="input-group datetimepicker input-append date">
						   <input type="text" name="duedate" class="form-control"><span class="input-group-addon add-on accordion-toggle"><i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-calendar"></i></span></input>
						  </div>
						 </div>
					</div>
					<div class="form-group">
						 <label class="col-sm-2 control-label"></label>
						 <div class="col-lg-4">
						 
					<label class="checkbox demotest"><input type="checkbox" class="icheck" data-skin="square" data-color="blue" name="auto_lock"> Auto Lock After Duedate </input></label>
						 </div>
					</div>
                    <div class="line line-dashed line-lg pull-in"></div>
                    <div class="form-group">
                      <div class="col-sm-4 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">Upload</button>
                      </div>
                    </div>
                  </form>
                      </div>
                    </div>
<!-- file input -->  
<script src="js/file-input/bootstrap-filestyle.min.js"></script>