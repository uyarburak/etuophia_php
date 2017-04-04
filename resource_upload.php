<?php
   if(isset($_FILES['image']) && $res_type == $_POST['restype']){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
	  $zaa = explode('.',$file_name);
      $file_ext=strtolower(end($zaa));
      
      $expensions= array("jpeg","jpg","png","zip","rar","pdf","doc","docx","txt");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]='extension not allowed, please choose a "jpeg","jpg","png","zip","rar","pdf","doc","docx","txt" file.';
      }
      
      if($file_size > 10485760){
         $errors[]='File size must be less than 10 MB';
      }
	  $file_name_without_ext = $zaa[0];
      
      if(empty($errors)==true){
		$url = "uploads/".$file_name_without_ext."-".uniqid().".".$file_ext;
        move_uploaded_file($file_tmp,$url);
        echo "<br>Success<br>: http://etustalk.club/piazza/".$url;
		$util -> insertResource($file_name, $url, $member_id, $course_id, $_POST['restype']);
		redirect('index.php?class='.$course_id.'&page=resources');
      }else{
         print_r($errors);
      }
   }
?>

                <div class="col-lg-12">
				  <!-- .dropdown -->
                  <section class="panel panel-default pos-rlt clearfix">
                    <header class="panel-heading">
                      <ul class="nav nav-pills pull-right">
                        <li>
                          <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
                        </li>
                      </ul>
                      Upload Resources
                    </header>
                    <div class="panel-body clearfix">
						                  <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal" id="resource-validation">
                    
					<div class="form-group">
                      <label class="col-sm-2 control-label">File input</label>
                      <div class="col-sm-10">
					  <input type="file" name="image" class="styled col-lg-3" />
                      </div>
                    </div>
                    <div class="line line-dashed line-lg pull-in"></div>
                    <div class="form-group">
                      <div class="col-sm-4 col-sm-offset-2">
					  <input type="hidden" name="restype" value="<?php echo $res_type; ?>">
                        <button type="submit" class="btn btn-primary">Upload</button>
                      </div>
                    </div>
                  </form>
                      </div>
                    </div>
<!-- file input -->  
<script src="js/file-input/bootstrap-filestyle.min.js"></script>