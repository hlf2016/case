<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

include( "../conf/model.php" );
bitcool_login_staticone( "../" );
pri_auth( $_SESSION['UID'] );
require_once( "../jscss/calendar/calendar.php" );
$calendar = new DHTML_Calendar( "/jscss/calendar/", "zh", "theme", true );
$calendar->load_files();
$UID = $_SESSION['UID'];
$sql_group = "select depart_id,group_id,is_header,is_depart from staff a,depart b where a.depart_id=b.id and b.s_flag='是' and a.id=".$UID." and a.sta_status=1";
$query_group =  mysql_query( $sql_group );
if ( $query_group )
{
    if ( 0 < mysql_num_rows( $query_group ) )
    {
        $arr_group = mysql_fetch_array( $query_group );
        $group_id = $arr_group['group_id'];
        $depart_id = $arr_group['depart_id'];
        $is_header = $arr_group['is_header'];
        $is_depart = $arr_group['is_depart'];
    }
    else
    {
        $group_id = 0;
        $depart_id = 0;
        $is_header = 0;
        $is_depart = 1;
    }
}
if ( $is_depart == 1 )
{
    $is_header = 0;
}
if ( 0 < $group_id && $Ishead == 1 )
{
   // $group_read = "disabled";
}
if ( 0 < $depart_id && $is_depart == 1 )
{
   // $depart_read = "disabled";
}
else
{
    $depart_read = "";
    $group_read = "";
}
$xWhereSQL = "";
$curParam = "";



/*  $Lsql = "select is_header from staff where id =  ".intval($_SESSION['UID']);
	$Lquery = mysql_query($Lsql);
	
	if( $Lquery  )
	{
		$Lrs = mysql_fetch_row($Lquery);
		
		if( $Lrs[0] > 0 )
		{
			 $Lsql = "SELECT id FROM `staff` where group_id in ( select group_id from staff where id = ".intval($_SESSION['UID']).")";
			$Lquery = mysql_query($Lsql);
			while( $Lrs = mysql_fetch_array($Lquery))
			{
				$Larr[] =  $Lrs['id'];
			}
			
			$Lsids = implode(',', $Larr);
		}
		else{
			$Lsids = intval($_SESSION['UID']);
		}
		
	}

	
$Losids = $Lsids;
 if( intval($_REQUEST['staf_uid']) > 0  )
 {
	$Lsids = intval($_REQUEST['staf_uid']) ;
	$curParam = $curParam."&staf_uid=".$Lsids."";
}*/


