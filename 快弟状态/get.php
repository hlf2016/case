<?php
$typeCom = $_GET["com"];//��ݹ�˾
$typeNu = $_GET["nu"];  //��ݵ���

//echo $typeCom.'<br/>' ;
//echo $typeNu ;
 $AppKey='8e0c1eed5fd18d0c';//�뽫XXXXXX�滻������http://kuaidi100.com/app/reg.html���뵽��KEY
$url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=0&muti=1&order=aesc';

//����ɾ������$powered ����Ϣ�����߱�վ������Ϊ���ṩ��ݽӿڷ���
$powered = '��ѯ�����ɣ�<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com �����100��</a> ��վ�ṩ ';


//����ʹ��curlģʽ��������
if (function_exists('curl_init') == 1){
  $curl = curl_init();
  curl_setopt ($curl, CURLOPT_URL, $url);
  curl_setopt ($curl, CURLOPT_HEADER,0);
  curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
  curl_setopt ($curl, CURLOPT_TIMEOUT,5);
  $get_content = curl_exec($curl);
  curl_close ($curl);
}else{
  include("snoopy.php");
  $snoopy = new snoopy();
  $snoopy->referer = 'http://www.google.com/';//αװ��Դ
  $snoopy->fetch($url);
  $get_content = $snoopy->results;
}
echo iconv('utf-8','gb2312',$get_content); 
?>
