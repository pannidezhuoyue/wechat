#!/bin/bash
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/local/mysql/bin

# mysql backup script
db_date=`date +%Y%m%d`
olddb_date=`date +%Y%m%d --date='30 days ago'`
#echo $olddb_date
db_dir="/data_back/backup/db"

mkdir -p $db_dir/$db_date
log=${db_dir}/${db_date}/${db_date}.log


for i in $(mysql -u root -padmin --execute "show databases;")
do
    if [ "$i" = "Database" ] || [ "$i" = "information_schema" ] || [ "$i" = "performance_schema" ] || [ "$i" = "senyint" ]; then
        continue
    else
        cd $db_dir/$db_date
        mysqldump -u root -padmin -h localhost --events --ignore-table=mysql.events $i > ${i}.sql
        tar cjvf ${i}.sql.tar.bz2 ${i}.sql > /dev/null 2>&1
        rm -f ${i}.sql
        echo "${i} is successfull backup" >> $log
    fi
done

for j in $(ls $db_dir)
do
    if [ "$j" -le "$olddb_date" ]; then
       rm -rf $db_dir/$j
    else
        echo "nodel--$j"
    fi
done
