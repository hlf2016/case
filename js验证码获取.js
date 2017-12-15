<script type="text/javascript">
        var InterValObj; //timer变量，控制时间
        var count = 60; //间隔函数，1秒执行
        var curCount;//当前剩余秒数
        function sendMessage() {
          　curCount = count;
        　　//设置button效果，开始计时
             $("#btnSendCode").attr("disabled", "true");
             $("#btnSendCode").text("请在" + curCount + "秒内输入验证码");
             InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
        　　  //向后台发送处理数据
            var url ="{:U('Public/sendmess',array(),'')}";
            $.ajax({  
                url:url+'/code/zuoshoupai', //这里注意不要加分号，因为 ajax 是以逗号分隔  
                dataType:"json",  
                success:function(data){  
                    if(data==1001){
                       // $("#btnSendCode").text("发送成功");
                    }
                }  
            }); 
             
        }

        //timer处理函数
        function SetRemainTime() {
                    if (curCount == 0) {                
                        window.clearInterval(InterValObj);//停止计时器
                        $("#btnSendCode").removeAttr("disabled");//启用按钮
                        $("#btnSendCode").text("重新发送验证码");
                    }
                    else {
                        curCount--;
                        $("#btnSendCode").text("请在" + curCount + "秒内输入验证码");
                    }
        }
        $(function(){

            $('#btnSendCode').click(function(){
                 var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
                 var mobile = $("form input[name='phone']").val();  
                if(!myreg.test(mobile))
                { 
                    alert('请输入正确手机号码!');
                }else{
                    sendMessage();
                }
            })
        })
    </script>