<?php
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set('America/Los_Angeles');
error_reporting(E_ERROR);
session_start();
require_once "db.php";

if(!empty($_REQUEST['ac'])){
	$ac = trim($_REQUEST['ac']);

	if($ac=='reg'){ 
		include 'tpl/reg.php';
	}else if($ac=='login'){
		include 'tpl/login.php';
	}else if($ac=='doReg'){
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$repassword = trim($_POST['repassword']);
		if(empty($username)||empty($password)||empty($repassword)){
			exit('用户名或者密码不能为空!');
		}else if($password<>$repassword){
			exit('两次密码输入不一致!');
		}else{
			$res = doReg($username,md5($password),1);
			if($res[0]==1){
				header("location:index.php?ac=login");
			}else{
				exit($res[1]);
			}
		}
		
	}else if($ac=='doLogin'){
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		if(empty($username)||empty($password)){
			exit('用户名或者密码不能为空!');
		}else{
			$res = doLogin($username,md5($password));
			if($res[0]==1){
				$_SESSION['userinfo'] = $res[2];
				header("location:index.php");
			}else{

				exit($res[1]);
			}
		}
		
	}else if($ac=='logout'){
		session_destroy();
		header("location:index.php");
	}else if($ac=='ask'){
		include 'tpl/addquestion.php';
	}else if($ac=='doAsk'){
		$title = trim($_POST['title']);
		$tag = trim($_POST['tag']);
		$file = !empty($_FILES['pic'])?$_FILES['pic']:array();
		if(empty($title)){
			exit('用户标题不能为空!');
		}else{
			$res = doAsk($title,$tag,$file);
			if($res[0]==1){
				header("location:index.php");
			}else{
				exit($res[1]);
			}
		}
	}else if($ac=='detail'){
	
		$qid = intval($_GET['id']);
		$qestion = getOneQuestion($qid);
		include 'tpl/detail.php';
		
	}else if($ac=='doAnswer'){
	
		$qid = intval($_POST['qid']);
		$answer = trim($_POST['answer']);
		$qestion = addAnswer($qid,$answer);
		header("location:index.php?ac=detail&id=".$qid);
		
	}else if($ac=='doMessage'){
		$messageAuthor=intval($_POST['messageAuthor']);
		$content=trim($_POST['content']);
		$message=addMessage($messageAuthor, $content);
		header("location:index.php?ac=userinfo");
	}else if($ac=='search'){
		$type = !empty($_GET['type'])?intval($_GET['key']):1;
		if($type==1){
			$key = !empty($_GET['key'])?trim($_GET['key']):null;
			$memberid = !empty($_GET['memberid'])?intval($_GET['memberid']):null;
			$title = $memberid?'我的问题':'';
			$questions = getQuestionList($memberid,$key);
			
			include 'tpl/main.php';
		}else{
			$key = !empty($_GET['key'])?trim($_GET['key']):null;
			$users = getUserList($key);
			include 'tpl/userlist.php';
		}
		
		
	}else if($ac=='myanswers'){
		
		$memberid = !empty($_GET['memberid'])?intval($_GET['memberid']):null;
		$myanswers = getAnswerList($memberid);
		
		include 'tpl/myanswer.php';
		
	}else if($ac=='userinfo'){
		$usersession = $_SESSION['userinfo'];
		$info = getOneUser($usersession['username']);
		include 'tpl/userinfo.php';
		
	}else if($ac=='good'){
		$qid = intval($_GET['qid']);
		$res = goodQuestion($qid);
		header("location:index.php?ac=detail&id=".$qid);
		
	}else if($ac=='hot'){
		$qid = intval($_GET['qid']);
		$questions = getQuestionList(null,null,'agree desc');
		$title = '热点问题';
		include 'tpl/main.php';
		
	}else{
		header("location:index.php");
	}
}else{
	$questions = getQuestionList();
	include 'tpl/main.php';
}

function getOneUser($username,$password=null){
	$db = new DB();
	if($password){
		$userinfo = $db->selectBySql("select * from member where username=? and password=? ",array($username,$password));
	}else{
		$userinfo = $db->selectBySql("select * from member where username=? ",array($username));
	}
	if($userinfo){
		$qeston = $db->selectBySql("select count(*) as total from question where authorid=? ",array($userinfo[0]['id']));
		$userinfo[0]['qcount'] = !empty($qeston[0]['total'])?$qeston[0]['total']:0;
		
		$aqeston = $db->selectBySql("select count(*) as total from answer where authorid=? ",array($userinfo[0]['id']));
		$userinfo[0]['acount'] = !empty($aqeston[0]['total'])?$aqeston[0]['total']:0;
	}
	return !empty($userinfo[0])?$userinfo[0]:array();
}
function doReg($username,$password,$bounds){
	//先检查用户是否存在
	$db = new DB();
	$userinfo = getOneUser($username);
	
	if(empty($userinfo)){
		$res = $db->exeSql("insert into member set username=?,password=?,bounds=?,creat_time=?",array($username,$password,$bounds,time()));
		if($res!==false){
			return array('1','注册成功！');
		}else{
			return array('0','注册失败！');
		}
	}else{
		return array('0','用户已经存在，不能注册！');
	}
	
}

function doLogin($username,$password){
	//先检查用户是否存在
	$db = new DB();
	$userinfo = getOneUser($username,$password);
	
	if(!empty($userinfo)){
		return array('1','登录成功！',$userinfo);
	}else{

		return array('0','用户不存在！');
	}
	
}

