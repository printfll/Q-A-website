<?php
	$session_user = !empty($_SESSION['userinfo'])?$_SESSION['userinfo']:array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>问答网</title>
<meta name="Keywords" content=""/>
<meta name="Description" content=""/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<Meta name="Copyright" Content=""> 
<link href="/css/main.css" rel="stylesheet" type="text/css"/>
</head>
<body>
 
<div style="width:760px;height:60px;margin:auto;border:px solid #ccc;">
 
<div style="float:left;width:170px;height:60px;padding-left:0px;border:0px solid #ccc;margin-left:20px;">
<a href="/index.php">
<img src="/images/logo.png" border="0" style="display:block;height:60px;width:168px;" alt="" title="">
</a>
</div>
 
 <script type="text/javascript">
 function doSearch(type){
	document.getElementById("stype").value = type 
	document.getElementById('sfom').submit();
 }
 </script>
 
<form style="margin:0px;padding:0px;" action="/index.php" method="get" name="search" id="sfom" >
 
<div style="height:35px;float:left;width:400px;margin-top:24px;border:0px solid #ccc;text-align:left;">
 
<input name="key" type="text" style="width:390px;height:22px;" value="<?php echo $key ?>" class="inp"/>
<input name="type" type="hidden" id="stype" style="width:390px;height:22px;" value="" class="inp"/>
<input name="ac" type="hidden" value="search" />
 
</div>
 
<div style="height:35px;float:left;width:150px;margin-top:24px;border:0px solid #ccc;">


<input type="button" value="搜问题" class="inp" onclick="doSearch('1')"/>
<input type="button" value="搜用户" class="inp" onclick="doSearch('2')"/>
 
</div>
 
</form>
 
</div>

<div style="width:760px;height:30px;margin:auto;background:url(/images/menu.png);margin-top:8px;line-height:30px;">
 
<div style="width:55px;height:25px;float:left;"><a href="/index.php" >首页</a></div>
<div style="width:55px;height:25px;float:left;"><a href="/index.php?ac=hot" >热点问题</a></div>
<?php if(empty($session_user)){ ?>
<div style="width:30px;height:25px;float:left;"><a href="/index.php?ac=reg" >注册</a></div>
<div style="width:50px;height:25px;float:left;"><a href="/index.php?ac=login" >登录</a></div>

<?php }else{ ?>
<div style="width:30px;height:25px;float:left;"><a href="/index.php?ac=ask" >提问</a></div>
<div style="width:50px;height:25px;float:left;"><a href="/index.php?ac=logout" >退出</a></div>
<?php } ?>
 
 
 

<div style="width:190px;height:25px;float:right;text-align:center;">

 <?php if(!empty($session_user)){ ?>
	 
	<a href="javascript:" style="">登录用户：</a>
	<a href="/index.php?ac=userinfo" style="color:Blue;"><?php echo $session_user['username'] ?></a>
 <?php }else{?>
	 
<?php } ?>
 
</div>
 
</div>
 

 
 

