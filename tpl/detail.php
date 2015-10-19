<?php
require_once "head.php";
?>
 

 
 
<!--中间-->

<table border="1"  align="center" style="margin-top:55px;" height=260><tr><td>
	<form action="/index.php" method="post" name="form1" id="form1" style="margin:0px;padding:0px;">
	
	
    
    
    <div style="width:360px;height:40px;line-height:40px;color:#000;text-indent:3em;text-align:left;margin:auto;margin-top:20px;">
		<div style="width:220px;float:left;height:20px;">问题:<?php echo $qestion[0]['title']?></div>
        
       
	</div>
	
    
    <div style="width:360px;height:40px;line-height:40px;color:#000;text-indent:3em;text-align:left;margin:auto;">
		
		
	
		<div style="width:220px;float:left;height:20px;">图片：<?php if(!empty($qestion[0]['pic'])) { ?><img src="<?php echo $qestion[0]['pic']?>" style="width:60px;height:40px;" /><?php } ?></div>
	
	
	</div>
    
    <div style="width:360px;height:40px;line-height:40px;color:#000;text-indent:3em;text-align:left;margin:auto;">
		
		
	
		<div style="width:220px;float:left;height:20px;">发布者：<?php echo $qestion[0]['author']?></div>
	
	
	</div>

	
	<div style="width:360px;height:40px;line-height:40px;color:#000;text-indent:3em;text-align:left;margin:auto;">
		
		
	
		<div style="width:220px;float:left;height:20px;">标签：<?php echo $qestion[0]['tag']?></div>
	
	
	</div>
	
	<div style="width:360px;height:40px;line-height:40px;color:#000;text-indent:3em;text-align:left;margin:auto;">
		
		
	
		<div style="width:220px;float:left;height:20px;">点赞：<?php echo $qestion[0]['agree']?></div>
	
	
	</div>
	
	<div style="width:360px;height:40px;line-height:40px;color:#000;text-indent:3em;text-align:left;margin:auto;">
		
	<div style="width:360px;float:left;height:20px;">创建时间：<?php echo date('Y-m-d H:i:s',$qestion[0]['create_time'])?></div>
	</div>
		<hr/>
		<?php if($qestion[0]['answers']){ ?>
		<?php foreach($qestion[0]['answers'] as $v){?>
		
		<div style="height:40px;line-height:40px;color:#000;text-indent:3em;text-align:left;margin:auto;">
		<div style="float:left;height:20px;">【<?php echo $v['author'] ?>】在【<?php echo date('Y-m-d H:i:s',$v['creat_time'])?>】回答了：【<?php echo $v['content']?>】</div>
		</div>
		<hr/>
		<?php }}else{　?>
		<div style="float:left;text-indent:3em;">暂时还没有人回答</div>
		<?php } ?>
		
		
	<?php if($qestion[0]['cananser']){ ?>
	<div style="width:360px;height:140px;line-height:40px;color:#000;text-indent:3em;text-align:left;margin:auto;">
		
		
	
		<div style="width:220px;float:left;height:40px;">回答：<textarea  id="password" name="answer" rows="5" cols="14"></textarea></div>
	
	
	</div>
	<div style="width:230px;height:32px;color:#000;text-align:left;margin:auto;margin-top:10px;">
	    <input name=B1 type=submit value="回复" >&nbsp;&nbsp;
		<a href="/index.php?ac=good&qid=<?php echo $qestion[0]['id']?>">点赞</a>
		<input type="hidden" name="ac" value="doAnswer">
		<input type="hidden" name="qid" value="<?php echo $qestion[0]['id']?>">
	</div>
    <?php } ?>	
	 


    
    
    </form>



    
</td></tr></table>







<?php
require_once "buttom.php";
?>
 
