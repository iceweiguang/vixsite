<?php
	header('content-type:text/html;charset=utf-8');
	require ("class.php");
	$db = ConnectMysqli::getIntance();
	$pic = illustration::getIntance();
	
	$text = $_GET['searchtext'];
	$type = $_GET['searchtype'];
	if($type == "1"){
		$res = $pic -> searchPic($db, $text, $type);
		if(mysqli_num_rows($res) > 0) {
			$v = mysqli_fetch_all($res,MYSQLI_NUM);
			for($i = 0 ;$i < mysqli_num_rows($res);$i++){
				$temp = explode(".", $v[$i][0]);
				$v[$i][0] = $temp[0];
			}
			echo
			'<table class="table" id="search-result-table">
					<caption>搜索结果</caption>
					<thead>
						<tr>
							<th>插画名</th>
							<th>插画id</th>
							<th>作者id</th>
							<th>上传时间</th>
							<th>作者</th>
						</tr>
					</thead>
					<tbody id="search-result-list">';
			foreach($v as $link)  
		    {  echo '<tr style="cursor:pointer;" onclick="location.href=\'pic-details.html?picID='.$link[1].'\'">';
				
		        foreach($link as $val)  
		        {  
		            echo '<td>'.$val.'</td>';  
		        }   
				echo '</tr>';
		    } 
			echo	'</tbody>
				</table>';
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
			echo
			'<table class="table" id="search-result-table">
					<caption>搜索结果</caption>
					<thead>
						<tr>
							<th>作者</th>
							<th>插画id</th>
							<th>作者id</th>
							<th>插画名</th>
							<th>上传时间</th>
						</tr>
					</thead>
					<tbody id="search-result-list">';
			foreach($v as $link)  
		    {  echo '<tr style="cursor:pointer;" onclick="location.href=\'pic-details.html?picID='.$link[1].'\'">';
				
		        foreach($link as $val)  
		        {  
		            echo '<td>'.$val.'</td>';  
		        }   
				echo '</tr>';
		    } 
			echo	'</tbody>
				</table>';
		}
		else echo "搜索不到~~";
	}else{
		echo "搜索失败";
	}
	
?>