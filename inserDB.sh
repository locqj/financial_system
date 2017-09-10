#!/bin/bash
# 插入mysql数据库数据
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
 
STORE=('hjs00002' 'hjs00003' 'hjs00004' 'hjs00005')
MONTH=(8 9 10 11 12)


# let us do it
for t in $TABLES

do
	if [ $t == "store_cost" ]
		then
		for store_code in ${STORE[@]}
		do	
			insert_sql="insert into $t (total, category, month, length, owner_store_code, pay_stores, unit, pay_month, created_at, year)
			values(10000,'sh数据',8,5,'$store_code',
			'[\"$store_code\"]',2000,'[{\"year\":2017,\"month\":8},{\"year\":2017,\"month\":9},{\"year\":2017,\"month\":10},{\"year\":2017,\"month\":11},{\"year\":2017,\"month\":12}]', '2017-07-24 14:51:21', 2017)"
			$MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e  "${insert_sql}"
		done
		continue
	fi

	if [ $t == "store_income" ]
		then
		for store_code in ${STORE[@]}
		do	
			for month in ${MONTH[@]}
			do
				insert_sql="insert into $t (total, category, month, year, store_code, created_at)
				values(10000,'income_test', $month, 2017, '$store_code', '2017-07-24 14:51:21')"
				$MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e  "${insert_sql}"
			done
		done
		continue
	fi

	if [ $t == "staff_contract" ]
		then
		for store_code in ${STORE[@]}
		do	
			for month in ${MONTH[@]}
			do	
				if [ $store_code == 'hjs00002' ]
				then
					insert_sql="insert into $t (number, employee_code, sign_amount, real_amount, is_signed, year, month, store_code, created_at, day, status_del, type, contract_addr, received_amount, source_store)
					values('$month/"hjs00002T4/"','hjs00002T4', 50000, 50000, '1', 2017, $month, '$store_code', '2017-07-24 14:51:21', 5, 0, 1, '', 50000, 'all')"
					$MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e  "${insert_sql}"
				elif [ $store_code == 'hjs00003' ]
				then
					insert_sql="insert into $t (number, employee_code, sign_amount, real_amount, is_signed, year, month, store_code, created_at, day, status_del, type, contract_addr, received_amount, source_store)
					values('$month/"hjs00003T6/"','hjs00003T6', 50000, 50000, '1', 2017, $month, '$store_code', '2017-07-24 14:51:21', 5, 0, 1, '', 50000, 'all')"
					$MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e  "${insert_sql}"
				elif [ $store_code == 'hjs00004' ]
				then
					insert_sql="insert into $t (number, employee_code, sign_amount, real_amount, is_signed, year, month, store_code, created_at, day, status_del, type, contract_addr, received_amount, source_store)
					values('$month/"hjs00004T8/"','hjs00004T8', 50000, 50000, '1', 2017, $month, '$store_code', '2017-07-24 14:51:21', 5, 0, 1, '', 50000, 'all')"
					$MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e  "${insert_sql}"
				else
					insert_sql="insert into $t (number, employee_code, sign_amount, real_amount, is_signed, year, month, store_code, created_at, day, status_del, type, contract_addr, received_amount, source_store)
					values('$month/"hjs00005T12/"','hjs00005T12', 50000, 50000, '1', 2017, $month, '$store_code', '2017-07-24 14:51:21', 5, 0, 1, '', 50000, 'all')"
					$MYSQL -u $MUSER -p$MPASS -h $MHOST $MDB -e  "${insert_sql}"
				fi
				
				
			done
		done
		continue
	fi
done
