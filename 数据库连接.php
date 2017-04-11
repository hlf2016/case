<?php
  //mysql连接取值
  /*
   $conn =@mysql_connect("localhost","root",'');
   mysql_select_db('chonggu');
   $sql = "select * from cg_case";
   $que = mysql_query($sql);
   while($result = mysql_fetch_array($que))
   {
	   print_r($result);
   }
   */
  //mysqli连接取值
  /*
  $mysql = new mysqli('localhost','root','','chonggu');
  $sql = "select * from cg_case ";
  $stmt = $mysql->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();
  $array = $result->fetch_all(MYSQLI_ASSOC);
  print_r($array);
  */
  //pdo链接数据库
  try
  {
	  $pdo = new PDO("mysql:host=localhost;dbname=chonggu","root","");
  }catch (Exception $e)
  { 
	  echo $e->getMessage();exit();
  }
  //设置字符集
  $pdo->exec("SET names utf8");
  //插入 
  $que = $pdo->exec("select * from cg_case");
  while($result = $que->fetch())
  {
	  print_r($result);
  }
?>