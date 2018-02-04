<?php
	require ("class.php");
	
	header("Content-type: text/html; charset=utf-8"); 
	$db = ConnectMysqli::getIntance();
	$user = user::getIntance();
	if($user -> checkUserName($db,$_POST[userName])){
		$user -> saveUser($db,$_POST[userName],$_POST[passWord],$_POST[nickName],$_POST[email],$_POST[sex],$_POST[birthDay]);
		setcookie('username',$_POST[userName],time()+3600,'/');
		header('Location: ../index.html');
	}else{
		header("refresh:0;url=../regist.html");
		echo '<script>alert("用户名重复了");</script>';
	}
	
?>