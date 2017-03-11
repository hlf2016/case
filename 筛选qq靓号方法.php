$qqNs = array("4323254","5123123","23412341234");
$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
 
foreach($qqNs as $tmp){
    $max = 1;
    $qq = $tmp;
    while($qq){
        for($i=1,$n = floor((strlen($qq)/2));$i <= $n;$i++){
            $preTree = substr($qq, 0, $i);
            $postTree = substr($qq,$i,$i);
            if($preTree == $postTree){
                if($i>=$max){
                    $max = $i;
                }
            }
        }
        $qq = substr($qq,1);
    }
	echo $tmp.":  ".substr($str,0,$max)."<br/>";
}



function bbqq($number_arr){ 
  foreach($number_arr as $key => $number)
  {
    $str='ABCDEF';  
	for($k=2;$k<5;$k++){
		for($i=0;$i<(strlen($number)-$k);$i++)
		{
			if(substr($number,$i,$k)==substr($number,($k+$i),$k))
			{
				$temp2[substr($str,0,$k).substr($str,0,$k)][] = substr($number,0,$i)."<span style='color:red;'>".substr($number,$i,$k*2)."</span>".substr($number,($i+$k*2))."<br/>";
			}
		}
	}
  }
	return $temp2;
}
$ppp = bbqq('40323234');
print_r($ppp);