//添加问题
function doAsk($title,$tag,$file){
	
	$db = new DB();
	$usersession = $_SESSION['userinfo'];
	//
	$boundsdata = $db->selectBySql("select bounds from member where id=?",array($usersession['id']));
	$sql = "select count(*) as total from question where authorid=? and create_time>=? and create_time <=? ";
	$par[] = $usersession['id'];
	$par[] = strtotime(date('Y-m-d'));
	$par[] = strtotime(date('Y-m-d')." 23:59:59");
	$questiondata = $db->selectBySql($sql,$par);
	
	if($boundsdata[0]['bounds']>10){//积分大于10可以发5个
		if($questiondata[0]['total']>=5){
			exit("积分高于10的用户每天只可以发布五个问题");
		}
		
	}else{
		if($questiondata[0]['total']>=3){
			exit("积分不高于10的用户每天只可以发布三个问题");
		}
	}
	$uploadfile = '';
	$sql = "insert into question set title=?,authorid=?,create_time=?, agree=0";
	$param[] = $title;
	$param[] = $usersession['id'];
	$param[] = time();
	
	if(!empty($file['name'])){
		$uploaddir = 'upload/';

		$uploadfile = $uploaddir . time().strrchr($file['name'],'.');
		if (move_uploaded_file($file['tmp_name'], $uploadfile)) {    
			$sql .= ",pic=?";
			$param[] = $uploadfile;
		} else {   
			exit('上传图片失败');
		}
	}
	$qid = $db->exeSql($sql,$param);
	
	if($qid!==false){
		if(!empty($tag)){
			
			$tagarr = explode(',',$tag);
			$tagarr = array_unique($tagarr);
			foreach($tagarr as $v){
				$res = $db->exeSql("insert into tag set tag=?,qid=?",array($v,$qid));
			}
		}
		$res = $db->exeSql("update member set bounds = bounds+2 where id=? ",array($usersession['id']));
		return array('1','提问成功');
	
	}else{
		return array('0','提问失败');
	}
}

function getOneQuestion($qid){
	$db = new DB();	
	$usersession = $_SESSION['userinfo'];
	$qestion = $db->selectBySql("select * from question where id=?",array($qid));
	$userdata = $db->selectBySql("select * from member where id=?",array($qestion[0]['authorid']));
	
	$tagdata = $db->selectBySql("select * from tag where qid=?",array($qestion[0]['id']));
	$tags = array();
	foreach($tagdata as $k1=>$v1){
		$tags[] = $v1['tag'];
	}
	
	$qestion[0]['author'] =  $userdata[0]['username'];
	$qestion[0]['tag'] =  implode(',',$tags);
	
	$answerdata = $db->selectBySql("select * from answer where qid=?",array($qestion[0]['id']));
	
	foreach($answerdata as $k2=>$v2){
		$userdata = $db->selectBySql("select * from member where id=?",array($v2['authorid']));
		$answerdata[$k2]['author'] = $userdata[0]['username'];
		
	}
	$qestion[0]['answers'] = $answerdata;
	if($usersession['id']==$qestion[0]['authorid']){
		$qestion[0]['cananser'] = 0;
	}else{
		$qestion[0]['cananser'] = 1;
	}
	return $qestion;
}
function getQuestionList($authorid=null,$title=null,$order=null){

	$db = new DB();	
	$sql = "select * from question where 1=1 ";
	$param = array();
	if(!empty($authorid)){
		$sql .= " and authorid = ?";
		$param[] = $authorid;
	}
	if(!empty($title)){
		$sql .= " and title like ? ";
		$param[] = "%$title%";
	}
	if($order){
		$sql .= " order by ".$order;
	}else{
		$sql .= " order by create_time desc ";
	}
	$list = $db->selectBySql($sql,$param);
	
	foreach($list as $k=>$v){
		
		$userdata = $db->selectBySql("select * from member where id=?",array($v['authorid']));
		$tagdata = $db->selectBySql("select * from tag where qid=?",array($v['id']));
		$tags = array();
		foreach($tagdata as $k1=>$v1){
			$tags[] = $v1['tag'];
		}
		
		$list[$k]['author'] =  $userdata[0]['username'];
		$list[$k]['tag'] =  implode(',',$tags);
		
	}
	
	return $list;
}

function addAnswer($qid,$answer){
	$db = new DB();	
	$usersession = $_SESSION['userinfo'];
	$res = $db->exeSql("insert into answer set qid=?,content=?,authorid=?,creat_time=?",array($qid,$answer,$usersession['id'],time()));
	$res = $db->exeSql("update member set bounds=bounds+1 where id=?",array($usersession['id']));
	
	return $res;
}

function addMessage($messageAuthor,$content){
	$db=new DB();
	$usersession=$_SESSION['userinfo'];
	$res=$db->exeSql("insert into message set authorID=?,content=?,messageAuthor=?,createTime=?",array($usersession['id'],$content,$messageAuthor,time()));
	return $res;
}

function getAnswerList($memid){

	$db = new DB();	
	$answerdata = $db->selectBySql("select * from answer where authorid=?",array($memid));
	
	foreach($answerdata as $k=>$v){
		$userdata = $db->selectBySql("select * from member where id=?",array($v['authorid']));
		$answerdata[$k]['author'] =  $userdata[0]['username'];
		
		$qdata = $db->selectBySql("select * from question where id=?",array($v['qid']));
		$answerdata[$k]['qeestion'] =  $qdata[0]['title'];
	}
	return $answerdata;
}

function goodQuestion($qid){
	$db = new DB();	
	$res = $db->exeSql("update question set agree=agree+1 where id=?",array($qid));
	return $res;
}

function getUserList($key){

	$db = new DB();	
	$sql = "select * from member where 1=1 and username like ? ";
	$users= $db->selectBySql($sql,array("%$key%"));
	return $users;
};

?>