if($DEPART>0)
{
	if($GROUP>0)
	{
		if($SID>0 )
		{
			$xWhereSQL	= $xWhereSQL . " and a.sid=".$SID." ";
			$curParam	= $curParam . "&SID=".$SID."";
		}
		else
		{
			$xWhereSQL	= $xWhereSQL . " and a.sid in(select id from staff where group_id=".$GROUP.") ";
		}
		$curParam	= $curParam . "&GROUP=".$GROUP."";

	}
	else
	{
		$xWhereSQL	= $xWhereSQL . " and a.sid in(select id from staff where depart_id=".$DEPART.") ";
	}
	$curParam	= $curParam . "&DEPART=".$DEPART."";
}
if ( isset( $Symd, $Eymd ) )
{
    $yWhereSQL = $yWhereSQL." and (a.ymd  BETWEEN '".$Symd."' and '".$Eymd."')";
    $curParam = $curParam."&Symd=".$Symd."&Eymd=".$Eymd."";
}
if($STATUS == "已签收")
{
	$xWhereSQL = $xWhereSQL." and a.status in ('已签收','已结算')";
	$curParam = $curParam."&STATUS=".$STATUS."&FLAG=".$FLAG."";
}
elseif ( $STATUS != "0" )
{
    if ( $FLAG == 0 || $FLAG == "" )
    {
        $xWhereSQL = $xWhereSQL." and a.status = '已发货'";
    }
    else
    {
        $xWhereSQL = $xWhereSQL." and a.status = '".$STATUS."'";
    }
    $curParam = $curParam."&STATUS=".$STATUS."&FLAG=".$FLAG."";
}
if ( isset( $T_STATUS ) && 2 <= strlen( $T_STATUS ) )
{
    $xWhereSQL = $xWhereSQL." and a.t_status = '".$T_STATUS."'";
    $curParam = $curParam."&T_STATUS=".$T_STATUS."";
}
if ( isset( $trail_flag ) && 1 <= strlen( $trail_flag ) )
{
    if ( $trail_flag == "是" )
    {
        $xWhereSQL = $xWhereSQL." and a.trail_time <>'0000-00-00 00:00:00' ";
    }
    if ( $trail_flag == "否" )
    {
        $xWhereSQL = $xWhereSQL." and a.trail_time ='0000-00-00 00:00:00' ";
    }
    $curParam = $curParam."&trail_flag=".$trail_flag."";
}
if ( isset( $name ) && 2 <= strlen( $name ) )
{
    $xWhereSQL = $xWhereSQL." and a.name like '%".$name."%'";
    $curParam = $curParam."&name=".$name."";
}
if ( isset( $phone ) && 1 <= strlen( $phone ) )
{
	if(is_numeric($phone)){
		$phoneEn = do_jiami($phone);
		$xWhereSQL = $xWhereSQL." and a.telno like '%".$phoneEn."%'";
	}else
	{
		//$dePhone = do_jiemi($phone);
		$xWhereSQL = $xWhereSQL." and a.telno like '%".$phone."%'";
	}
    $curParam = $curParam."&phone=".$phone."";
}
if ( isset( $no ) && 1 <= strlen( $no ) )
{
    $xWhereSQL = $xWhereSQL." and a.no like '%".$no."%'";
    $curParam = $curParam."&no=".$no."";
}
if ( isset( $snum ) && 1 <= strlen( $snum ) )
{
    $xWhereSQL = $xWhereSQL." and b.snum like '%".$snum."%'";
    $curParam = $curParam."&snum=".$snum."";
}
if ( isset( $express_id ) && 1 <= $express_id )
{
    $xWhereSQL = $xWhereSQL." and a.express_id=".$express_id."";
    $curParam = $curParam."&express_id=".$express_id."";
}
if ( isset( $pdt_id ) && 1 <= $pdt_id )
{
    $xWhereSQL = $xWhereSQL." and find_in_set(".$pdt_id.",a.orderpro)";
    $curParam = $curParam."&pdt_id=".$pdt_id."";
}
if ( $first == 1 )
{
	$curParam = $curParam."&first=1";
}
if ( !isset( $page_id ) )
{
    $page_id = 1;
}
if ( !isset( $page_id ) )
{
    $page_id = 1;
}
$xWhereSQL = $xWhereSQL.$yWhereSQL;
if ( $first == 1 )
{
	$mycountSQL = "select count(a.id) as total,sum(a.total) as cc from morder a,hub_fen b where a.id=b.order_id  ".$xWhereSQL."";
}
//echo $mycountSQL;
$countquery = mysql_query( $mycountSQL );
if ( $countquery )
{
    $rows = mysql_fetch_row( $countquery );
    $ls_total = $rows[0];
	$total_all = $rows[1];
    $li_total = (int)$ls_total;
    $ls_total = ceil( $li_total / 15 );
}
if ( $page_id < 0 || $ls_total < $page_id )
{
    $page_id = $ls_total;
}
if ( $page_id == 0 )
{
    $page_id = 1;
}
?>
<html> 
<head>
 <meta http-equiv='Content-Language' content='zh-cn'> 
 <meta http-equiv='Content-Type' content='text/html; charset=gb2312'>

 <LINK REL='StyleSheet' HREF='../conf/bitcool.css' TYPE='text/css'>
<SCRIPT Language="JavaScript" src="../conf/bitcool.js"></SCRIPT> 
 <META HTTP-EQUIV='PRAGMA' CONTENT='NO-CACHE'> <title>客户订单跟踪</title> 
<script src='../jscss/functions.js' type='text/javascript' language='javascript'></script> 
<SCRIPT type='text/javascript' Language="JavaScript" src="../js/ajax.js"></SCRIPT> 
<script language="JavaScript">
 function showdate(i,j,k)
 {
	
	var exp =  'tiantian';
	var sno =  '997001333656';
    var url = "get.php?com="+exp+"&nu="+sno;
		request.open("GET", url, false);
		request.onreadystatechange = function(){
		 var tt;
		 if (request.readyState == 4)
			{
				if (request.status == 200)
				{
					tt=request.responseText;
					//alert(tt);
					var snum_show = document.getElementById('snum_show');
					
					var state_s = eval("("+tt+")");
					var str = '';
					snum_show.style.display = "block";  
					snum_show.style.top = ""+(200+k*25)+"px";
					if(state_s["status"]==0){
						str = state_s["message"];
					}else{
						for(var i=0;i<state_s["data"].length;i++)
						{
						  str = str+state_s["data"][i]["time"]+": "+state_s["data"][i]["context"]+"<br/>";
						}
					}
					  snum_show.innerHTML = str;
				}
			}
        }  

	request.send(null); 
 }
 function hidedata()
 {
	document.getElementById('snum_show').style.display = "none"; 
 } 




