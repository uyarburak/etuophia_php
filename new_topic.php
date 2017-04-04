<?php
	if(isset($_POST['topic_title'])){
		if(isset($_POST['not_locked'])){
			$topic_id = $util ->insertTopic($_POST['topic_title'], $_POST['content'], $member_id, $course_id, 0);
		}else{
			$topic_id = $util ->insertTopic($_POST['topic_title'], $_POST['content'], $member_id, $course_id, 1);
		}
		redirect("?class=".$course_id."&topic=".$topic_id);
	}
?>
<section id="main_content">
  <div class="container-fluid">
    <ol class="breadcrumb">
      <li>
        <a href="index.php">Home</a>
      </li>
      <li>New Topic</li>
    </ol>
    <div class="row">
      <div class="col-md-12">
                    <div class="panel-body">
                      <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                          <label>Title</label>
                          <input id="topic_title" name="topic_title" type="text" class="form-control" placeholder="Enter title">
                        </div>
						<div class="form-group">
                          <label class="checkbox"><input type="checkbox" checked="" name="not_locked"> Allow Comments </label>
                        </div>
                        <div class="form-group">
                          <label>Content</label>
                          <textarea id="content" name="content"></textarea>
						<script>
							CKEDITOR.replace('content');
						</script>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success">Submit</button>
                      </form>
                    </div>
    </div>
  </div>
  </div>
</section>