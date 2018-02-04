<?php

header('content-type:text/html;charset=utf-8');
//数据库类
class ConnectMysqli {
	private static $dbcon = false;
	private $servername;
	private $dbcountname;
	private $dbpassword;
	private $dbname;
	private $charset;
	private $link;

	private function __construct($config = array()) {
		$this -> servername = isset($config['servername']) ? $config['servername'] : 'localhost';
		$this -> dbuser = isset($config['dbuser']) ? $config['dbcountname'] : 'fty';
		$this -> dbpass = isset($config['dbpass']) ? $config['dbpassword'] : 'ml3801324';
		$this -> dbname = isset($config['dbname']) ? $config['dbname'] : 'vix';
		$this -> charset = isset($arr['charset']) ? $arr['charset'] : 'utf8';
		//连接数据库
		$this -> connect();
		//选择数据库
		$this -> usedb();
		//设置字符集
		$this -> charset();
	}

	private function connect() {
		// 创建连接
		$this -> link = mysqli_connect($this -> servername, $this -> dbuser, $this -> dbpass);
		// 检测连接
		if (!$this -> link) {
			echo "数据库连接失败<br>";
			echo "错误编码" . mysqli_errno($this -> link) . "<br>";
			echo "错误信息" . mysqli_error($this -> link) . "<br>";
			exit ;
		}
	}

	//设置字符集
	private function charset() {
		mysqli_query($this -> link, "set names {$this->charset}");
	}

	//选择数据库
	private function usedb() {
		mysqli_query($this -> link, "use {$this->dbname}");
	}

	//公用的静态方法
	public static function getIntance() {
		if (self::$dbcon == false) {
			self::$dbcon = new self;
		}
		return self::$dbcon;
	}

	//私有的克隆
	private function __clone() {
		die('clone is not allowed');
	}

	//执行sql语句的方法
	public function query($sql) {
		$res = mysqli_query($this -> link, $sql);
		if (!$res) {
			echo "sql语句执行失败<br>";
			echo "错误编码是" . mysqli_errno($this -> link) . "<br>";
			echo "错误信息是" . mysqli_error($this -> link) . "<br>";
		}
		return $res;
	}

}

//用户类
class user {
	private static $loginflag = false;
	private static $usercreate = false;
	private $role;
	private $ID;
	private $countname;
	private $password;
	private $nickname;
	private $email;
	private $sex;
	private $motto;
	private $dateofbirth;
	private $followernum;
	private $follownum;

	private function __construct($config = array()) {
		$this -> role = isset($config['role']) ? $config['role'] : 'user';
		$this -> countname = isset($config['countname']) ? $config['countname'] : '';
		$this -> password = isset($config['password']) ? $config['password'] : '';
		$this -> nickname = isset($config['nickname']) ? $config['nickname'] : '用户小可爱';
		$this -> email = isset($config['email']) ? $config['email'] : '';
		$this -> sex = isset($config['sex']) ? $config['sex'] : 'S';
		$this -> motto = isset($config['motto']) ? $config['motto'] : '';
		$this -> dateofbirth = isset($config['dateofbirth']) ? $config['dateofbirth'] : '2000-01-01';
		$this -> followernum = isset($config['followernum']) ? $config['followernum'] : 0;
		$this -> follownum = isset($config['follownum']) ? $config['follownum'] : 0;
	}
	
	public static function getIntance() {
		if (self::$usercreate == false) {
			self::$usercreate = new self;
		}
		return self::$usercreate;
	}
	
	public function saveUser($db, $Countname, $Password, $Nickname, $Email,$Sex, $Dateofbirth) {
		$this -> role = 'user';
		$this -> countname = $this -> testInput($Countname);
		$this -> password = md5($Password);
		$this -> nickname = $this -> testInput($Nickname);
		$this -> email = $Email;
		$this -> sex = $Sex;
		$this -> motto = '';
		$this -> dateofbirth = $this -> testInput($Dateofbirth);
		$this -> followernum = 0;
		$this -> follownum = 0;
		
		
		
		$sql = "INSERT INTO vixusers (role,countname,password,nickname,email,sex,motto,dateofbirth,followernum,follownum) 
			VALUES (
			'{$this -> role}',
			'{$this -> countname}',
			'{$this -> password}',
			'{$this -> nickname}',
			'{$this -> email}',
			'{$this -> sex}',
			'{$this -> motto}',
			'{$this -> dateofbirth}',
			'{$this -> followernum}',
			'{$this -> follownum}')";
		$res = $db -> query($sql);
		return $res;
	}
	