<?php

echo "\r\n//配送点联动开始\r\nfunction go_group(this_from)\r\n{\t\r\n\tvar e\t\t= this_from.form;\r\n\t//alert(e.DEPART.value.value);\r\n\tclear_group(e); \r\n\tclear_sid(e);\r\n\tvar tt\t=[];\r\n\tvar Ajax\t= new ajax();\r\n\tAjax.set_value('grp','depart_id',e.DEPART.value,'id,name');\r\n\ttt\t\t\t= Ajax.get_value();\r\n\t\r\n\tif(tt != null)\r\n\t{\r\n\t\tfor(var i=0;i<tt.length;i++)\r\n\t\t{\r\n\t\t\tstr\t= tt[i].split(\"|\");\r\n\t\t\taddOption_group(str[0],str[1],e);\r\n\t\t}\r\n\r\n\t}\r\n}\r\n\r\nfunction addOption_group(parm0,parm1,e)\r\n{\r\n\t\r\n\tif(parm0 > 0)\r\n\t{\r\n\t\tvar objSelect\t= e.GROUP;\r\n\r\n\t\t// 取得字段值\r\n\t\tvar strName\t\t= parm1;\r\n\t\tvar strValue\t= parm0;\r\n\t\t// 建立Option对象\r\n\t\tvar objOption = new Option(strName,strValue);\r\n\t\tobjSelect.add(objOption);\r\n\t}\r\n}\r\n\r\nfunction clear_group(e)\r\n{\r\n\tfor(i=e.GROUP.length;i>0;i--)\r\n\t{\r\n\t\te.GROUP.options[i]\t= null;\r\n\t}\r\n}\r\n\r\nfunction go_sid(this_from)\r\n{\t\r\n\tvar e\t\t= this_from.form;\r\n\t//alert(e.DEPART.value.value);\r\n\tclear_sid(e);\r\n\tvar tt\t=[];\r\n\tvar Ajax\t= new ajax();\r\n\tAjax.set_value('staff','group_id',e.GROUP.value,'id,name');\r\n\ttt\t\t\t= Ajax.get_value();\r\n\t\r\n\tif(tt != null)\r\n\t{\r\n\t\tfor(var i=0;i<tt.length;i++)\r\n\t\t{\r\n\t\t\tstr\t= tt[i].split(\"|\");\r\n\t\t\taddOption_sid(str[0],str[1],e);\r\n\t\t}\r\n\r\n\t}\r\n}\r\n\r\nfunction addOption_sid(parm0,parm1,e)\r\n{\r\n\t\r\n\tif(parm0 > 0)\r\n\t{\r\n\t\tvar objSelect\t= e.SID;\r\n\r\n\t\t// 取得字段值\r\n\t\tvar strName\t\t= parm1;\r\n\t\tvar strValue\t= parm0;\r\n\t\t// 建立Option对象\r\n\t\tvar objOption = new Option(strName,strValue);\r\n\t\tobjSelect.add(objOption);\r\n\t}\r\n}\r\n\r\nfunction clear_sid(e)\r\n{\r\n\tfor(i=e.SID.length;i>0;i--)\r\n\t{\r\n\t\te.SID.options[i]\t= null;\r\n\t}\r\n}\r\n\r\n//-->\r\n</script>\r\n</head>\r\n<body>\r\n<form name=\"search_info\" method=\"post\" action=\"\" onSubmit=\"\">\r\n<input type=\"hidden\" name=\"first\" value=\"0\">\r\n<input type=\"hidden\" name=\"curParam\" value=\"";
echo $curParam;
echo "\">\r\n<table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" class=\"lm_table_ds\">\r\n  <tr>\r\n    <td class=\"lm_table_top\" align=\"center\">\r\n        <table width=\"98%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\" align=\"center\">\r\n            <td height=\"30\" class=\"bigtxt3\">客户订单跟踪</td>\r\n\r\n\t\t\t<td align=\"right\" height=\"6\" class=\"lm_table_top\" width=70%>\r\n\t\t\t";
echo $page_id."/".$ls_total."页&nbsp&nbsp";
echo "<a href='".$_SERVER['PHP_SELF']."?page_id=1".$curParam."'>首页</a>|\n";
echo ( "<a href='".$_SERVER['PHP_SELF']."?page_id=".( $page_id - 1 ) ).$curParam."'>前页</a>|\n";
echo ( "<a href='".$_SERVER['PHP_SELF']."?page_id=".( $page_id + 1 ) ).$curParam."'>后页</a>|\n";
echo "<a href='".$_SERVER['PHP_SELF']."?page_id=-1".$curParam."'>尾页</a>|\n";
echo "&nbsp&nbsp共".$li_total."条记录,共".number_format($total_all/100,'','.',',')."金额";
echo "转至<input type='text' name='page_id' size='3' maxlength='3'>页";
echo "      \r\n\t\t\t</td>\r\n          </tr>\r\n        </table>\r\n      </td>\r\n  </tr>\r\n</table>\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"lm_table_ds\">\r\n  <tr>\r\n    <td align=\"center\" height=\"2\" class=\"lm_table_bs\"></td>\r\n  </tr>\r\n</table>\r\n  <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\" class=\"lm_table_ds\">\r\n    <tr>\r\n      <td width=\"8%\" align=\"right\" class=\"bggl_table6\">下单时间";
echo "</td>\r\n      <td class=\"lm_table_bs\" colspan=3>";
$times_a = $Symd ? $Symd : date( "Y-m-d" )." ".$_SESSION['STATIC_TIME'];
$calendar->make_input_field( array(
    "firstDay" => 1,
    "showsTime" => true,
    "showOthers" => true,
    "ifFormat" => "%Y-%m-%d %H:%M:%S",
    "timeFormat" => "24"
), array(
    "style" => "",
    "name" => "Symd",
    "value" => $times_a
) );
echo "  到  \r\n\t\t\t ";
$times_b = $Eymd ? $Eymd : date( "Y-m-d", strtotime( "+1 days" ) )." ".$_SESSION['STATIC_TIME'];
$calendar->make_input_field( array(
    "firstDay" => 1,
    "showsTime" => true,
    "showOthers" => true,
    "ifFormat" => "%Y-%m-%d %H:%M:%S",
    "timeFormat" => "24"
), array(
    "style" => "",
    "name" => "Eymd",
    "value" => $times_b
) );
echo "\t\t\t \r\n\t\t\t \r\n\t\t\t </td>\r\n      <td width=\"8%\" align=\"right\" class=\"bggl_table6\">订单状态</td>\r\n      <td width=\"10%\" class=\"lm_table_bs\">\r\n\t  \r\n\t  \t\t\t";
echo "<S";
echo "ELECT NAME=STATUS>\r\n\t\t\t\t";
if ( $STATUS == "" )
{
    echo "\t\t\t\t\t<OPTION value='已发货' SELECTED>物流已发货</OPTION>\t\t\t\t\r\n\t\t\t\t\t<OPTION value='物流退单'>物流已退单</OPTION>\r\n\t\t\t\t\t<OPTION value='已签收'>客户已签收</OPTION>\r\n\t\t\t\t<OPTION value='已退库'>物流已退库</OPTION>\r\n\t\t\t\t";
}
else
{
    echo "\t\t\t\t\t<OPTION value='已发货' ";
    if ( $STATUS == "已发货" )
    {
        echo "selected";
    }
    echo ">物流已发货</OPTION>\t\t\t\t\r\n\t\t\t\t\t<OPTION value='物流退单' ";
    if ( $STATUS == "物流退单" )
    {
        echo "selected";
    }
    echo ">物流已退单</OPTION>\r\n\t\t\t\t\t<OPTION value='已签收' ";
    if ( $STATUS == "已签收" )
    {
        echo "selected";
    }
    echo ">已签收</OPTION>\r\n\t\t\t\t\t<OPTION value='已退库' ";
    if ( $STATUS == "已退库" )
    {
        echo "selected";
    }
	 echo ">已退库</OPTION>\r\n\t\t\t\t\t";
}
echo "\t\t\t</SELECT>\r\n\t  </td>\r\n      <td width=\"8%\" align=\"right\" class=\"bggl_table6\">跟踪结果</td>\r\n      <td width=\"10%\" align=\"right\" class=\"lm_table_bs\">\r\n\t  \r\n\t\t";
echo "<S";
echo "ELECT NAME=T_STATUS>\r\n\t\t    <option value=''>-请选择-</option>\r\n\r\n\t\t\t";
$myIDSQL = "select name from follow_type";
$myIDRS = mysql_query( $myIDSQL );
while ( $myIDArray = mysql_fetch_array( $myIDRS ) )
{
    if ( $T_STATUS == $myIDArray['name'] )
    {
        echo " <option value=\"".$myIDArray['name']."\" selected>".$myIDArray['name']."</option>\n";
    }
    else
    {
        echo " <option value=\"".$myIDArray['name']."\">".$myIDArray['name']."</option>\n";
    }
}
echo "\t\t</SELECT>\r\n\r\n\t  </td>\r\n\r\n      <td width=\"8%\" align=\"center\" class=\"bggl_table6\" rowspan=4>\r\n\t  <input type=\"hidden\" name=\"FLAG\" value=\"1\">\r\n\t  <input type=\"button\" value=\"查询\" name=\"ACTION\" onClick=\"beforeSubmit(1)\" class=btn4>\r\n    </tr>\r\n\t<tr>\r\n\t  <td align=\"right\" class=\"bggl_table6\">订单编号</td>\r\n      <td width=\"20%\" class=\"lm_table_bs\"><input name=\"no\" type=\"text\"  size=14 value=\"";
echo $no;
echo "\"></td>\r\n      <td width=\"8%\" align=\"right\" class=\"bggl_table6\">客户姓名</td>\r\n      <td width=\"25%\" class=\"lm_table_bs\"><input name=\"name\" type=\"text\"  size=9 value=\"";
echo $name;
echo "\"></td>\r\n      <td width=\"8%\" align=\"right\" class=\"bggl_table6\">送货电话</td>\r\n      <td width=\"15%\" class=\"lm_table_bs\"><input name=\"phone\" type=\"text\" size=12 value=\"";
echo $phone;
echo "\"/></td>\r\n      <td width=\"8%\" align=\"right\" class=\"bggl_table6\">是否跟踪</td>\r\n      <td width=\"14%\" class=\"lm_table_bs\">\r\n\t\t\t";
echo "<S";
echo "ELECT NAME=trail_flag>\r\n\t\t\t\t<OPTION value=''>-请选择-</OPTION>\r\n\t\t\t\t<OPTION value='是' ";
if ( $trail_flag == "是" )
{
    echo "selected";
}
echo ">是</OPTION>\t\t\t\t\r\n\t\t\t\t<OPTION value='否' ";
if ( $trail_flag == "否" )
{
    echo "selected";
}
echo ">否</OPTION>\r\n\t\t\t</SELECT>\r\n\r\n\t  </td>\r\n\r\n\r\n\t</tr>\r\n\t<tr>\r\n\r\n\t   <td align=\"right\" class=\"bggl_table6\">快递公司</td>\r\n\t   <td class=\"lm_table_bs\" >\r\n\t\t";
echo "<s";
echo "elect name=\"express_id\">         \r\n\t\t\t";
echo "<option value=0>-请选择-</option>";
$sql_exp = "select id,name from express order by sno";
$query_exp = mysql_query( $sql_exp );
while ( $arr_exp = mysql_fetch_array( $query_exp ) )
{
    if ( $express_id == $arr_exp['id'] )
    {
        echo "<option value=\"".$arr_exp['id']."\" selected>".$arr_exp['name']."</option>";
    }
    else
    {
        echo "<option value=\"".$arr_exp['id']."\">".$arr_exp['name']."</option>";
    }
}
echo "\t\t</select>\r\n\t\t</td>\r\n\t  <td align=\"center\" class=\"bggl_table6\">产品名称</td>\r\n\t\t<td class=\"lm_table_bs\">\r\n\t\t";
echo "<S";
echo "ELECT NAME=\"pdt_id\">\r\n\t\t<OPTION VALUE=\"0\" SELECTED>请选择</OPTION>\r\n\t\t";
$sql_group_s1	= "select id,name from product  order by no";
$query_group_s1	= mysql_query($sql_group_s1);
				while($arr_group_s1=mysql_fetch_array($query_group_s1))
				{
					if($pdt_id==$arr_group_s1["id"])
					{
					echo "<option value=\"".$arr_group_s1["id"]."\" selected>".$arr_group_s1["name"]."</option>";
					}
					else
					{
					echo "<option value=\"".$arr_group_s1["id"]."\">".$arr_group_s1["name"]."</option>";
					}
				}
