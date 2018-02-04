<?php
	header('content-type:text/html;charset=utf-8');
	require ("class.php");
	$db = ConnectMysqli::getIntance();
	$pic = illustration::getIntance();
	$picID = $_GET['id'];
	$picpath =  $_SERVER['DOCUMENT_ROOT']."/vixSite/userworks/$userID/"; 
	$filename = $pic -> getContent($db, $picID);
	$pic -> dltPic($db,$picID);
	$ret = unlink($filename);
	if($ret) echo '删除成功';
	else echo '删除失败';
?>