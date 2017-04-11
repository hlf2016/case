//方法一 数据备份
#!/bin/bash
export backup_dir=/var/lib/mysql/m9standard
export backup_target_dir=/home/db
export backup_logs_dir=/home/logs
export DATE=$(date +%Y%m%d) 

#得到1天前的日期
export ccDATE=$(date "-d 5 day ago" +%Y%m%d)

echo "数据库备份"  $DATE  > $backup_logs_dir/db_$DATE
echo "============================================================"  >> $backup_logs_dir/db_$DATE

rm -rf backup_target_dir/*.*

#删除5天前的数据备份文件，只保留五天内的
rm -rf /home/db_$ccDATE.tar.gz

echo "开始复制数据表"  >> $backup_logs_dir/db_$DATE
echo "##########################"  >> $backup_logs_dir/db_$DATE
cp -R $backup_dir/*	/$backup_target_dir/


echo "开始压缩数据表"  >> $backup_logs_dir/db_$DATE
echo "##########################"  >> $backup_logs_dir/db_$DATE
cd /home
tar -zcvf db_$DATE.tar.gz db/ >> $backup_logs_dir/db_$DATE


echo "开始删除原数据表"  >> $backup_logs_dir/db_$DATE
echo "##########################"  >> $backup_logs_dir/db_$DATE
rm -R -rf /home/db/*

echo "数据库备份结束" >> $backup_logs_dir/db_$DATE
echo "============================================================"  >> $backup_logs_dir/db_$DATE




//方法二 sql导出
1.先在服务器下建文件夹以下3个文件夹：mkdir /bak,mkdir /bak/bakmysql,mkdir /bak/bakmysqlold 。在/bak/bakmysql文件夹下建一个shell脚本：touch /bak/bakmysql/backup.sh 。

给文件授权：chmod 755 /bak/bakmysql/backup.sh 。

2.编辑shell脚本：vi /bak/bakmysql/backup.sh
#!/bin/sh
cd /bak/bakmysql
echo "You are in bakmysql directory"
mv bakmysql* /bak/bakmysqlold
echo "Old databases are moved to bakmysqlold folder"
Now=$(date +"%d-%m-%Y")
File=bakmysql-$Now.sql
mysqldump -uroot -p'password' db_bbs > $File
echo "Your database backup successfully completed"
SevenDays=$(date -d -7day  +"%d-%m-%Y")
if [ -f /bak/bakmysqlold/bakmysql-$SevenDays.sql ]
then
rm -rf /bak/bakmysqlold/bakmysql-$SevenDays.sql
echo "You have delete 7days ago bak file "
else
echo "7days ago bak file not exist "
fi

3.shell脚本：mysqldump -uroot -p'password' db_bbs> $File 这句中的红色字体请分别换为你自己的mysql数据库用户、密码和database名。脚本先将/bak/bakmysql文件夹下bakmysql为文件名开头的备份文件移至/bak/bakmysqlold，再生成最新的备份文件，最后再判断/bak/bakmysqlold文件夹中七天前的文件是否存在，存在则删除，最后结束。这样就能自动备份最近七天的数据库脚本。