echo "\t\t</SELECT>\t  \r\n\t  </td>\r\n\r\n       <td align=\"right\" class=\"bggl_table6\">工作组别</td>\r\n\t   <td class=\"lm_table_bs\" colspan=3>\r\n       ";
if ( $depart_id == 0 && $is_depart == 1 )
{
    echo "\t   <select name=\"DEPART\" onclick=\"go_group(this)\">         \r\n\t\t\r\n\t\t<option value=''>请选择</option>";
    $sql_depart = "select id,name from depart where s_flag='是' order by sno";
    $query_depart =  mysql_query( $sql_depart );
    while ( $arr_depart = mysql_fetch_array( $query_depart ) )
    {
        if ( $DEPART == $arr_depart['id'] )
        {
            echo "<option value=\"".$arr_depart['id']."\" selected>".$arr_depart['name']."</option>";
        }
        else
        {
            echo "<option value=\"".$arr_depart['id']."\">".$arr_depart['name']."</option>";
        }
    }
    echo "\t\t</select>\r\n\t\t<select name=\"GROUP\" size=\"1\" onclick=\"go_sid(this)\">\r\n\t\t<option value=''>请选择</option>\r\n\t\t";
    $sql_group_s = "select id,name from grp where depart_id=".$DEPART." order by no";
    $query_group_s =  mysql_query( $sql_group_s );
    while ( $arr_group_s = mysql_fetch_array( $query_group_s ) )
    {
        if ( $GROUP == $arr_group_s['id'] )
        {
            echo "<option value=\"".$arr_group_s['id']."\" selected>".$arr_group_s['name']."</option>";
        }
        else
        {
            echo "<option value=\"".$arr_group_s['id']."\">".$arr_group_s['name']."</option>";
        }
    }
    echo "\t\t</select>\r\n\t\t<select name=\"SID\" size=\"1\" >\r\n\t\t<option value=''>请选择</option>\r\n\t\t";
    $sql_staff_s = "select id,name,no from staff where depart_id=".$DEPART."  and group_id=".$GROUP." order by no";
    $query_staff_s =  mysql_query( $sql_staff_s );
    while ( $arr_staff_s = mysql_fetch_array( $query_staff_s ) )
    {
        if ( $SID == $arr_staff_s['id'] )
        {
            echo "<option value=\"".$arr_staff_s['id']."\" selected>[".$arr_staff_s['no']."]".$arr_staff_s['name']."</option>";
        }
        else
        {
            echo "<option value=\"".$arr_staff_s['id']."\">[".$arr_staff_s['no']."]".$arr_staff_s['name']."</option>";
        }
    }
    echo "\t\t</select>\r\n\r\n       ";
}
if ( 0 < $depart_id && $is_depart == 1 )
{
    echo "\t   <select name=\"DEPART\"> \r\n\t     <option value='";
    echo $depart_id;
    echo "' ";
    echo $depart_read;
    echo ">";
    echo code_names( "depart", $depart_id, "name" );
    echo "</option>\r\n\t\t</select>\r\n\t\t<select name=\"GROUP\" size=\"1\" onclick=\"go_sid(this)\">\r\n\t\t<option value=''>请选择</option>\r\n\t\t";
    $sql_group_s = "select id,name from grp where depart_id=".$depart_id." order by no";
    $query_group_s =  mysql_query( $sql_group_s );
    while ( $arr_group_s = mysql_fetch_array( $query_group_s ) )
    {
        if ( $GROUP == $arr_group_s['id'] )
        {
            echo "<option value=\"".$arr_group_s['id']."\" selected>".$arr_group_s['name']."</option>";
        }
        else
        {
            echo "<option value=\"".$arr_group_s['id']."\">".$arr_group_s['name']."</option>";
        }
    }
    echo "\r\n\t\t</select>\r\n\t\t<select name=\"SID\" size=\"1\" >\r\n\t\t<option value=''>请选择</option>\r\n\t\t";
    $sql_staff_s = "select id,name,no from staff where depart_id=".$DEPART."  and group_id=".$GROUP." order by no";
    $query_staff_s =  mysql_query( $sql_staff_s );
    while ( $arr_staff_s = mysql_fetch_array( $query_staff_s ) )
    {
        if ( $SID == $arr_staff_s['id'] )
        {
            echo "<option value=\"".$arr_staff_s['id']."\" selected>[".$arr_staff_s['no']."]".$arr_staff_s['name']."</option>";
        }
        else
        {
            echo "<option value=\"".$arr_staff_s['id']."\">[".$arr_staff_s['no']."]".$arr_staff_s['name']."</option>";
        }
    }
    echo "\t\t</select>\r\n\r\n       ";
}
if ( 0 < $group_id && $is_header == 1 )
{
    echo "\t   <select name=\"DEPART\"> \r\n\t     <option value='";
    echo $depart_id;
    echo "' ";
    echo $depart_read;
    echo ">";
    echo code_names( "depart", $depart_id, "name" );
    echo "</option>\r\n\t\t</select>\r\n\t\t<select name=\"GROUP\" size=\"1\">\r\n\t     <option value='";
    echo $group_id;
    echo "' ";
    echo $group_read;
    echo ">";
    echo code_names( "grp", $group_id, "name" );
    echo "</option>\r\n\t\t</select>\r\n\t\t<select name=\"SID\" size=\"1\" >\r\n\t\t<option value=''>-请选择-</option>\r\n\t\t";
    $sql_staff_s = "select id,name,no from staff where depart_id=".$depart_id."  and group_id=".$group_id." order by no";
    $query_staff_s = @ mysql_query( $sql_staff_s );
    while ( $arr_staff_s = mysql_fetch_array( $query_staff_s ) )
    {
        if ( $SID == $arr_staff_s['id'] )
        {
            echo "<option value=\"".$arr_staff_s['id']."\" selected>[".$arr_staff_s['no']."]".$arr_staff_s['name']."</option>";
        }
        else if ( $staff_sid == $arr_staff_s['id'] && $SID == "" )
        {
            echo "<option value=\"".$arr_staff_s['id']."\" selected>[".$arr_staff_s['no']."]".$arr_staff_s['name']."</option>";
        }
        else
        {
            echo "<option value=\"".$arr_staff_s['id']."\">[".$arr_staff_s['no']."]".$arr_staff_s['name']."</option>";
        }
    }
    echo "\t\t</select>\r\n\r\n       ";
}
if ( 0 < $group_id && $is_header == 0 && $is_depart == 0 )
{
    echo "\t   <select name=\"DEPART\"> \r\n\t     <option value='";
    echo $depart_id;
    echo "' ";
    echo $depart_read;
    echo ">";
    echo code_names( "depart", $depart_id, "name" );
    echo "</option>\r\n\t\t</select>\r\n\t\t<select name=\"GROUP\" size=\"1\">\r\n\t     <option value='";
    echo $group_id;
    echo "' ";
    echo $group_read;
    echo ">";
    echo code_names( "grp", $group_id, "name" );
    echo "</option>\r\n\t\t</select>\r\n\t\t<select name=\"SID\" size=\"1\" >\r\n\t     <option value='";
    echo $UID;
    echo "' ";
    echo $sid_read;
    echo ">";
    echo code_names( "staff", $UID, "name" );
    echo "</option>\r\n\t\t</select>\r\n\r\n       ";
}
echo "\t\t\r\n\t </td>\r\n\t  <!--td width=\"8%\" align=\"right\" class=\"bggl_table6\">跟踪次数</td>\r\n      <td width=\"14%\" class=\"lm_table_bs\"> </td-->\r\n\t  </tr>\r\n";
?>
<tr>
<td align="right" class="bggl_table6">
详情单号
</td>
<td class="lm_table_bs" colspan=7>
<input type=text name="snum" value="<?php echo $snum;?>" size=15 >
</td>
</tr>
<?php
echo "</table>\r\n</form>\r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"lm_table_ds\">\r\n  <tr>\r\n    <td align=\"center\" height=\"2\" b";
echo "gcolor=#66cccc></td>\r\n  </tr>";
?>
<?php
echo "\r\n</table>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\" class=\"lm_table_ds\">\r\n  <tr class=\"lm_table_d\">\r\n    <td width=\"5%\" align=\"center\">选择</td>\r\n    <td width=\"12%\" align=\"center\">订单编号</td>\r\n    <td width=\"8%\" align=\"center\">客户姓名</td>\r\n    <!--td width=\"12%\" align=\"center\">收件人电话</td>\r\n    <td width=\"16%\" align=\"center\">订单商品</td-->\r\n\t<td width";
echo "=\"8%\" align=\"center\">订单金额</td>\r\n    <td width=\"9%\" align=\"center\">订单状态</td>\r\n    <td width=\"9%\" align=\"center\">发货日期</td>\r\n    <td width=\"8%\" align=\"center\">快递公司</td>\r\n    <td width=\"11%\" align=\"center\">详情单号</td>\r\n    <td width=\"9%\" align=\"center\">跟踪结果</td>\r\n    <td width=\"17%\" align=\"center\">跟踪时间</td>\r\n    <td width=\"8%\" align=\"center\" >操作</td>\r\n  </tr>\r\n ";
$curRecord = ( $page_id - 1 ) * 15;
if ( $first == 1 )
{
   $mySQL = "select a.*,b.snum,b.f_time from morder a,hub_fen b where a.id=b.order_id ".$xWhereSQL." order by a.trail_time asc,a.express_id LIMIT ".$curRecord.",15 ";
}
//echo $mySQL;
$myRS = mysql_query( $mySQL );
if ( $myRS )
{
	$i =1;
    while ( $myArray = mysql_fetch_array( $myRS ) )
    {
        $myProductList = get_order_product( $myArray['id'] );
        $curExpName = code_name( "express", $myArray['express_id'] );
		$curExpweb = code_names( "express", $myArray['express_id'],'website');
        $curExpweb = $curExpweb?$curExpweb:'http://www.kuaidi100.com/';
		$curTypeStr = "";
        $myFollowSQL = "select follow_id,optr_time from follow_order where order_id=".$myArray['id']." order by id DESC LIMIT 0,1";
        $myFollowRS = mysql_query( $myFollowSQL );
        if ( $myFollowRS )
        {
            $myFollowArray = mysql_fetch_array( $myFollowRS );
            $follow_time = $myFollowArray['optr_time'];
            $myTypeSQL = "select name from follow_type where id=".$myFollowArray['follow_id']."";
            $myTypeRS = mysql_query( $myTypeSQL );
            if ( $myTypeRS )
            {
                $myTypeArr = mysql_fetch_array( $myTypeRS );
                $curTypeStr = $myTypeArr['name'];
            }
        }
		$url = "ORDER_ID=".$myArray["id"];
		$url_encode = do_jiami($url);
		$url_MGID = "MGID=".$myArray["mid"];
		$url_MGID_encode = do_jiami($url_MGID);
        echo " \r\n\t";
        printf( "<TR class='txt0' bgcolor=#EEEEEE onmouseover=\"setPointer(this, %d, 'over', '#EEEEEE', '#EEEEEE', '#EEEEEE');\" onmouseout=\"setPointer(this, %d, 'out', '#EEEEEE', '#EEEEEE', '#EEEEEE');\" onmousedown=\"setPointer(this, %d, 'click', '#EEEEEE', '#EEEEEE', '#FFCC99');\">\n", $i, $i, $i );
        echo "    <td align=\"center\"><input type=\"checkbox\" name=\"ID\" value=\"";
        echo $myArray['id'];
        echo "\"></td>\r\n    <td align=\"center\"><a href=\"../complain/my_order_list.php?parm=";
        echo $url_encode;
        echo "\" onClick=\"window.open(this.href,'','toolbar=no,menubar=no,location=no,resizable=yes,width=800,height=400,scrollbars=yes,resizable=yes','_blank');return false;\">";
        echo $myArray['no'];
        echo "</a></td>\r\n    <td align=\"center\"><a href=\"../vip/member_info.php?parm=";
        echo $url_MGID_encode;
		//echo $url_MGID_encode;
        echo "\" onclick=\"window.open(this.href,'','toolbar=no,menubar=no,location=no,resizable=yes,width=800,height=400,scrollbars=yes,resizable=yes','_blank');return false;\">";
        echo $myArray['name'];
        echo "</a></td>\r\n    <!--td align=\"left\">";
        echo $myArray['telno'];
        echo "</td>\r\n    <td align=\"left\">";
        echo $myProductList;
        echo "</td-->\r\n    <td align=\"center\">";
        echo number_format( $myArray['total'] / 100, "", ".", "," );
        echo "</td>\r\n    <td align=\"center\">";
        echo $myArray['status'];
        echo "</td>\r\n    <td align=\"center\">";
        echo substr( $myArray['f_time'], 0, 10 );
        echo "</td>\r\n    <td align=\"center\">";
        echo $curExpName;
        echo "</td>\r\n    <td align=\"center\"><a onmouseover=showdate('".$myArray['express_id']."','".$myArray['snum']."',".$i.")  onmouseout=hidedata()>";
        echo $myArray['snum'];
        echo "</a></td>\r\n    <td align=\"center\">";
        echo $curTypeStr;
        echo "</td>\r\n    <td align=\"center\">";
        echo $follow_time;
        echo "</td>\r\n    <td align=\"center\" ><input name=button type=button value='跟踪' onclick=\"window.open('follow_do.php?id=";
        echo $myArray['id'];
        echo "&order_id=";
        echo $myArray['id'];
        echo "','','top=50,left=100,width=900,height=600,scrollbars=yes,resizable=yes','_blank')\" style='color:blue' class=btn1></td>\r\n  </tr>\r\n";
      $i++;
	}
	
} 
?>
</table>
<div id="snum_show" style="display:none;background-color:#ccc;font-size:14px;position:absolute;top:200px;left:200px;width:500px;min-height:100px;border:1px solid #eee;">
</div>
</body>
</html>
<SCRIPT language="javascript1.2">
function beforeSubmit(indexAction)
{
	var e 		= document.search_info;
	var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/;
	var ls_tmp1	= new String("");
	var ls_tmp2	= new String("");
	ls_tmp1		= e.Symd.value;
	ls_tmp2		= e.Eymd.value;
	var r = ls_tmp1.match(reg);
	var r1 = ls_tmp2.match(reg);
	if(r==null||r1==null)
	{
		alert("日期不合法,请重新输入");
		e.Symd.focus();
		return false;
	}
	if(e.STATUS.value != '已发货')
	{
		e.FLAG.value = 1;
	}
	document.search_info.first.value = 1;
	e.submit();
}
</SCRIPT>
