<?php
	//修改信息页请求
	header('content-type:text/html;charset=utf-8');
	require ("class.php");
	$db = ConnectMysqli::getIntance();
	$user = user::getIntance();
	$un = $_GET['un'];
	$v = $user -> getUserData($db, $un);
	echo json_encode($v);
?>