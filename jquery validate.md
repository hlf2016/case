###手写原生验证
```javascript
<script type="text/javascript"> 
function validateFunc(obj){

    var types = obj.attr('data-type');
            var texts = $.trim(obj.val());
            var names = obj.prev().text();
            var regEmail = /.+@.+\.[a-zA-Z]{2,4}$/;
            var phoneReg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/; 
            var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;  
            obj.next('.validate').remove(); 
            if(typeof(types)!='undefined' && types.indexOf("require")!= -1){
                if(texts.replace(/(^s*)|(s*$)/g, "").length ==0){
                    obj.after('<lable class="validate">* '+names+'不能为空</lable>');
                }
            }else if(typeof(types)!='undefined' && types.indexOf("email")!= -1){
                if(!regEmail.test(texts)){
                    obj.after('<lable class="validate">* '+names+'格式不正确</lable>');
                }
            }
            else if(typeof(types)!='undefined' && types.indexOf("mobile")!= -1){
                if(!phoneReg.test(texts)){
                    obj.after('<lable class="validate">* '+names+'格式不正确</lable>');
                }
            }else if(typeof(types)!='undefined' && types.indexOf("idcard")!= -1){
                if(!reg.test(texts)){
                    obj.after('<lable class="validate">* '+names+'格式不正确</lable>');
                }
            }
}
$(function(){
    $('.next-button').click(function(){
        $('form input').each(function(){ 
            validateFunc($(this))
        })
    })
    $('form input').blur(function(){
        validateFunc($(this))
    })
})

</script>
```
