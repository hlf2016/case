<?php
$name=array('ab'=>'小刚','bc'=>'胡适','cd'=>'田野');
echo $name[ab];
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> New Document </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  
  <script type="text/javascript">

    var request = false;
	try
	{
		request = new XMLHttpRequest();
	}
	catch (trymicrosoft)
	{
		try
		{
			request = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (othermicrosoft)
		{
			try
			{
				request = new ActiveXObject("Microsoft.XMLHTTP");
				}
			catch (failed)
			{
				request = false;
			}  
		}
	}

  function goto(){
	var user = document.form1.user.value;
	var email = document.form1.email.value;
	var address = document.form1.address.value;
	
    var url = "ajaja.php?user="+user+"&email="+email+"&address="+address;
		request.open("GET", url, false);
		request.onreadystatechange = updatePage3;
		request.send(null);
	
}
function updatePage3(){
   var tt;
			
	if (request.readyState == 4)
	{
		if (request.status == 200)
		{
			tt=request.responseText;
			alert(tt);
		}
	}
}  
 </script>
 </head>

 <body>
  <form name="form1" method="post" action="">
      <table>
          <tr><td>用户名</td><td><input type="text" name="user"> </td></tr>
		  <tr><td>邮箱</td><td><input type="text" name="email"> </td></tr>
		  <tr><td>地址</td><td><input type="text" name="address"> </td></tr>
		  <tr><input  type="button"   onclick="return goto()" value="提交" ></tr>
	  </table>
  </form>
 </body>
</html>
