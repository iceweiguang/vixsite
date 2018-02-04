<?php
	header('content-type:text/html;charset=utf-8');
	require ("class.php");
	$db = ConnectMysqli::getIntance();
	$ntc = notice::getIntance();
	
	$res = $ntc -> getnotice();
	if(mysqli_num_rows($res) > 0){
		$v = mysqli_fetch_all($res,MYSQLI_NUM);
		echo json_encode($v);
	}
?>