<?php
	header('content-type:text/html;charset=utf-8');
	require ("class.php");
	$db = ConnectMysqli::getIntance();
	$pic = illustration::getIntance();
	$cmt = comment::getIntance();
	$picID = $_POST['picID'];
	$cmterID = $_COOKIE['ID'];
	$cmtername = $_COOKIE['username'];
	$cmtcnt = $_POST['cmtcnt'];
	$res = $cmt -> saveCmt($db,$picID,$cmterID,$cmtername,$cmtcnt);
	header('Location: ../pic-details.html?picID='.$picID);
?>