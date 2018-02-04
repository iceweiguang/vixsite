<?php
	header("Content-type: text/html; charset=utf-8"); 
	setcookie('username','',time()-3600,'/');
	setcookie('ID','',time()-3600,'/');
	unset($_COOKIE['username']);
	//var_dump($_COOKIE);
	header('Location: ../index.html');
?>