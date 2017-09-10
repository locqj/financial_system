### 2017-7-8
	#### 功能修改 提成分红规则
	####         提成规则不变，增加9种分红规则

### 2017-7-9
	#### 数据库修改 staff_bonus_rule
	####          rule_key => 类型改为int

### 2017-7-9
	#### 功能修改 店铺管理 				支出成本
	####        入口改为从树形图进入		修改bug
	####        添加店铺带区域编号

### 2017-7-10
	### 修改bug 支出管理 
	### 功能修改 增加收入管理
	### 数据库修改 新添表。
CREATE TABLE `store_income` (
  `id` int(11) NOT NULL,
  `total` float NOT NULL COMMENT '总额',
  `category` varchar(128) NOT NULL COMMENT '类目',
  `month` int(255) NOT NULL COMMENT '创建月份',
  `year` int(11) NOT NULL COMMENT '创建年份'，
  `store_code` varchar(50) NOT NULL COMMENT '店铺号',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;