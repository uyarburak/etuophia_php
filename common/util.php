<?php
	class Util {
		protected static $connection;
		function __construct() {
			// include db connect class
			require_once __DIR__ . '/db_connect.php';
			// connecting to db
			self::$connection = new DB();
		}
		function getComments($topic_id, $parent_id){
			$result = self::$connection -> query("select c.COMMENT_ID, c.CONTENT, c.COMMENT_TIME, c.MEMBER_ID, c.IS_ANONYMOUS, m.NAME, m.IMAGE_URL FROM comment c INNER JOIN member m ON c.MEMBER_ID = m.M_ID WHERE TOPIC_ID = $topic_id AND PARENT_ID $parent_id"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function hasAccess($res_id, $member_id){
			$result = self::$connection -> query("select count(*) AS COUNT, c.URL from enrollment e, (select COURSE_ID, URL from resource where RESOURCE_ID = $res_id) c where c.COURSE_ID = e.COURSE_ID AND e.MEMBER_ID = $member_id"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			$row = mysqli_fetch_assoc($result);
			return $row;
		}
		function getCourses($member_id, $sinif){
			$result = self::$connection -> query("SELECT COURSE_ID FROM enrollment where MEMBER_ID = $member_id order by COURSE_ID"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getCoursesAdmin($member_id, $sinif){
			$result = self::$connection -> query("SELECT COURSE_ID FROM enrollment where MEMBER_ID = $member_id and IS_ADMIN order by COURSE_ID"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getCourse($course_id){
			$result = self::$connection -> query("SELECT SYLLABUS, DESCRIPTION, COURSE_TITLE FROM course where COURSE_CODE = '$course_id'"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return mysqli_fetch_assoc($result);
		}
		function getFirstCourse($member_id){
			$result = self::$connection -> query("SELECT min(COURSE_ID) as COURSE FROM enrollment where MEMBER_ID = $member_id order by COURSE_ID");
			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return mysqli_fetch_assoc($result)['COURSE'];
		}
		function getNews(){
			$result = self::$connection -> query("SELECT URL, IMAGE_URL, TITLE, SUMMARY FROM news where IS_ACTIVE order by NEWS_ID DESC"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getStudentsOfCourse($course_id){
			$result = self::$connection -> query("SELECT s.M_ID, m.SEX, m.MAIL, m.NAME, s.STUDENT_ID, s.DEPARTMENT, s.YEAR FROM member m, student s, enrollment e where e.IS_ADMIN = false and e.COURSE_ID = '$course_id' and e.MEMBER_ID = m.M_ID and m.M_ID = s.M_ID order by m.NAME"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getAdminsOfCourse($course_id){
			$result = self::$connection -> query("select m.NAME, m.MAIL, i.OFFICE, i.TEL, i.WEBSITE, case when i.M_ID IS NULL THEN 'Assistant' else 'Instructor' end as TYPE from enrollment e, member m left join instructor i on i.M_ID = m.M_ID where e.COURSE_ID = '$course_id' and e.IS_ADMIN and e.MEMBER_ID = m.M_ID ORDER BY TYPE DESC, NAME"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getStudentsNotInCourse($course_id){
			$result = self::$connection -> query("SELECT s.M_ID, m.SEX, m.MAIL, m.NAME, s.STUDENT_ID, s.DEPARTMENT, s.YEAR
FROM student s, member m  where s.M_ID NOT IN (select ss.M_ID from student ss, enrollment e where e.MEMBER_ID = ss.M_ID and e.COURSE_ID = '$course_id')
and m.M_ID = s.M_ID order by m.NAME");
			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getAssistantsOfCourse($course_id){
			$result = self::$connection -> query("SELECT s.M_ID, m.NAME, m.IMAGE_URL, m.SEX, s.STUDENT_ID, s.YEAR, s.DEPARTMENT, m.MAIL FROM enrollment e, member m inner join student s on (s.M_ID = m.M_ID) WHERE e.MEMBER_ID = m.M_ID and e.IS_ADMIN and e.COURSE_ID = '$course_id' order by m.NAME"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function updateLastRead($member_id, $topic_id){
			$result = self::$connection -> query("INSERT INTO read_history (MEMBER_ID, TOPIC_ID, LAST_READ) VALUES($member_id, $topic_id, NOW()) ON DUPLICATE KEY UPDATE LAST_READ=NOW()");
		}
		function getTopics($course_id, $member_id){
			$result = self::$connection -> query("SELECT t.TOPIC_ID, t.TITLE, t.CREATE_TIME, t.MEMBER_ID, e.IS_ADMIN, r.LAST_READ < t.LAST_MODIFIED as IS_NEW FROM topic t LEFT JOIN read_history r ON r.MEMBER_ID = $member_id AND r.TOPIC_ID = t.TOPIC_ID LEFT JOIN enrollment e ON e.COURSE_ID = t.COURSE_ID  AND e.MEMBER_ID = t.MEMBER_ID where t.COURSE_ID = '$course_id' order by t.CREATE_TIME desc"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}

		function getGeneralResources($course_id){
			$result = self::$connection -> query("SELECT r.RESOURCE_ID, r.RESOURCE_TITLE, r.URL, r.UPLOAD_TIME, m.NAME FROM resource r INNER JOIN member m ON r.MEMBER_ID = m.M_ID where r.COURSE_ID = '$course_id' AND r.TYPE = 0 order by r.UPLOAD_TIME"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getResource($res_id){
			$result = self::$connection -> query("SELECT r.RESOURCE_ID, r.RESOURCE_TITLE, r.URL, r.UPLOAD_TIME, m.NAME FROM resource r INNER JOIN member m ON r.MEMBER_ID = m.M_ID where r.RESOURCE_ID = $res_id"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			$row = mysqli_fetch_assoc($result); 
			return $row;
		}
		function getAllResources($course_id){
			$result = self::$connection -> query("SELECT r.RESOURCE_ID,r.TYPE, r.RESOURCE_TITLE, r.URL, r.UPLOAD_TIME, m.NAME, h.DEADLINE_TIME FROM resource r INNER JOIN member m ON r.MEMBER_ID = m.M_ID LEFT JOIN homework h on r.resource_id  = h.resource_id where r.COURSE_ID = '$course_id' AND r.TYPE != 5 order by r.UPLOAD_TIME"); 
			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getHomeworks($sinif){
			$result = self::$connection -> query("SELECT r.RESOURCE_ID, r.RESOURCE_TITLE, r.URL, r.UPLOAD_TIME, m.NAME, h.DEADLINE_TIME FROM homework h, resource r INNER JOIN member m ON r.MEMBER_ID = m.M_ID where r.COURSE_ID = '$sinif' AND r.TYPE = 1 and r.resource_id  = h.resource_id order by r.UPLOAD_TIME"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getHomeworksByDeadline($sinif){
			$result = self::$connection -> query("SELECT r.RESOURCE_ID, r.RESOURCE_TITLE, r.URL, r.UPLOAD_TIME, m.NAME, h.DEADLINE_TIME FROM homework h, resource r INNER JOIN member m ON r.MEMBER_ID = m.M_ID where r.COURSE_ID = '$sinif' AND r.TYPE = 1 and h.DEADLINE_TIME >= CURDATE() AND  r.resource_id  = h.resource_id order by h.DEADLINE_TIME"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getAllMembers(){
			$result = self::$connection -> query("SELECT M_ID, NAME FROM member order by NAME"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getMemberInfo($member_id, $course_id){
			$result = self::$connection -> query("SELECT m.NAME, m.IMAGE_URL, m.SEX, m.MAIL, e.IS_ADMIN, CASE WHEN s.STUDENT_ID IS NOT NULL THEN 0 ELSE 1 END AS ins FROM enrollment e, member m left join student s on (s.M_ID = m.M_ID) WHERE e.MEMBER_ID = m.M_ID and  m.M_ID = $member_id and  e.COURSE_ID = '$course_id'"); 
			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			$row = mysqli_fetch_assoc($result);
			return $row;
		}
		function getInstructorInfo($member_id){
			$result = self::$connection -> query("SELECT i.WEBSITE, i.OFFICE, i.TEL FROM instructor i WHERE i.M_ID = $member_id"); 
			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return mysqli_fetch_assoc($result);
		}
		function getCourseInfo($course_id){
			$result = self::$connection -> query("SELECT COURSE_TITLE, DESCRIPTION, SYLLABUS FROM course WHERE COURSE_CODE = '$course_id'"); 
			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return mysqli_fetch_assoc($result);
		}
		function isAdmin($course_id, $member_id){
			$result = self::$connection -> query("SELECT IS_ADMIN FROM enrollment WHERE MEMBER_ID = $member_id AND COURSE_ID = '$course_id'"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['IS_ADMIN'];
		}
		function getTopic($topic_id){
			$result = self::$connection -> query("SELECT t.TOPIC_ID, t.TITLE, t.CONTENT, t.CREATE_TIME, t.MEMBER_ID, m.NAME FROM topic t INNER JOIN member m ON t.MEMBER_ID = m.m_ID where t.TOPIC_ID = $topic_id"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return mysqli_fetch_assoc($result);
		}
		function hasEnrollment($member_id, $course_id){
			$result = self::$connection -> query("SELECT IS_ADMIN FROM enrollment WHERE MEMBER_ID = $member_id AND COURSE_ID = '$course_id'"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return ($result->num_rows > 0); 
		}
		function getLastTopic($topic_title){
			$result = self::$connection -> query("SELECT max(TOPIC_ID) FROM TOPIC where TITLE = '$topic_title'"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			$row = mysqli_fetch_assoc($result);
		}
		function getStudentCount($course_id){
			$result = self::$connection -> query("SELECT count(*) as CNT FROM enrollment where IS_ADMIN = false and COURSE_ID = '$course_id'"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['CNT'];
		}
		function getAdminCount($course_id){
			$result = self::$connection -> query("SELECT count(*) as CNT FROM enrollment where IS_ADMIN and COURSE_ID = '$course_id'"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['CNT'];
		}
		function getTopicCount($course_id){
			$result = self::$connection -> query("SELECT count(*) as CNT FROM topic where COURSE_ID = '$course_id'"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['CNT'];
		}
		function getCommentCount($course_id){
			$result = self::$connection -> query("SELECT count(c.COMMENT_ID) as CNT FROM topic t, comment c where t.TOPIC_ID = c.TOPIC_ID and t.COURSE_ID = '$course_id'"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			$row = mysqli_fetch_assoc($result);
			return $row['CNT'];
		}
		function insertTopic($topic_title, $topic_content, $member_id, $course_id, $is_locked){
			self::$connection -> query("INSERT INTO topic (TOPIC_ID,CONTENT,CREATE_TIME,TITLE,IS_LOCKED, COURSE_ID,MEMBER_ID) VALUES (null,'$topic_content',NOW(),'$topic_title', $is_locked, '$course_id', $member_id)"); 
			return self::$connection -> getInsertId();
		}
		function addMemberToCourse($add_member_id, $add_course_id, $enroll_type){
			self::$connection -> query("INSERT INTO enrollment (MEMBER_ID,COURSE_ID,IS_ADMIN) VALUES ($add_member_id,'$add_course_id',$enroll_type)");
			return self::$connection -> getInsertId();
		}
		function removeMemberFromCourse($remove_member_id, $remove_course_id){
			self::$connection -> query("DELETE FROM enrollment WHERE MEMBER_ID = $remove_member_id and COURSE_ID = '$remove_course_id'");
		}
		function insertComment($comment_content, $member_id, $topic_id, $parent_id, $is_anonymous){
			self::$connection -> query("INSERT INTO comment (COMMENT_ID,CONTENT,COMMENT_TIME,TOPIC_ID,PARENT_ID,MEMBER_ID, IS_ANONYMOUS) VALUES (null,'$comment_content',NOW(),$topic_id,$parent_id,$member_id, $is_anonymous)"); 
			return self::$connection -> getInsertId();
		}
		function insertResource($resource_title, $url, $member_id, $course_id, $type){
			$isAdmin = self::isAdmin($course_id, $member_id);
			if($isAdmin != 0){
				self::$connection -> query("INSERT INTO resource (RESOURCE_ID,RESOURCE_TITLE, UPLOAD_TIME,URL,COURSE_ID,MEMBER_ID, TYPE) VALUES (null,'$resource_title',NOW(),'$url','$course_id',$member_id, $type)"); 
				return self::$connection -> getInsertId();
			}
		}
		function insertStudentHomework($resource_title, $url, $member_id, $course_id, $hw_id){
			self::$connection -> query("INSERT INTO resource (RESOURCE_ID,RESOURCE_TITLE, UPLOAD_TIME,URL,COURSE_ID,MEMBER_ID, TYPE, COMMITTED_HW_ID) VALUES (null,'$resource_title',NOW(),'$url','$course_id',$member_id, 5, $hw_id)"); 
		}
		function insertAssignHomework($resource_title, $url, $member_id, $course_id, $deadline, $lock_type){
			$isAdmin = self::isAdmin($course_id, $member_id);
			if($isAdmin != 0){
				self::$connection -> query("INSERT INTO resource (RESOURCE_ID,RESOURCE_TITLE, UPLOAD_TIME,URL,COURSE_ID,MEMBER_ID, TYPE) VALUES (null,'$resource_title',NOW(),'$url','$course_id',$member_id, 1)"); 
				$res_id = self::$connection -> getInsertId();
				self::$connection -> query("INSERT INTO homework (HW_ID, RESOURCE_ID,DEADLINE_TIME,LOCK_TYPE) VALUES (null,$res_id, '$deadline', $lock_type)");
			}
		}
		function extendDueDateHomework($hw_id, $duedate, $lock_type){
			$result = self::$connection -> query("UPDATE homework SET DEADLINE_TIME='$duedate', LOCK_TYPE=$lock_type WHERE HW_ID = $hw_id");
		}
		function changeLockType($hw_id, $lock_type){
			$result = self::$connection -> query("UPDATE homework SET LOCK_TYPE=$lock_type WHERE HW_ID = $hw_id");
		}
		function isLocked($topic_id){
			$result = self::$connection -> query("SELECT IS_LOCKED from topic where TOPIC_ID = $topic_id"); 
			return mysqli_fetch_assoc($result)['IS_LOCKED'];
			
		}
		function updateMember($id, $email, $image_url){
			$result = self::$connection -> query("UPDATE member SET MAIL='$email', IMAGE_URL='$image_url' WHERE M_ID = $id");
		}
		function updateInstructor($id, $office, $tel, $website){
			$result = self::$connection -> query("UPDATE instructor SET OFFICE='$office', WEBSITE='$website', TEL='$tel' WHERE M_ID = $id");
		}
		function updateCourse($course_id, $syllabus, $description){
			$result = self::$connection -> query("UPDATE course SET SYLLABUS='$syllabus', DESCRIPTION='$description' WHERE COURSE_CODE = '$course_id'");
			echo "UPDATE course SET SYLLABUS='$syllabus', DESCRIPTION='$description' WHERE COURSE_CODE = '$course_id'";
		}
		function updatePassword($id, $new_password){
			$result = self::$connection -> query("UPDATE member SET PASSWORD='$new_password' WHERE M_ID = $id");
		}
		function getPassword($id){
			$result = self::$connection -> query("SELECT PASSWORD FROM member WHERE M_ID = $id");
			return mysqli_fetch_assoc($result)['PASSWORD'];
		}
		function getPasswordMail($mail){
			$result = self::$connection -> query("SELECT M_ID, PASSWORD FROM member WHERE MAIL = '$mail'");
			return $result;
		}
		function deleteResource($res_id){
			$result = self::$connection -> query("SELECT URL FROM resource WHERE RESOURCE_ID = $res_id");
			$file_url = mysqli_fetch_assoc($result)['URL'];
			$result = self::$connection -> query("DELETE FROM resource WHERE RESOURCE_ID = $res_id");
			return $file_url;
		}
		function deleteComment($comment_id){
			$result = self::$connection -> query("DELETE FROM comment WHERE COMMENT_ID = $comment_id");
		}
		function deleteTopic($topic_id){
			$result = self::$connection -> query("DELETE FROM topic WHERE TOPIC_ID = $topic_id");
		}
		function removeCommentContent($comment_id){
			$result = self::$connection -> query("UPDATE comment SET CONTENT = '<p>The content of this comment has removed.</p>' WHERE COMMENT_ID = $comment_id");
		}
		function changeResourceType($res_id, $new_res_type){
			$result = self::$connection -> query("UPDATE resource SET TYPE=$new_res_type WHERE RESOURCE_ID = $res_id");
		}
		function isResourceOwner($member_id, $res_id){
			$result = self::$connection -> query("SELECT RESOURCE_ID FROM resource WHERE RESOURCE_ID = $res_id and MEMBER_ID = $member_id");
			return $result->num_rows;
		}
		function isCommentOwner($member_id, $comment_id){
			$result = self::$connection -> query("SELECT COMMENT_ID FROM comment WHERE COMMENT_ID = $comment_id and MEMBER_ID = $member_id");
			return $result->num_rows;
		}
		function getHomeworksWithMember($course_id, $member_id){
			$result = self::$connection -> query("SELECT r.RESOURCE_ID, r.RESOURCE_TITLE, r.URL, r.UPLOAD_TIME, m.NAME, h.DEADLINE_TIME, h.HW_ID, s.RESOURCE_ID as STUDENT_HW_ID, CASE WHEN h.LOCK_TYPE = 2 THEN NOW() >  h.DEADLINE_TIME ELSE h.LOCK_TYPE = 1 END AS IS_LOCK FROM homework h LEFT JOIN resource s ON s.COMMITTED_HW_ID = h.HW_ID AND s.MEMBER_ID = $member_id, resource r INNER JOIN member m ON r.MEMBER_ID = m.M_ID  where r.COURSE_ID = '$course_id' AND r.TYPE = 1 and r.resource_id  = h.resource_id order by r.UPLOAD_TIME"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getHomeworksForManagement($course_id){
			$result = self::$connection -> query("select h.HW_ID, r.RESOURCE_TITLE from resource r, homework h where r.course_id = '$course_id' and r.type = 1 and r.RESOURCE_ID = h.RESOURCE_ID"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function getHomeworkInfo($hw_id){
			$result = self::$connection -> query("select r.RESOURCE_ID, r.UPLOAD_TIME, r.URL, r.MEMBER_ID, r.RESOURCE_TITLE, h.HW_ID, m.NAME, h.DEADLINE_TIME, r.COURSE_ID, CASE WHEN h.LOCK_TYPE = 2 THEN NOW() >  h.DEADLINE_TIME ELSE h.LOCK_TYPE = 1 END AS IS_LOCK from resource r, homework h, member m where r.MEMBER_ID = m.M_ID and h.HW_ID = $hw_id and r.RESOURCE_ID = h.RESOURCE_ID;"); 

			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return mysqli_fetch_assoc($result);
		}
		function getHomeworkResources($hw_id, $course_id){
			$result = self::$connection -> query("select m.M_ID, m.MAIL, m.NAME, s.STUDENT_ID, s.DEPARTMENT, r.UPLOAD_TIME, r.RESOURCE_ID from enrollment e, student s, member m left join resource r on r.MEMBER_ID = m.M_ID and r.COMMITTED_HW_ID = $hw_id where e.MEMBER_ID = m.M_ID and e.IS_ADMIN = false and e.COURSE_ID = '$course_id' and s.M_ID = m.M_ID ORDER BY m.NAME");
			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function hasAccessToZip($hw_id, $member_id){
			$result = self::$connection -> query("select m.M_ID from enrollment e, member m, homework h, resource r where m.M_ID = $member_id and r.RESOURCE_ID = h.RESOURCE_ID and h.HW_ID = $hw_id and e.MEMBER_ID = m.M_ID and e.IS_ADMIN and e.COURSE_ID = r.COURSE_ID");
			return $result->num_rows;
		}
		function getHomeworkURLS($hw_id){
			$result = self::$connection -> query("select m.NAME, r.URL, r.RESOURCE_TITLE, r.UPLOAD_TIME from member m, resource r where r.COMMITTED_HW_ID = $hw_id and m.M_ID = r.MEMBER_ID");
			if (!$result) {
				echo 'MySQL Error: ' . mysqli_error();
				exit;
			}
			return $result;
		}
		function isAdminToTopic($member_id, $topic_id){
			$result = self::$connection -> query("select t.topic_id from member m, topic t, enrollment e where m.M_ID = $member_id and e.MEMBER_ID = m.M_ID and e.IS_ADMIN and t.TOPIC_ID = $topic_id and e.COURSE_ID = t.COURSE_ID");
			return $result->num_rows;
		}
		function isThereTopic($course_id, $topic_id){
			$result = self::$connection -> query("select t.topic_id from topic t where t.TOPIC_ID = $topic_id and t.COURSE_ID = '$course_id'");
			return $result->num_rows;
		}
	}
	
?>