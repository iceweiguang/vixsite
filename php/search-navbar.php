<?php
	header('content-type:text/html;charset=utf-8');
	require ("class.php");
	$db = ConnectMysqli::getIntance();
	$pic = illustration::getIntance();
	
	$text = $_POST['searchtext'];
	$type = $_POST['searchtype'];
	//var_dump($text);
	//var_dump($type);
	if($type == "1"){
		$res = $pic -> searchPic($db, $text, $type);
		if(mysqli_num_rows($res) > 0) {
			$v = mysqli_fetch_all($res,MYSQLI_NUM);
			for($i = 0 ;$i < mysqli_num_rows($res);$i++){
				$temp = explode(".", $v[$i][0]);
				$v[$i][0] = $temp[0];
			}
			$jv = json_encode($v);
			
			setcookie('stype',$type,time()+3600,"/");
			setcookie('srj',$jv,time()+600,"/");
			//var_dump($jv);
			//var_dump($_COOKIE['srj']);
			header('Location: ../search-result.html');
		}
		else echo "搜索不到~~";
	}else if($type == "2"){
		$res = $pic -> searchPic($db, $text, $type);
		if(mysqli_num_rows($res) > 0) {
			$v = mysqli_fetch_all($res,MYSQLI_NUM);
			for($i = 0 ;$i < mysqli_num_rows($res);$i++){
				$temp = explode(".", $v[$i][3]);
				$v[$i][3] = $temp[0];
			}
			$jv = json_encode($v);
			setcookie('srj',$jv,time()+3600,"/");
			setcookie('stype',$type,time()+3600,"/");
			header('Location: ../search-result.html');
		}
		else echo "搜索不到~~";
	}else{
		echo "搜索失败";
	}
?>