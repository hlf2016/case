###url 跳转
```html
	<view class="btn-area">
	  <navigator url="/page/navigate/navigate?title=navigate" hover-class="navigator-hover">跳转到新页面</navigator>
	  <navigator url="../../redirect/redirect/redirect?title=redirect" open-type="redirect" hover-class="other-navigator-hover">在当前页打开</navigator>
	  <navigator url="/page/index/index" open-type="switchTab" hover-class="other-navigator-hover">切换 Tab</navigator>
	</view>
```	
```javascript
	  redirectFunc: function (name) {
		wx.reLaunch({
		  url: '../search/index?s=' + name
		})
	}
```
###部分修改数据
```html
 	var editPhraseCon = "list["+currentIds+"].snt"
        var editPhraseTag = "list["+currentIds+"].editTag"
	that.setData({
	   [editPhraseCon]: con,
	   [editPhraseTag]: true,
	   showDialog: false
	}) 
```
### 获取用户信息及获取
```javascript
//app.js 获取
getUserInfo: function (cb) {
    var that = this
    if (this.globalData.userInfo) {
      typeof cb == "function" && cb(this.globalData.userInfo)
    } else {
      //调用登录接口
      wx.login({
        success: function (response) {
          console.info('response', response)
          wx.getUserInfo({
            success: function (res) {
              console.info('res', res)
              that.globalData.userInfo = res.userInfo
              typeof cb == "function" && cb(that.globalData.userInfo)
            }
          })
        }
      })
    }
  },
  globalData: {
    userInfo: null,
    domain: 'https://www.somethingwhat.com',
    localStorage: {
      style: {},
      usage: {
        //lastreadurl: '',
        //lastreadchaptername: '',
        //lastreadbookname: '',
        history: []
      }
    }
//index.js 获取
var app = getApp()
Page({
  data: {
    motto: '',
    userInfo: {}
  },
  onLoad: function () {
    console.log('onLoad')
    wx.showShareMenu()
    var that = this
    //调用应用实例的方法获取全局数据
    app.getUserInfo(function (userInfo) {
      //更新数据
      that.setData({
        userInfo: userInfo
      })
    }) 
  }
})
```
###form提交及获取数据
```html
 <form bindsubmit="formSubmit">
      <input class="weui-search-bar__input input-search" maxlength="20" confirm-type="search" bindconfirm="confirmEvent" name="s_name" placeholder="请输入小说名称" />
      <button class="input-btn" type="primary" size="mini" hover-class="other-button-hover" formType="submit">搜索</button>
    </form>
```
```javascript
 //提交
  formSubmit: function (e) {
    console.info('formSubmit')
    var _txt = e.detail.value.s_name.trim();
    if (_txt != '') {
      this.redirectFunc(encodeURIComponent(_txt));
    }
  }
 ```

###保存图片
```javascript
wx.downloadFile({
          url: imgSrc,
          success: function (res) {
              console.log(res);
              //图片保存到本地
              wx.saveImageToPhotosAlbum({
                  filePath: res.tempFilePath,
                  success: function (data) { 
                      wx.showToast({
                          title:'保存成功',
                          icon: 'success',
                          duration: 1000
                      })
                  },
                  fail: function (err) {
                      console.log(err);
                      if (err.errMsg === "saveImageToPhotosAlbum:fail auth deny") {
                          console.log("用户一开始拒绝了，我们想再次发起授权")
                          console.log('打开设置窗口')
                          wx.openSetting({
                              success(settingdata) {
                                  console.log(settingdata)
                                  if (settingdata.authSetting['scope.writePhotosAlbum']) {
                                      console.log('获取权限成功，给出再次点击图片保存到相册的提示。')
                                  } else {
                                      console.log('获取权限失败，给出不给权限就无法正常使用的提示')
                                  }
                              }
                          })
                      }
                  }
              })
          }
      })
```
###php后台模拟请求微信接口
```php
/* 发送json格式的数据，到api接口 -xzz0704  */
    function https_curl_json($url,$data,$type){
        if($type=='json'){//json $_POST=json_decode(file_get_contents('php://input'), TRUE);
            $headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache");
            $data=json_encode($data);
        }else{
			$headers = array("Content-type: application/x-www-form-urlencoded;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache"); 
		}
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
        $output = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl);
        return $output;
    }
```
