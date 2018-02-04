<?php
header("Content-type:text/html;charset=utf-8");
require ("class.php");
setcookie('username','',time()+3600,'/');
setcookie('ID','',time()+3600,'/');
if ($_COOKIE['username']=='') {
	//var_dump($_COOKIE);
	$db = ConnectMysqli::getIntance();
	$user = user::getIntance();
	$user = $user -> login($db, $_POST[userName], $_POST[passWord]);
	
	if ($user -> getLoginFlag()) {
		$u = $user -> getUserName();
		$id = $user -> getID();
		setcookie('username',"$u",time()+3600,'/');
		setcookie('ID',"$id",time()+3600,'/');
		//var_dump($_COOKIE);
		header('Location: ../index.html');
	} else {
		header('Location: ../login.html');
	}
}

?>

