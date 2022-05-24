USER="satprouser"
PASSWORD="Xhce57K7xgsTZhKX"
DATABASE="satpro"
FINAL_OUTPUT=`date +%Y%m%d`_$DATABASE.sql

mysqldump --user=$USER --password=$PASSWORD $DATABASE > $FINAL_OUTPUT
gzip $FINAL_OUTPUT