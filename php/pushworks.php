<?php
    header('Content-Type:text/event-stream;charset=UTF-8');//通知浏览器开启事件推送功能
    header('Cache-Control:no-cache');//告诉浏览器当前页面不进行缓存
    $mysqli = new MySQLi('localhost','fty','ml3801324','vix');
	mysqli_query($mysqli, "set names utf8");
	$sql = 'select * from illustration';
    $res = $mysqli->query($sql);
	$v = mysqli_fetch_all($res,MYSQLI_NUM);
	
	$fn = array();
	$picID = array();
	$wr = '';
	
	//获取所有picID
	for($i = 0 ;$i < mysqli_num_rows($res);$i++){
		$picID[$i] = $v[$i][0];
	}
	
	//设置热度值
	for($j=0;$j < mysqli_num_rows($res);$j++){
		$visitnum = getVisitnum($mysqli, $picID[$j]);//浏览量
		$cmtnum = getCmtNum($mysqli, $picID[$j]);//评论数
		$upldtime = getupldtime($mysqli,$picID[$j]);//上传时间
		$time = date('Y-m-d H:i:s',"2018-01-01 00:00:00");//当前时间
		//热度公式
		$Z = $visitnum*0.6+$cmtnum*2;
		$ts = strtotime($upldtime) - strtotime($time);
		if($Z!=0) $hv = ceil(log($Z,10) + $ts/45000);
		else $hv = 0;
		//SRRank=log10Z+ts/45000
		setheatvalue($mysqli, $hv, $picID[$j]);
	}
	
	//获取四个热度值最高的插画ID
    $sql1 = 'select top 4 * from heatpoint order by heatvalue desc';
    $res1 = $mysqli->query($sql1);
	$v1 = mysqli_fetch_all($res1,MYSQLI_NUM);
	
	
	
	for($i=0;$i < 4;$i++){
		$v1 = getHotPic($mysqli, $picID[$i]);
		$fn[$i] = substr($v1[2],0,strrpos($v1[2],'.'));
		$wr = $wr.'<div class="col-md-3"><div class="thumbnail"><a href="pic-details.html?picID='.$v1[0].'" target="_blank" class="thumbnail"><img src="userworks/'.$v1[1].'/'.$v1[2].'" alt="Responsive image" class="img-responsive center-block" /></a><div class="caption"><p>作品标题：'.$fn[$i].'</p><p>作者:'.$v1[4].'</p><p>上传时间:'.$v1[3].'</p></div></div></div>';
	}
	
	
	
	echo "retry:60000\ndata:".$wr."\n\n";
    ob_flush();//刷新
    flush();//刷新
    
    
    function getHotPic($db,$pID){
    	$sql = "SELECT * FROM illustration WHERE picID = '{$pID}'";
		$res = $db -> query($sql);
		$row = $res -> fetch_row();
		return $row;
    }
    
    function getVisitnum($db,$pID){
		$sql = "SELECT visitnum FROM heatpoint WHERE picID = '{$pID}'";
		$res = $db -> query($sql);
		$row = $res -> fetch_row();
		return $row[0];
	}
	
	function getCmtNum($db,$pID){
		$sql = "SELECT cmtnum FROM heatpoint WHERE picID = '{$pID}' ";
		$res = $db -> query($sql);
		$row = $res -> fetch_row();
		return $row[0];
	}
	
	function getupldtime($db,$pID){
		$sql = "SELECT upldtime FROM heatpoint WHERE picID = '{$pID}' ";
		$res = $db -> query($sql);
		$row = $res -> fetch_row();
		return $row[0];
	}
	
	function setheatvalue($db,$hv,$picID){
		$sql = "UPDATE heatpoint SET heatvalue = '{$hv}' WHERE picID = '{$picID}'";
		$res = $db -> query($sql);
		return $res;
	}
?>

