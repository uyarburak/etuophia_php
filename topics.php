<?php
if(isset($_POST['comment_content'])){
	$comment_id = $util ->insertComment($_POST['comment_content'], $member_id, $topic, $_POST['parent_id'], $_POST['is_anonymous']);
	redirect('index.php?class='.$course_id.'&topic='.$topic);
}
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function display_comments($topic_id, $util, $parent_id='is null', $level=0) {
	global $member_id, $member_name, $isAdmin;
	$result = $util -> getComments($topic_id, $parent_id);
	while($comment = mysqli_fetch_assoc($result)){
        $comment_id = $comment['COMMENT_ID'];   
        $comment_member_id = $comment['MEMBER_ID'];
		$comment_member_name = $comment['NAME'];
		$member_image = $comment['IMAGE_URL'];
        $comment_text = $comment['CONTENT'];
        $comment_is_anonymous = $comment['IS_ANONYMOUS'];
        $comment_timestamp = time_elapsed_string($comment['COMMENT_TIME']);  //get time ago

        //render comment using above variables
        //Use $level to render the intendation level
		if(!$comment_is_anonymous || $isAdmin || ($comment_member_id == $member_id)){
			
			echo '<hr><div class="media"><a href="#" class="pull-left"><img src="';
			if(empty($member_image)){echo 'assets/images/user_pic/user.jpg';}else{echo $member_image;}
			echo '"></a><div class="media-body"><h5 class="media-heading">'.$comment_member_name;
			if($comment_is_anonymous && ($isAdmin || ($comment_member_id == $member_id))){
				echo ' (Anonymous)';
			}
			
		}else{
			echo '<hr><div class="media"><a href="#" class="pull-left"><img src="assets/images/user_pic/anonymous.jpg"></a><div class="media-body"><h5 class="media-heading">Anonymous';
		}
		
		echo ' <b onclick="myfunc2('.$comment_id.')" class="badge bg-info">Reply</b><small class="pull-right">'.$comment_timestamp.'</small></h5>'.$comment_text;
		if($isAdmin){
			echo '<a onclick="removeCommentAdmin('.$comment_id.')">Delete</a>';
		}else if($comment_member_id == $member_id){
			echo '<a onclick="removeCommentStudent('.$comment_id.')">Delete</a>';
		}
		echo '<form id="'.$comment_id.'" class="hide" style="display:none" action="" method="POST" enctype="multipart/form-data">

			<div class="form-group">
				<textarea rows="3" id="comment_content" name="comment_content"></textarea>
			</div>
			<div class="form-group">
			 <div class="col-lg-2">
			  <select name="is_anonymous" class="col-lg-12 chzn-nopadd chzn-select-no-single"><option value="0">'.$member_name.'</option> <option value="1">Anonymous to Students</option></select>
			 </div>
        </div>
			<input type="hidden" id="parent_id" name="parent_id" value="'.$comment_id.'">
			<button type="submit" class="btn btn-sm btn-success">Reply</button>
		   </form>';
		//Recurse
        display_comments($topic_id, $util, '= '.$comment_id, $level+1);                   
		echo '</div></div>';
    }
}
if($topic !=-1 && $util -> isThereTopic($course_id, $topic)){
	$util -> updateLastRead($member_id, $topic);
	$is_locked = $util -> isLocked($topic);
?>
<section id="main_content">
  <div class="container-fluid">
  <?php if($isAdmin){echo '<a href="#deleteTopicModal" role="button" data-toggle="modal">Delete Topic with all comments</a>';} ?>
    <div class="row">
      <div class="col-md-12">
	  <div class="panel colored"><div class="panel-heading black-bg"><h3 class="panel-title"><?php echo $topicTitle; ?></h3>
	  	     <p class="pull-right" style="color: #fff;">
            <span class="post-meta">
            <i class="icon-time"></i><?php echo time_elapsed_string($topicDate); ?></span>
            <span class="post-meta">
              <i class="icon-user"></i>
              <a href="#" style="color: #fff;"><?php echo $topicWriter; ?></a>
            </span>
          </p>
	  </div>
	  <div class="panel-body">
		<?php echo $topicContent; ?>
	  </div></div>
          <?php
			if(!$is_locked){
			?>
		  
            <h3>Comments</h3>
			<?php display_comments($topic, $util); ?>
           <hr>
		    <h3>Leave a Comment</h3>
		   <form action="" method="POST" enctype="multipart/form-data">

			<div class="form-group">
			<textarea name="comment_content"></textarea>
			<script>
                CKEDITOR.replaceAll();
            </script>
				
			</div>
		<div class="form-group">
			 <div class="col-lg-2">
			  <select name="is_anonymous" class="col-lg-12 chzn-nopadd chzn-select-no-single"><option value="0"><?php echo $member_name; ?></option> <option value="1">Anonymous to Students</option></select>
			 </div>
        </div>
			<input type="hidden" id="parent_id" name="parent_id" value="null">
			<button type="submit" class="btn btn-sm btn-success">Post Comment</button>
		   </form>
          <?php
			}else{
				echo '<div class="row"><div class="col-md-12"><div class="col-md-12 notification gray-bg"><strong>Locked Topic</strong> : No Comments Allowed </div></div></div>';
			}
			?>
    </div>
  </div>
  </div>
</section>

  <?php
	if($isAdmin){
  ?>
    <!-- deleteTopic Modal -->
  <div class="modal fade" id="deleteTopicModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      <h4 class="modal-title">Confirm deletion</h4>
     </div>
     <div class="modal-body">
      Are you sure?
     </div>
     <div class="modal-footer">
	  <form action="delete_topic.php" method="POST" enctype="multipart/form-data" >
      <button type="button" class="btn gray-bg" data-dismiss="modal">Close</button>
		<button type="submit" name="topic_id" value="<?php echo $topic;?>" type="button" class="btn red-bg">Delete Topic</button>
	  </form>
     </div>
    </div>
    <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <?php
  }
  ?>

  
  <!-- deleteCommentAdmin Modal -->
  <div class="modal fade" id="deleteCommentAdminModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      <h4 class="modal-title">Confirm deletion</h4>
     </div>
     <div class="modal-body">
      Which way to delete?
     </div>
     <div class="modal-footer">
	  <form action="delete_comment.php" method="POST" enctype="multipart/form-data" >
      <button type="button" class="btn gray-bg" data-dismiss="modal">Close</button>
		<input type="hidden" name="return_url" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
		<input type="hidden" id="delete_comment_id" name="delete_comment_id" value="">
		<button type="submit" type="button" class="btn blue-bg">Remove Content</button>
		<button type="submit" name="delete_complete" value="1" type="button" class="btn red-bg">Delete Complete</button>
	  </form>
     </div>
    </div>
    <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  
  <!-- deleteCommentStudent Modal -->
  <div class="modal fade" id="deleteCommentStudentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      <h4 class="modal-title">Confirm deletion</h4>
     </div>
     <div class="modal-body">
      Are you sure?
     </div>
     <div class="modal-footer">
	  <form action="delete_comment.php" method="POST" enctype="multipart/form-data" >
      <button type="button" class="btn gray-bg" data-dismiss="modal">Close</button>
		<input type="hidden" name="return_url" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
		<input type="hidden" id="delete_comment_id_2" name="delete_comment_id" value="">
		<button type="submit" type="button" class="btn blue-bg">Remove Content</button>
	  </form>
     </div>
    </div>
    <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
	  
	  
	    <script>
	function removeCommentAdmin (comment_id) {
		$("#delete_comment_id").val( comment_id );
		$('#deleteCommentAdminModal').modal('show');
	}
	function removeCommentStudent (comment_id) {
		$("#delete_comment_id_2").val( comment_id );
		$('#deleteCommentStudentModal').modal('show');
	}
  </script>
  

<?php
}else{
	include("dashboard.php");
}
?>
