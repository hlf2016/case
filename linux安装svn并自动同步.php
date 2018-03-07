安装部分：
	一 ，源码安装
		1、下载
		[maintain@HM16-213 software]$ wget http://subversion.tigris.org/downloads/subversion-deps-1.6.12.tar.bz2
		[maintain@HM16-213 software]$ wget http://subversion.tigris.org/downloads/subversion-1.6.12.tar.bz2

		2、解压
		[maintain@HM16-213 software]$ tar jxvf subversion-deps-1.6.12.tar.bz2
		[maintain@HM16-213 software]$ tar jxvf subversion-1.6.12.tar.bz2

		3、准备安装
		[root@HM16-213 software]# mkdir /usr/local/subversion
		[root@HM16-213 software]# cd subversion-1.6.12

		4、安装
		[root@HM16-213 subversion-1.6.12]# ./configure --prefix=/usr/local/subversion
		[root@HM16-213 subversion-1.6.12]# make && make install

	二，yum安装
		1.安装svn
		yum -y install subversion
	三，配置

		1.建立版本库目录
		mkdir /www/svndata

		2.建立版本库

		3.创建一个新的Subversion项目
		svnadmin create /var/www/svndata/demo

		4.配置允许用户jiqing访问
		cd /var/www/svndata/demo/conf

		vi svnserve.conf
		anon-access=none
		auth-access=write
		password-db=passwd

		注：修改的文件前面不能有空格，否则启动svn server出错

		vi passwd
		[users]
		#<用户1> = <密码1>
		#<用户2> = <密码2>
		user1=123456
		5.运行svn服务
		svnserve -d -r /www/svndata
		
		6.客户端连接
		svn co svn://127.0.0.1/demo /var/www/html
	四、实现自动同步web站点
		1)设置WEB服务器根目录为/var/www/html

		2)checkout一份SVN

		svn co svn://localhost/demo /var/www/html

		修改权限为WEB用户

		chown -R apache:apache /var/www/html

		3)建立同步脚本

		cd /var/www/svndata/demo/hooks/

		cp post-commit.tmpl post-commit
		
		chmod 777 post-commit  
		编辑post-commit,在文件最后添加以下内容
		<!--复制代码开始-->

		REPOS="$1"
		REV="$2"

		BASEPATH=/var/www/html
		WEBPATH="$BASEPATH/"
		export LANG=zh_CN.UTF-8
		svn update $WEBPATH --username user1 --password 123456 --no-auth-cache

		<!--复制代码结束-->

		 

		4)增加脚本执行权限

		chmod +x post-commit

		5)最后操作是关闭服务然再打开服务:

		svn服务的关闭：

		killall svnserve

		svn开启：

		svnserve -d -r /var/www/svndata
			
	五：windows下清理svn文件
	    @echo on   
		color 2f   
		mode con: cols=80 lines=25   
		@REM   
		@echo 正在清理SVN文件，请稍候......   
		@rem 循环删除当前目录及子目录下所有的SVN文件   
		@rem for /r . %%a in (.) do @if exist "%%a\.svn" @echo "%%a\.svn"   
		@for /r . %%a in (.) do @if exist "%%a\.svn" rd /s /q "%%a\.svn"   
		@echo 清理完毕！！！   
		@pause   
		
		复制以上代码到文件命名为a.bat，然后放在项目目录中，双击执行即可 
	
