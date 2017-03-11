<?php
    $str = '<div class="J-article-content article-content" id="content">
<p class="section txt">他本是很有希望的95后明星，早早成名的他却多次犯错，最终在21岁的年纪之下自毁前程，他就是来自台湾省的王欣逸！</p>
<figure class="section img">
<a class="img-wrap" data-size="299x135" href="/mobile/20170306/746a1e87d091bc5d3d27b7f78c6fcb06.jpeg" width="100%"/></a>
</figure>
<p class="section txt">王欣逸</p>
<p class="section txt">王欣逸出生于表演世家，2个哥哥也都是童星出身，王欣逸7岁之时通过参加《我猜我猜我猜猜猜》而出道，当时这档节目在吴宗宪的主持之下也是相当火爆，此后，王欣逸就参加了多部影视作品！</p>
<figure class="section img">
<a class="img-wrap" data-size="289x210" href="/mobile/20170306/0766db0f8093187d88397d1697226d05.jpeg" width="100%"/></a>
</figure>
<p class="section txt">王欣逸</p>
<p class="section txt">9岁之时，王欣逸凭借和张韶涵、霍建华主演的《海豚湾恋人》而一举成名，他在剧中出演可爱的“达达”一角而备受关注！</p>
<figure class="section img">
<a class="img-wrap" data-size="439x313" href="/mobile/20170306/cdb1bec43690b48253fc189aa15a5823.jpeg" width="100%"/></a>
</figure>
<p class="section txt">王欣逸</p>
<p class="section txt">此后王欣逸又参演了立威廉主演的《森林时光》，贺军翔和杨丞琳主演的《恶魔在身边》，彭于晏和张韶涵、张智尧主演的《海豚爱上猫》，罗志祥、安以轩主演的《斗鱼2》等作品，人气更是进一步飙升！</p>
<figure class="section img">
<a class="img-wrap" data-size="311x380" href="/mobile/20170306/45ac538012f4490cc9b6a8962179c7cf.jpeg" width="100%"/></a>
</figure>
<p class="section txt">王欣逸</p>
<p class="section txt">不过后来年仅12岁的王欣逸就传出和14岁女粉丝的绯闻，两人在这么小的年纪就玩这样的游戏，也只能说是父母管教问题了，此后王欣逸的人气就直线下跌了！</p>
<figure class="section img">
<a class="img-wrap" data-size="373x517" href="/mobile/20170306/e2876f7312406c558f66682a7af8f77d.jpeg" width="100%"/></a>
</figure>
<p class="section txt">王欣逸</p>
<p class="section txt">后来上了初中之后，王欣逸成为了一个全校知名的“坏学生”，各种逃课、打架、抽烟、纹身样样精通！</p>
<figure class="section img">
<a class="img-wrap" data-size="608x365" href="/mobile/20170306/2dbe8b87321f615952ed0028ee6e3132.jpeg" width="100%"/></a>
</figure>
<p class="section txt">王欣逸</p>
<p class="section txt">21岁之时，王欣逸更是由于帮朋友”出头“，在打架过程中下手太重而导致他人重伤，最终被送去管制了！</p>
<figure class="section img">
<a class="img-wrap" data-size="408x478" href="/mobile/20170306/96ac54605e79acd57767ce4c55b4f380.jpeg" width="100%"/></a>
</figure>
<p class="section txt">王欣逸</p>
<p class="section txt">曾经最有前途的95后童星，而如今竟然变成了问题少年，王欣逸的成长经历当真是令人感叹啊，正所谓养不教父之过，王欣逸的父母对此负有不可推卸的责任！</p>

</div>
';
   if(preg_match_all("/<a\s{0,4}class=\"img-wrap\"\s{0,4}data-size=\"[0-9]{3}x[0-9]{3}\"\s{0,4}href=\"(.*)\"\s{1}width=\"100%\"\/><\/a>/",$str,$new)){
	   print_r($new);
   }else{
	   echo '未找到';
   }
   
   
   $patter = "/<a\s{1,2}class=\"img-wrap\"\s{1,2}data-size=\"[0-9]{3}x[0-9]{3}\"\s{1,2}href=\"(.*)\"\s{1}width=\"100%\"\/><\/a>/";
   $replace = "<img src=\"$1\"  width=\"30%\"></img>";
   echo preg_replace($patter,$replace,$str);
?>