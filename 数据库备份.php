//����һ ���ݱ���
#!/bin/bash
export backup_dir=/var/lib/mysql/m9standard
export backup_target_dir=/home/db
export backup_logs_dir=/home/logs
export DATE=$(date +%Y%m%d) 

#�õ�1��ǰ������
export ccDATE=$(date "-d 5 day ago" +%Y%m%d)

echo "���ݿⱸ��"  $DATE  > $backup_logs_dir/db_$DATE
echo "============================================================"  >> $backup_logs_dir/db_$DATE

rm -rf backup_target_dir/*.*

#ɾ��5��ǰ�����ݱ����ļ���ֻ���������ڵ�
rm -rf /home/db_$ccDATE.tar.gz

echo "��ʼ�������ݱ�"  >> $backup_logs_dir/db_$DATE
echo "##########################"  >> $backup_logs_dir/db_$DATE
cp -R $backup_dir/*	/$backup_target_dir/


echo "��ʼѹ�����ݱ�"  >> $backup_logs_dir/db_$DATE
echo "##########################"  >> $backup_logs_dir/db_$DATE
cd /home
tar -zcvf db_$DATE.tar.gz db/ >> $backup_logs_dir/db_$DATE


echo "��ʼɾ��ԭ���ݱ�"  >> $backup_logs_dir/db_$DATE
echo "##########################"  >> $backup_logs_dir/db_$DATE
rm -R -rf /home/db/*

echo "���ݿⱸ�ݽ���" >> $backup_logs_dir/db_$DATE
echo "============================================================"  >> $backup_logs_dir/db_$DATE




//������ sql����
1.���ڷ������½��ļ�������3���ļ��У�mkdir /bak,mkdir /bak/bakmysql,mkdir /bak/bakmysqlold ����/bak/bakmysql�ļ����½�һ��shell�ű���touch /bak/bakmysql/backup.sh ��

���ļ���Ȩ��chmod 755 /bak/bakmysql/backup.sh ��

2.�༭shell�ű���vi /bak/bakmysql/backup.sh
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

3.shell�ű���mysqldump -uroot -p'password' db_bbs> $File ����еĺ�ɫ������ֱ�Ϊ���Լ���mysql���ݿ��û��������database�����ű��Ƚ�/bak/bakmysql�ļ�����bakmysqlΪ�ļ�����ͷ�ı����ļ�����/bak/bakmysqlold�����������µı����ļ���������ж�/bak/bakmysqlold�ļ���������ǰ���ļ��Ƿ���ڣ�������ɾ���������������������Զ����������������ݿ�ű���