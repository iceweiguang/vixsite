<?php
	require ("class.php");
	header("Content-type: text/html; charset=utf-8"); 
	$db = ConnectMysqli::getIntance();
	$user = user::getIntance();
	$un = $_COOKIE['username'];
	$user->updateUser($db,$un,$_POST[nickname],$_POST[sex],$_POST[birthday],$_POST[motto]);
	header("refresh:0;url=../pp-chdt.html");
	echo '<script>alert("修改成功");</script>';
?>