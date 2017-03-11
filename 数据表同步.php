<?php
  
   $conn =@mysql_connect("localhost","root",'');
   mysql_select_db('chonggu');
   mysql_query("set names 'utf8'");
   $flag=0;
   print_r
   if(@$_POST['name']=='delete')
   {   
	   $flag=1;
	   $sql = "delete from cpg.copy_case";
	   $que = mysql_query($sql);
	   if($que)
	   {
		  echo "<script>alert(\"恭喜你，删除成功！\");</script>";
	   }
   }elseif(@$_POST['name']=='copy')
   {
	   $flag=1;
	 echo  $sql = "insert into cpg.copy_case2(`id`,`navid`,`title`,`thumb`,`content`,`create`) select `id`,`navid`,`title`,`thumb`,`content`,`create` from chonggu.cg_case";
       $que = mysql_query($sql);
	   if($que)
	   {
		   echo "<script>alert(\"数据表同步成功\");</script>";
	   }
   }
   
?>
<script type="text/javascript">
  function beforesubmit(action)
  {
     var e = document.info;
	 
	  if(action==1)
	  {
		  e.name.value='delete';
		  e.submit();
	  }else if(action==2)
	  {
		  e.name.value='copy';
		  e.submit();
	  }else
	  {
		  return false;
	  }
	 
  }
 </script>
<html>
<head></head>
<body>
<?php 

	?>
<form method="post" name="info">
  <input type="button" value="清空" onclick=beforesubmit(1)>
  <input type="button" value="同步" onclick=beforesubmit(2)>
  <input type="text" name="name" value="">
 </form>
<?php

	?>
</body>
</html>