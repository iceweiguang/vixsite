<?php
	//信息展示页请求
	header('content-type:text/html;charset=utf-8');
	require ("class.php");
	$db = ConnectMysqli::getIntance();
	$user = user::getIntance();
	$un = $_GET['username'];
	$v = $user -> getUserData($db, $un);
	echo json_encode($v);
?>