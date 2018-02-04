<?php
	header('content-type:text/html;charset=utf-8');
	require ("class.php");
	$db = ConnectMysqli::getIntance();
	$cmt = comment::getIntance();
	$hp = heatpoint::getIntance();

	$picID = $_GET['picID'];
	$hp -> plusvisit($db, $picID);
	$visitnum = $hp -> getVisitnum($db, $picID);
	$cmtnum = $cmt -> getCmtNum($db, $picID);
	echo "访问人次：".$visitnum;
	echo "评论条数：".$cmtnum;
?>
