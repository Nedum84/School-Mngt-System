<?php 
	
	if (isset($_GET['curViewPath'],$_GET['type'])) {
		$curViewPath=$_GET['curViewPath'];
		$type=$_GET['type'];
	}elseif (isset($_GET['assViewPath'],$_GET['ass_type'])) {
		$assViewPath=$_GET['assViewPath'];
		$ass_type=$_GET['ass_type'];
	}else{
		header('Location:home');
	}
?>
<?php 
	if ($type=="view") {
		header('Content-Type:application/pdf');
		readfile('upload/curriculum-upload/'.$curViewPath);
	}if ($type=="download") {
		header('Content-Type:application/pdf');
		header('Content-Disposition: attachment;filename="'.$curViewPath.'"');
		readfile('upload/curriculum-upload/'.$curViewPath);
	}if ($ass_type=="view") {
		header('Content-Type:application/pdf');
		readfile('upload/assignment-upload/'.$assViewPath);
	}if ($ass_type=="download") {
		header('Content-Type:application/pdf');
		header('Content-Disposition: attachment;filename="'.$assViewPath.'"');
		readfile('upload/assignment-upload/'.$assViewPath);
	}if ($type=="r_f_download") {
	    header('Content-Type:application/octect-stream');
	    header('Content-Disposition: attachment;filename="'.$curViewPath.'"');
	    header('Pragma:no cache');
	    ob_end_clean();
	    readfile('result-format/result-format-current.csv');
	    exit();
  	}

?>