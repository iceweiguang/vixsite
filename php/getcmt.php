<?php
	header('content-type:text/html;charset=utf-8');
	require ("class.php");
	$db = ConnectMysqli::getIntance();
	$pic = illustration::getIntance();
	$picID = $_GET['picID'] ;
	$cmt = comment::getIntance();
	//echo $cmtuser;
	
	$res = $cmt -> getCmt($db, $picID);
	if(mysqli_num_rows($res) > 0){
		$v = mysqli_fetch_all($res,MYSQLI_NUM);
		foreach($v as $link){
			echo '<div class="panel panel-default">
				<div class="panel-heading">
					'.$link[3].'
				</div>
				<div class="panel-body">
					'.$link[4].'
				</div>
				<div class="panel-footer">'.$link[5].'</div>
			</div>';
		}
	}
	
	
?>