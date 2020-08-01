<?php 
//news and notification

include_once("../inc/plan_connect.inc.php");
// include("../inc/connect.inc.php");
if (isset($_POST['news_subject'])) {
	$news_subject=trim($_POST['news_subject']);
	$addnews_textarea=trim($_POST['addnews_textarea']);

	$news_image= $_FILES["news_image"]["name"];
    $type     =$_FILES['news_image']['type'];
    $size     =$_FILES['news_image']['size'];
    $tmp_name   =$_FILES['news_image']['tmp_name'];
    $location= '../upload/news-upload/';
    $news_image_array=array('jpg','jpeg','png');
    if ((empty($news_subject))||(empty($addnews_textarea))) {
    	echo "Fill both the subject and the news.";
    }elseif ((!preg_match('/^[-a-zA-Z0-9 , \. ! \' \s "]+$/', $news_subject))) {
	    echo "Fill the subject with letters or numbers.";
	}elseif ((!preg_match('/^[-a-zA-Z0-9 , \. ! \' \s "]+$/', $addnews_textarea))) {
	    echo "Fill the news fields with letters or numbers.";
	}else{
	    if (!empty($_FILES['news_image']['tmp_name'])) {
    		$ext   =strtolower(end(explode('.', $news_image)));
	      	if ((!in_array($ext, $news_image_array))||($passport_size>4097676)){
	        	echo "Add an image that is less than 4Mb in jpg or png format.";
	        	exit();
	      	}else{
	      		$count_news =(int)mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT id FROM news ORDER BY id DESC LIMIT 1"))['id'];
	        	$news_img_name=($count_news+1).'.'.$ext;
	      		move_uploaded_file($tmp_name, $location.$news_img_name);
	      	}
      	}
	      	$news_subject=trim(mysqli_real_escape_string($mysqli,$news_subject));
	      	$addnews_textarea=trim(mysqli_real_escape_string($mysqli,$addnews_textarea));
	      	$date_uploaded=time();
        	if (mysqli_query($mysqli,"INSERT INTO news 
        		VALUES('{}','{$news_subject}','{$addnews_textarea}','{$news_img_name}','{$date_uploaded}')")) {
        		echo"ok";
        	}else{
        		echo "An error occured, try again.";
        	}

	}
}

//students notification
if (isset($_POST['notify_student_textarea'])) {
	$notify_student_textarea=trim($_POST['notify_student_textarea']);
	$time_uploaded=time();
	if ((empty($notify_student_textarea))) {
    	echo " Enter the notification.";
    }elseif ((!preg_match('/^[-a-zA-Z0-9 , \. ! \' \s "]+$/', $notify_student_textarea))) {
	    echo "Fill the notification input with letters and numbers..";
	}else{
		if (mysqli_query($mysqli,"INSERT INTO notice VALUES('{}','{$notify_student_textarea}','students','{$time_uploaded}')")) {
			echo"ok";
		}else{
			echo "An error occured, try again.";
		}
	}
}
//students notification
if (isset($_POST['notify_teachers_textarea'])) {
	$notify_teachers_textarea=trim($_POST['notify_teachers_textarea']);
	$time_uploaded=time();
	if ((empty($notify_teachers_textarea))) {
    	echo " Enter the notification.";
    }elseif ((!preg_match('/^[-a-zA-Z0-9 , \. ! \' \s "]+$/', $notify_teachers_textarea))) {
	    echo "Fill the notification input with letters and numbers..";
	}else{
		if (mysqli_query($mysqli,"INSERT INTO notice VALUES('{}','{$notify_teachers_textarea}','teachers','{$time_uploaded}')")) {
			echo"ok";
		}else{
			echo "An error occured, try again.";
		}
	}
}
//view news
if (isset($_POST['theId'])) {
	$theId=trim($_POST['theId']);
	$getNews =mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM news WHERE id= '{$theId}'"));
	if (!empty($getNews)) {
		// if (!empty($getNews['image_upload'])) {
		// 	$imgVal="<img src='"."upload/news-upload/".$getNews['image_upload']."'/>";
		// }else{$imgVal="";}
		echo '<h4>'.$getNews['subject'].'</h4>
			'.$imgVal.'
			<p>'.$getNews['news_body'].'</p>';
	}
}
//delete news
if (isset($_POST['news_del_id'])) {
	$news_del_id=trim($_POST['news_del_id']);
	$checkN =mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM news WHERE id= '{$news_del_id}'"));
	if (!empty($checkN)) {
		if (mysqli_query($mysqli,"DELETE FROM news WHERE id= '{$news_del_id}'")) {
			echo "ok";
		}
	}else{echo "News already deleted.";}
}
//view notificationss
if (isset($_POST['notify_fetch'])) {
	$getInfo=mysqli_query($mysqli,"SELECT * FROM notice ORDER BY id DESC");
	$getInfoDetails="";
	while ($row=mysqli_fetch_assoc($getInfo)) {
		$getInfoDetails.='<div class="sent_n_cols"><span>'.$row['for_who'].': </span>'.$row['message'].'<button class="notify_del" id="'.$row['id'].'" >Delete</button></div>';
	}
	echo $getInfoDetails;
}
//delete sent notifications
if (isset($_POST['notify_del_id'])) {
	$notify_del_id=trim($_POST['notify_del_id']);
	$checkN =mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM notice WHERE id= '{$notify_del_id}'"));
	if (!empty($checkN)) {
		if (mysqli_query($mysqli,"DELETE FROM notice WHERE id= '{$notify_del_id}'")) {
			echo "ok";
		}
	}else{echo "News already deleted.";}
}
//Panel news adding...
if (isset($_POST['news_panel_subject'])) {
	$news_panel_subject=$_POST['news_panel_subject'];
	$news_panel_body=$_POST['news_panel_body'];
	$date_uploaded=time();
	if ((empty($news_panel_subject))||(empty($news_panel_body))) {
		echo "Enter the subject and the news.";
	}else{
		if($stmt = mysqli_prepare($mysqli, "INSERT INTO news(subject,news_body,date_uploaded) VALUES(?,?,?)")){
	            // Bind variables to the prepared statement as parameters
	            mysqli_stmt_bind_param($stmt, "sss", $news_panel_subject, $news_panel_body,$date_uploaded);
	            
	            if(mysqli_stmt_execute($stmt)){
	                echo "ok";
	            } else{
	                echo "Something went wrong. Please try again later.";
	            }
	    }
        mysqli_stmt_close($stmt);
	}
}
?>