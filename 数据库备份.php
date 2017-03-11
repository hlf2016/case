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