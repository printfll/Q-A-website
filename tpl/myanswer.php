<?php
require_once "head.php";
?>
 
 

 
<div style="width:600px;height:60px;margin:auto;text-align:left;margin-top:20px;line-height:20px;">
<li>新用户注册即可获取1个积分</li>
<li>发布一个问题获取2个积分，回答一个问题可获取1个积分</li>
<li>积分低于10的用户每天只能发布3个问题，积分高于10的用户每天可以发布5个问题</li>

</div>
 
 
<div style="width:760px;margin:auto;height:20px;line-height:20px;margin-top:30px;border-bottom:1px solid #aaa;text-align:left;">	
<div style="width:300px;float:left;"><h3>我的回答</h3></div>
<div style="width:150px;float:left;">问题</div>
<div style="width:150px;float:left;">回答者</div>
<div style="width:160px;float:left;">回答时间</div>
</div>

<?php if(!empty($myanswers)){ ?>
<?php foreach($myanswers as $q){?>
<div style="width:760px;margin:auto;height:30px;overflow:hidden;text-align:left;line-height:30px;border-bottom:1px #aaaaaa dashed;">
<div style="width:300px;float:left;"><?php echo $q['content']?></div>
<div style="width:150px;float:left;"><?php echo $q['qeestion']?></div>
<div style="width:150px;float:left;" class='xt1'><?php echo $q['author']?></div>
<div style="width:160px;float:left;" class='xt1'><?php echo date('Y-m-d H:i:s',$q['creat_time'])?></div>
</div>
<?php }}?>




<?php
require_once "buttom.php";
?>
