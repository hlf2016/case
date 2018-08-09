###LAMP配置(centos7.0)
```sh
1. 安装apache        # yum install httpd httpd-devel
2. 启动apache服务    # systemctl start  httpd
3. 设置httpd服务开机启动     # systemctl enable  httpd
4. 查看服务状态 	systemctl # status httpd
5. 确认80端口监听中(至此可访问IP测试) 	netstat -tulp   //否则关闭防火墙或开启防火墙80端口
6. 安装mysql	yum install mariadb mariadb-server mariadb-libs mariadb-devel
7. 开启mysql服务，并设置开机启动，检查mysql状态 	systemctl start  mariadb 
		systemctl enable  mariadb 
		systemctl status  mariadb 
8. 登陆数据库测试	 mysql -uroot -p 
9. 安装php 		yum -y install php
10. php与mysql关联起来		yum install php-mysql
11. 安装常用PHP模块			yum install -y php-gd php-ldap php-odbc php-pear php-xml php-xmlrpc php-mbstring php-snmp php-soap curl curl-devel php-bcmath
12. 重启apache服务器(至此可访问IP测试)		systemctl restart http
```
### centos7 安装php7
```sh
1. 安装可以用的 EPEL and Remi 源
# yum install https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
# yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
2. 安装yum-utils,他是用于管理yum存储库和软件包的有用程序。它是yum基本扩展的工具。
# yum install yum-utils
3. 利用yum-utils启用Remi存储库作为安装不同PHP版本的默认存储库
	# yum-config-manager --enable remi-php70   //[Install PHP 7.0]
	# yum-config-manager --enable remi-php71   //[Install PHP 7.1]
	# yum-config-manager --enable remi-php72   //[Install PHP 7.2]
4.  安装PHP 7的必要模块和扩展
	# yum install php php-mcrypt php-cli php-gd php-curl php-mysql php-ldap php-zip php-fileinfo 
5. 测试  # php -v
```
###常用命令
```sh
1、启动、终止、重启(centos7)
    systemctl start httpd.service #启动
    systemctl stop httpd.service #停止
    systemctl restart httpd.service #重启

2、设置开机启动/关闭(centos7)
    systemctl enable httpd.service #开机启动
    systemctl disable httpd.service #开机不启动

3、检查httpd状态  (centos7)
	systemctl status httpd.service

4. 防火墙的操作(centos7)
	启动： systemctl start firewalld
	查看状态： systemctl status firewalld 
	停止： systemctl disable firewalld
	禁用： systemctl stop firewalld

5.查看/关闭防火墙(centos 6)
    service iptables stop  关闭防火墙（临时关闭，重启后失效）
	service iptables start  重新开启防火墙 
	chkconfig iptables off  永久性关闭生效，需要重启后才能生效
 

6. 查看SELinux状态：
    1、/usr/sbin/sestatus -v      ##如果SELinux status参数为enabled即为开启状态
		SELinux status:                 enabled
	2、getenforce                 ##也可以用这个命令检查
7.关闭SELinux：
	1、临时关闭（不用重启机器）：
		setenforce 0                  ##设置SELinux 成为permissive模式
		 ##setenforce 1 设置SELinux 成为enforcing模式
	2、修改配置文件需要重启机器：
		修改/etc/selinux/config 文件
		将SELINUX=enforcing改为SELINUX=disabled
	重启机器即可

```
###ubuntu LAMP环境配置(参考版本16.04)

###apache2
    sudo apt-get install apache2  //安装
    sudo /etc/init.d/apache2 restart  //重启
    curl http://localhost或http：//127.0.0.1，测试
### php
    sudo apt-get install php7.0  //安装   ubuntu16.04中没有php5了，直接装7吧
    sudo apt-get install libapache2-mod-php7.0  // 配置APACHE+PHP7的
    sudo apt-get install libapache2-mod-php    // 这个应该是配置APACHE+PHP5的，一块装吧
    sudo /etc/init.d/apache2 restart    // 重启
    touch phpinfo.php    //新建一个页面测试 
###MySql
    apt-get install mysql-server mysql-client    // 安装时会要求输入mysql管理员密码，输入即可

    注意：
    mysql-server：用来创建和管理数据库实例，提供相关接口供不同客户端调用;
    mysql-client：操作数据库实例的的一个命令行工具，像图形化界面工具有phpmyadmin等;
    mysqld：即MySQL server
    mysql：即mysql-client客户端命令行工具
    - 附mysql服务管理命令

    /etc/init.d/mysql stop/restart/start  // 停止、重启、开启数据库
    service mysql stop/restart/start    // 同上

### 附加配置
    1. 无法使用phpmyadmin客户端工具   解决： 打开php.ini 中的 mysql,pdo,mysqli拓展，如果没有则需要安装
    2. 验证码页面报错 解决：安装gd库环境
    3. undefind curl_init()  解决：安装curl拓展
    4. rewrite 重写不生效   解决：a,打开php.ini中的rewrite拓展。b,sudo a2enmod rewrite  c,sudo vim /etc/apache2/sites-enabled/000-default   将其中的 AllowOverride None 修改为 AllowOverride All，  d,sudo /etc/init.d/apache2 restart

### 参考代码
    apt-get install php-mcrypt;
    apt-get install php-curl;
    apt-get install php-gd;

ubuntu LNMP环境配置(参考版本16.04)
### sudo apt install mysql-server    //安装mysql 会提示输入密码
### #添加nginx和php的ppa源 并安装nginx
	sudo apt-add-repository ppa:nginx/stable
	sudo apt-add-repository ppa:ondrej/php
	sudo apt update
 	sudo apt install nginx
### sudo apt install php7.0-fpm   //安装php7.0 
### sudo apt-get install vim  //不影响编辑文本可忽略
### 修改配置
	sudo vim /etc/php/7.0/fpm/pool.d/www.conf  //php配置
		root /var/www/html;   //web站点根目录
		#nginx 和fastcgi通信有2种方式，一种是TCP方式，还有种是UNIX Socket方式
		#默认是socket方式
		listen = /run/php/php7.0-fpm.sock   //记录此行
	sudo service php7.0-fpm restart  //重启php
	sudo vim /etc/nginx/sites-enabled/default //配置nginx
		# Add index.php to the list if you are using PHP
		index index.php index.html index.htm index.nginx-debian.html; //添加index.php
		
		location ~ \.php$ {
		   include snippets/fastcgi-php.conf;

		    With php-fpm (or other unix sockets):
		    fastcgi_pass unix:/run/php/php7.0-fpm.sock;  //与上面地址一致
		    #With php-cgi (or other tcp sockets):
	            #fastcgi_pass 127.0.0.1:9000;
		}
	sudo service nginx restart   //重启生效
### sudo apt install php-mysql php-curl php-mcrypt php-gd php-memcached php-redis  #根据需要安装拓展
 

 
