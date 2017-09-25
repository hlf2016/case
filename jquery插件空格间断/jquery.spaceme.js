 (function ($) {
      $.fn.spaceme = function (options) { //定义插件方法名
            options = $.extend({
                //定义一个对象，设置默认值
              name: 'Steven Zhu', //名
               email: 'zhuttymore@126.com', //链接
              size: '14px', //文字大小
               align: 'center '//文字位置，left || center || right
              },options); 
           var old_str = this.val(); 
           old_str_arr = old_str.split(',');
           var container = '<div class="chosen-container chosen-container-multi" style="width: 271px;" ><ul class="chosen-choices">';
           for(var i=0;i<old_str_arr.length;i++)
           {
           		container+='<li class="search-choice"><span>'+old_str_arr[i]+'</span><a class="search-choice-close" data-option-array-index="1"></a></li>';
           }
           container+='<li class="search-field"><input    style="width: 35px;"  type="text"></li></ul></div>';
           this.before(container);
           var obj = this;
          this.hide();
           	$(".chosen-container:not(.search-choice)").click(function(){
           		$(this).find("input").focus();
           	});
            $(".chosen-container input").keydown(function(e){
			    if(!e) var e = window.event; 
			    if(e.keyCode==32||e.keyCode==188){  
			         var str = $(this).val(); 
			         if(/^ *$/.test(str)!=true)
			         {
			         	var html = '<li class="search-choice"><span>'+str+'</span><a class="search-choice-close" data-option-array-index="1"></a></li>';
				         $(this).parent().before(html);
				         
			         } 
			        $(this).val(''); 
			        var consume = '';
			        $(this).parent().prevAll().children("span").each(function(){
			        	consume+=$(this).text()+',';
					}); 
					$(this).parent().parent().parent().next().val(consume);
			    }
			 }); 
            $(".chosen-container").on("click",".search-choice-close",function(){
            	obj_par = $(this).parent().parent();
            	$(this).parent().remove(); 
            	var consume = '';   
            	obj_par.find("span").each(function(){
			        	consume+=$(this).text()+',';
				}); 
				obj_par.parent().next().val(consume); 
            });
            return this;
        }
})(window.jQuery);