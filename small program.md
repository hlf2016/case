1.保存图片
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
2.php后台模拟请求微信接口
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
