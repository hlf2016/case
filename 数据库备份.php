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