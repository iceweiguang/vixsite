<?php
    header('Content-Type:text/event-stream');//通知浏览器开启事件推送功能
    header('Cache-Control:no-cache');//告诉浏览器当前页面不进行缓存

    $time = date('Y-m-d H:i:s');
    echo "retry:1000\ndata:<br><br><br><br> 当前时间: {$time}\n\n";
    
    /*$mysqli = new MySQLi('localhost','fty','ml3801324','vix');
    $sql = 'select * from illustration where uplduser="sweetfish"';
    $result = $mysqli->query($sql);
    while($row = $result->fetch_row()){
        $time = $row[1][1];    
        echo "data: The picture is: {$time}\n\n";
    }*/

    ob_flush();//刷新
    flush();//刷新
?>