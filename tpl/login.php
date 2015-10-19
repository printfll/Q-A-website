<?php
require_once "head.php";
?>
 

 
 
<!--中间-->

 
<table border="1" width="428" align="center" style="margin-top:55px;"><tr><td>
 
 
<form id="aspform" action="/index.php" style="margin:0px;padding:0px;" method="post">
      
<div style="width:460px;height:240px;margin:auto;margin-top:40px; ">
 
 <div style="margin:auto;margin-top:20px;">还没有帐户？<a href="/index.php?ac=reg">我要注册</a></div>
	  
 
 
 
	  <div style="margin:auto;margin-top:20px;">用户：<input type="text" name="username"   style="width:102px;height:20px;border:1px solid #7f9db9;font-size: 14px;width:150px;"/></div>
	  
	  <div style="margin:auto;margin-top:10px;">密码：<input type="password" name="password"  style="width:102px;height:20px;border:1px solid #7f9db9;font-size: 14px;width:150px;"/></div>
      
	  
 
 
 
 
 <div style="margin:auto;margin-top:20px;">
	  <input name="ac" type="hidden" value="doLogin" />
    <input name="B1" type="submit" value="登录" />
   
     </div>
 
 
</div>	  
 
 
	  
 
 
</form>
 
</td></tr></table>








<?php
require_once "buttom.php";
?>
 
