#!/bin/bash
 
TIMESTAMP=$(date +"%Y%m%d%H%M%S")
BACKUP_DIR="/home/ubuntu/backup/$TIMESTAMP"
MYSQL_USER="root"
MYSQL=/usr/bin/mysql
MYSQL_PASSWORD="titok"
MYSQLDUMP=/usr/bin/mysqldump
 
mkdir -p "$BACKUP_DIR"
 
databases=`$MYSQL --user=$MYSQL_USER -p$MYSQL_PASSWORD -e "SHOW DATABASES;" | grep -Ev "(Database|information_schema|performance_schema)"`
 
for db in $databases; do
  $MYSQLDUMP --force --opt --user=$MYSQL_USER -p$MYSQL_PASSWORD --databases $db | gzip > "$BACKUP_DIR/mysql/$db.gz"
done