	public function updateUser($db, $Countname, $Nickname, $Sex, $Dateofbirth, $Motto) {
		$sql = "UPDATE vixusers SET
			nickname = '{$Nickname}',
			sex = '{$Sex}',
			motto = '{$Motto}',
			dateofbirth = '{$Dateofbirth}' WHERE
			countname = '{$Countname}'";
		$res = $db -> query($sql);
		return $res;
	}
	
	private function testInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	
	
	public function login($db, $Countname, $Password) {
		$sql = "SELECT * FROM vixusers WHERE countname = '{$Countname}'";
		$res = $db ->query($sql);
		$v = $res -> fetch_row();
		
		if(md5($Password) != $v[3]){
			echo "登陆失败！";
		}
		else{
			$this -> role = $v[0];
			$this -> ID = $v[1];
			$this -> countname = $v[2];
			$this -> password = $v[3];
			$this -> nickname = $v[4];
			$this -> sex = $v[5];
			$this -> motto = $v[6];
			$this -> dateofbirth = $v[7];
			$this -> followernum = $v[8];
			$this -> follownum = $v[9];
			$this -> loginflag = ture;
		}
		return $this;
	}
	
	public function getUserData($db,$Countname){
		$sql = "SELECT * FROM vixusers WHERE countname = '{$Countname}'";
		$res = $db -> query($sql);
		$v = $res -> fetch_row();
		return $v;
	}
	
	public function checkUserName($db,$username){
		$sql = "SELECT countname FROM vixusers WHERE countname = '{$username}'";
		$res = $db -> query($sql);
		$v = $res -> fetch_row();
		if($username == $v[0]) return false;
		else return true;
	}
	
	public function getLoginFlag(){return $this -> loginflag;}
	public function getUserName(){return $this -> countname;}
	public function getID(){return $this -> ID;}
	public function getSex(){return $this -> sex;}
	public function getMotto(){ return $this -> motto;}
	public function getNickName(){return $this -> nickname;}
	public function getBirth(){return $this -> dateofbirth;}
	public function getFollowerNum(){return $this -> followernum;}
	public function getFollowNum(){return $this -> follownu;}
}

//插画类
class illustration {
	private static $piccreate = false;
	private $picID;
	private $countID;
	private $title;
	private $upldtime;
	private $uplduser;
	private $content;
	private $visitnum;
	
	private function __construct($config = array()) {
		$this -> title = isset($config['title']) ? $config['title'] : '';
		$this -> uplduser = isset($config['uplduser']) ? $config['uplduser'] : '用户小可爱';
		$this -> content = isset($config['content']) ? $config['content'] : "../userworks/$this->uplduser/";
	}
	public static function getIntance() {
		if (self::$piccreate == false) {
			self::$piccreate = new self;
		}
		return self::$piccreate;
	}
	public function savePic($db, $countID, $title, $uplduser,$content){
		$this -> countID = $countID;
		$this -> title = $title;
		$this -> uplduser = $uplduser;
		$this -> content = $content;
		$sql = "INSERT INTO illustration (countID,title,uplduser,content) 
			VALUES (
			'{$this -> countID}',
			'{$this -> title}',
			'{$this -> uplduser}',
			'{$this -> content}')";
		$res = $db -> query($sql);
		
		$picID = $this -> getPicID($db, $title, $countID);
		$sql2 = "INSERT INTO heatpoint (picID) 
			VALUES ('{$picID}')";
		$db -> query($sql2);
		return $res;
	}

	public function dltPic($db,$ID){
		$sql = "DELETE FROM illustration WHERE picID = '{$ID}'";
		$res = $db -> query($sql);
		$db -> query("DELETE FROM heatpoint WHERE picID = '{$ID}'");
		return $res;
	}
	
	
	public function searchPic($db,$text,$type){
		if($type == "1") $sql = "select title,picID,countID,upldtime,uplduser from illustration where title like '%" .$text. "%'";
		else if($type == "2") $sql = "select uplduser,picID,countID,title,upldtime from illustration where uplduser like '%" .$text. "%'";
		$res = $db -> query($sql);
		return $res;
	}
	
