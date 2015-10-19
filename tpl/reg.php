<?php
require_once "head.php";
?>
 

 
 
<!--中间-->

<table border="1" width="428" align="center" style="margin-top:55px;" height=260><tr><td>
	<form action="/index.php" method="post" name="form1" id="form1" style="margin:0px;padding:0px;">
	<div style="width:360px;height:40px;line-height:40px;color:#000;text-indent:3em;text-align:left;margin:auto;margin-top:20px;">
		<div style="width:220px;float:left;height:20px;">用&nbsp;户&nbsp;名：<input type="text" id="username" name="username" style="width:102px;height:20px;border:1px solid #7f9db9;margin-top:10px;" Tip="请输入用户名!" Exp="[^ ]+"></div>
     </div>
	<div style="width:360px;height:40px;line-height:40px;color:#000;text-indent:3em;text-align:left;margin:auto;">
		<div style="width:220px;float:left;height:20px;">密&nbsp;&nbsp;&nbsp;&nbsp;码：<input type="password" id="password" name="password" style="width:102px;height:20px;border:1px solid #7f9db9;margin-top:10px;"></div>
	</div>
	
	<div style="width:360px;height:40px;line-height:40px;color:#000;text-indent:3em;text-align:left;margin:auto;">
		<div style="width:220px;float:left;height:20px;">确认密码：<input type="password" id="repassword1" name="repassword" style="width:102px;height:20px;border:1px solid #7f9db9;margin-top:10px;"></div>
	</div>

<div style="width:230px;height:32px;color:#000;text-align:left;margin:auto;margin-top:10px;">
	    <input name=B1 type=submit value="确认注册" >&nbsp;&nbsp;
		<input type="hidden" name="ac" value="doReg">
	</div>
    
    
    </form>



    
</td></tr></table>







<?php
require_once "buttom.php";
?>
 
