<?php
	header('content-type:text/html;charset=utf-8');
	require ("class.php");
	$db = ConnectMysqli::getIntance();
	$pic = illustration::getIntance();
	
	$userID = $_COOKIE['ID']; 
	$picpath =  $_SERVER['DOCUMENT_ROOT']."/vixSite/userworks/$userID/";
	$fns = scandir($picpath);
	array_splice($fns,0,2); 
	$jsfn =  json_encode($fns);
	$fna = json_decode($jsfn,TRUE);
	//echo $fna[0];
	if ($userID)
		for($i=0;$i<sizeof($fna);$i++) {
			$picn[$i] = substr($fna[$i],0,strrpos($fna[$i],'.'));
			$upldtime = $pic -> getUpldTime($db, $fna[$i],$userID);
			$picID = $pic -> getPicID($db, $fna[$i],$userID);
			echo	'<div class="col-md-3">
		            	<div class="thumbnail">
		               		<a href="pic-details.html?picID='.$picID.'" target="_blank" class="thumbnail">
								<img src="userworks/'.$userID.'/'.$fna[$i].'" alt="Responsive image" class="img-responsive center-block" />
							</a>
		               		<div class="caption">
		                    	<p>作品标题：'.$picn[$i].'</p>
	            				<p>上传时间:'.$upldtime.'</p>
								<div class="picID">id:'.$picID.'</div>
							
	            				<button href="#" class="btn btn-danger" role="button" onclick="dltfile('.$picID.');" id="dltbtn">删除</button>
		                	</div>
		            	</div>
		          	</div>';
		}
?>