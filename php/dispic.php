<?php
	header('content-type:text/html;charset=utf-8');
	require ("class.php");
	$db = ConnectMysqli::getIntance();
	$pic = illustration::getIntance();
	
	$fn = $pic -> getTitle($db, $_GET['picID']);
	$time = $pic -> getUpldTime($db, $_GET['picID']);
	$uplder = $pic -> getUpldUser($db,$_GET['picID']);
	$userID = $pic -> getCountID($db,$_GET['picID']);
	$picpath =  $_SERVER['DOCUMENT_ROOT']."/vixSite/userworks/$userID/";
	
	$title = substr($fn,0,strrpos($fn,'.'));
	
	if(is_readable($picpath.$fn)){
		echo	'<div class="col-md-6 col-sm-10 center-block" >
					<div class="thumbnail">
						<img src="userworks/'.$userID.'/'.$fn.'" />
						<div class="caption">
							标题：<p>'.$title.'</p>
							上传时间：<p>'.$time.'</p>
							作者：<p>'.$uplder.'</p>
						</div>
					</div>
				</div>';
	}else{
		echo '这幅画不见了~~';
	}
?>