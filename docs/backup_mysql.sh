#!/bin/sh
/Applications/MAMP/Library/bin/mysqldump -uroot -proot hengju2 > /Applications/MAMP/htdocs/financial_management/docs/mysqlbak/`date +%Y%m%d-%H%M%S`.sql
echo "backup mysql done"