	public function getPicID($db,$title,$ID){
		$sql = "SELECT * FROM illustration WHERE title = '{$title}' AND countID = '{$ID}'";
		$res = $db -> query($sql);
		$row = $res -> fetch_row();
		return $row[0];
	}

	public function getCountID($db,$pID){
		$sql = "SELECT * FROM illustration WHERE picID = '{$pID}'";
		$res = $db -> query($sql);
		$row = $res -> fetch_row();
		return $row[1];
	}
	public function getTitle($db,$pID){
		$sql = "SELECT * FROM illustration WHERE picID = '{$pID}'";
		$res = $db -> query($sql);
		$row = $res -> fetch_row();
		return $row[2];
	}
	public function getUpldTime($db,$pID){
		$sql = "SELECT * FROM illustration WHERE picID = '{$pID}'";
		$res = $db -> query($sql);
		$row = $res -> fetch_row();
		return $row[3];
	}
	public function getUpldUser($db,$pID){
		$sql = "SELECT * FROM illustration WHERE picID = '{$pID}'";
		$res = $db -> query($sql);
		$row = $res -> fetch_row();
		return $row[4];
	}
	public function getContent($db,$pID){
		$sql = "SELECT * FROM illustration WHERE picID = '{$pID}'";
		$res = $db -> query($sql);
		$row = $res -> fetch_row();
		return $row[5];
	}
	
	
}

//评论类
class comment{
	private static $cmtflag = FALSE;
	private $cmtID;
	private $picID;
	private $cmterID;
	private $cmtername;
	private $cmtcnt;
	private $cmttime;
	
	private function __construct($config = array()) {
	}
	public static function getIntance() {
		if (self::$cmtflag == false) {
			self::$cmtflag = new self;
		}
		return self::$cmtflag;
	}
	
	public function saveCmt($db,$picID,$cmterID,$cmtername,$cmtcnt){
		$sql = "INSERT INTO comment (picID,cmterID,cmtername,cmtcnt) 
			VALUES (
			'{$picID}',
			'{$cmterID}',
			'{$cmtername}',
			'{$cmtcnt}')";
		$res = $db -> query($sql);
		$sql1 = "UPDATE heatpoint SET cmtnum = cmtnum + 1 WHERE picID = '{$picID}'";
		$res1 = $db -> query($sql1);
		return $res;
	}
	public function getCmt($db,$pID){
		$sql = "SELECT * FROM comment WHERE picID = '{$pID}' ";
		$res = $db -> query($sql);
		return $res;
	}
	
	public function getCmtNum($db,$pID){
		$sql = "SELECT * FROM comment WHERE picID = '{$pID}' ";
		$res = $db -> query($sql);
		$num = mysqli_num_rows($res);
		return $num;
	}
}

//热度推送表
class heatpoint{
	private static $hpflag = FALSE;
	private $picID;
	private $upldtime;
	private $visitnum;
	private $cmtnum;
	private $heatvalue;
	
	private function __construct($config = array()) {
		
	}
	public static function getIntance() {
		if (self::$hpflag == false) {
			self::$hpflag = new self;
		}
		return self::$hpflag;
	}
	
	public function plusvisit($db,$picID){
		$sql = "UPDATE heatpoint SET visitnum = visitnum + 1 WHERE picID = '{$picID}'";
		$res = $db -> query($sql);
		return $res;
	}
	
	public function getVisitnum($db,$pID){
		$sql = "SELECT visitnum FROM heatpoint WHERE picID = '{$pID}'";
		$res = $db -> query($sql);
		$row = $res -> fetch_row();
		return $row[0];
	}
}






//公告类
class notice{
	private static $ntcflag = FALSE;
	private $ntcID;
	private $ntctitle;
	private $ntccnt;
	private $ntctime;
	
	private function __construct($config = array()) {
		$this -> ntctitle = isset($config['ntctitle']) ? $config['ntctitle'] : '';
		$this -> ntccnt = isset($config['ntccnt']) ? $config['ntccnt'] : '';
	}
	public static function getIntance() {
		if (self::$ntcflag == false) {
			self::$ntcflag = new self;
		}
		return self::$ntcflag;
	}
	
	public function getnotice(){
		$sql = "SELECT * FROM notice";
		$res = $db -> query($sql);
		return $res;
	}
}



?>