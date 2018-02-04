<?php
	require ("class.php");
	header("Content-type: text/html; charset=utf-8"); 
	echo json_encode(array('file'=>$_FILE,'request'=>$_REQUEST));
	$db = ConnectMysqli::getIntance();
	$pic = illustration::getIntance();
	$userID = $_COOKIE['ID']; 
	$user = $_COOKIE['username'];
	$temp = explode(".", $_FILES["file"]["name"]);
	$picroad =  $_SERVER['DOCUMENT_ROOT']."/vixSite/userworks/$userID/";
	if(!is_dir($picroad)) {mkdir($picroad,0777);chmod($picroad, 0777);} 
	
	if ($_FILES["file"]["error"] > 0)
	{
		echo "错误：: " . $_FILES["file"]["error"] . "<br>";
	}
	else
	{
		if (!file_exists($picroad . $_FILES["file"]["name"]))
		{
			$name=iconv("UTF-8","gb2312",$_FILES["file"]["name"]);
			move_uploaded_file($_FILES["file"]["tmp_name"], "$picroad"."/".$name);
			$picID = $pic -> savePic($db, $userID, $_FILES["file"]["name"], $user,  $picroad. $_FILES["file"]["name"]);
		}
		else{
			echo "文件重名";
		}	
	}
?>