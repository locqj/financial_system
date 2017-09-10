#!/bin/bash
# 删除mysql中所有表
# 示例：
# Usage: ./script user password dbnane
# Usage: ./script user password dbnane server-ip
# Usage: ./script user password dbnane mysql.nixcraft.in
# ---------------------------------------------------
 
MUSER="$1"
MPASS="$2"
MDB="$3"
MHOST="localhost"



[ "$4" != "" ] && MHOST="$4"
 
# 设置命令路径
MYSQL=$(which mysql)
AWK=$(which awk)
GREP=$(which grep)
 
# help $# 是参数，参数小于三个就报错
if [ ! $# -ge 3 ]
	then
		echo "Usage: $0 {用户名} {密码} {数据库名} [端口,默认localhost]"
		echo "删库小脚本"
	exit 1
fi
 
# 连接mysql数据库
$MYSQL -u $MUSER -p$MPASS -h $MHOST -e "use $MDB"  &>/dev/null
if [ $? -ne 0 ]
	then
 		echo "Error - 用户名或密码无效，无法连接mysql数据库"
 		exit 2
fi
 
TABLES=$($MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e 'show tables' | $AWK '{ print $1}' | $GREP -v '^Tables' )
 
# make sure tables exits
if [ "$TABLES" == "" ]
	then
 		echo "Error - 在数据库中 $MDB 未发现相关表"
 	exit 3
fi
 
# let us do it
for t in $TABLES

do
	if [ $t == "user" ]
		then
			delete_sql="delete from $t where username <> 'cw' AND username <> 'jl' AND username <> 'gh'"
			$MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e  "${delete_sql}"
		continue
	elif [ $t == "employee_position" ]
		then
			delete_sql="delete from $t where position_code <> 'cw01' AND position_code <> 'jl01' AND position_code <> 'gh01'"
			$MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e  "${delete_sql}"
		continue
	elif [ $t == "store_store" ]
		then
			delete_sql="delete from $t where code <> 'hj001'"
			$MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e  "${delete_sql}"
		continue
	elif [ $t == "staff_position" ]
		then
			delete_sql="delete from $t where store_code <> 'hj001'"
			$MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e  "${delete_sql}"
		continue
	elif [ $t == "staff_employee" ]
		then
			delete_sql="delete from $t where name <> 'bruce_zj' AND name <> 'bruce_cw' AND name <> 'bruce_gh'"
			$MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e  "${delete_sql}"
		continue
	elif [ $t == "store_city" ]
		then
			echo “not del”
		continue
	elif [ $t == "store_company" ]
		then
			echo “not del”
		continue
	elif [ $t == "staff_bonus_rule" ]
		then
			echo “not del”
		continue
	else
		echo "Truncate $t table from $MDB database..."
 		$MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e "TRUNCATE TABLE  $t"
	fi
done
