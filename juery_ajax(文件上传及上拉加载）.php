 <script type="text/javascript">
	//传输file文件
	e = document.advert;
	var formData = new FormData();
	formData.append("file",$("#upload")[0].files[0]);
	formData.append("title",e.title.value);
	formData.append("descri",e.descri.value);
	formData.append("tel",e.tel.value);
	formData.append("link_id",e.link_id.value);
	formData.append("user_id",e.user_id.value);
	formData.append("token",e.token.value);
	Url = 'http://www.askme.com/api/adv/add';
	$("#popwiow").hide();
	  $.ajax({  
			type:"POST", 
			url:Url,  
			dataType: "json",   
			data:formData, 
		   // 告诉jQuery不要去处理发送的数据
			processData : false, 
			// 告诉jQuery不要去设置Content-Type请求头
			contentType : false,
			jsonp:'callback',  
			success:function(result) {  
				alert(result['msg']); 
			}
		});  
		
		
	//下拉加载
	$(window).scroll(function(){  
		range = 0;
		var srollPos = $(window).scrollTop();    //滚动条距顶部距离(页面超出窗口的高度)  
		  
		//console.log("滚动条到顶部的垂直高度: "+$(document).scrollTop());  
		//console.log("页面的文档高度 ："+$(document).height());  
		//console.log('浏览器的高度：'+$(window).height());  
		  
		totalheight = parseFloat($(window).height()) + parseFloat(srollPos);  
		if(($(document).height()-range) <= totalheight ) {  
		   $('#download').show(); 
			this.page = this.page+1;
			var formData = new FormData();
			formData.append("cate",6);
			formData.append("page",this.page);
			Url = 'http://www.askme.com/api/article/list'; 
			$.ajax({  
				type:"POST", 
				url:Url,  
				dataType: "json",   
				data:formData, 
			   // 告诉jQuery不要去处理发送的数据
				processData : false, 
				// 告诉jQuery不要去设置Content-Type请求头
				contentType : false,
				jsonp:'callback',  
				success:function(result) {  
					if(result.code==0){
						if(result.data.length<1)
						{
							$('#download').text('没有更多了');
						}
						for(var i=0;i<result.data.length;i++)
						{
							$('.in-mid ul').append(
									'<a href="article.php?article_id='+result.data[i].id+'"><li style="list_style:none;" class="clearfix"><span class="in-img1 fl"><img src="'+result.data[i].logo[0]+'" alt=""></span><div class="fl in-wz"><p class="in-p1">'+result.data[i].title+'</p><p class="in-p2">'+result.data[i].source+'</p></div></li></a>');
						}
					}

				}
			});  
		}  
	｝
</script>