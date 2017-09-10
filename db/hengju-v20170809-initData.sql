-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: 2017-08-09 05:18:08
-- 服务器版本： 5.6.35
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hengju2`
--

-- --------------------------------------------------------

--
-- 表的结构 `bonus_details`
--

CREATE TABLE `bonus_details` (
  `id` int(11) NOT NULL,
  `bonus_amount` float NOT NULL DEFAULT '0' COMMENT '提成金额（根据rule_key，一手提成或者分红）',
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `is_cost` int(11) NOT NULL COMMENT '店铺成本:0-不作，1-作',
  `store_type` int(11) NOT NULL COMMENT '店铺类型',
  `update_code` varchar(50) NOT NULL COMMENT '表唯一标识',
  `bonus_rule_key` varchar(50) NOT NULL COMMENT '(提成，分红)',
  `store_code` varchar(50) NOT NULL,
  `cstore_code` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '子店铺编号，可为空'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `calculate_log`
--

CREATE TABLE `calculate_log` (
  `id` int(11) NOT NULL,
  `update_code` varchar(50) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `is_last` int(4) NOT NULL DEFAULT '1' COMMENT '每次更新数据，置为1表示最新数据，其他需要修改为0',
  `employee_code` varchar(50) NOT NULL DEFAULT '操作者',
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `calculate_store`
--

CREATE TABLE `calculate_store` (
  `id` int(10) NOT NULL,
  `income` float NOT NULL COMMENT '总收入',
  `outcome` float NOT NULL COMMENT '总支出',
  `profit` float NOT NULL COMMENT '总利润',
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_code` varchar(50) NOT NULL COMMENT '更新标志',
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `commission_details`
--

CREATE TABLE `commission_details` (
  `id` int(11) NOT NULL,
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号',
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `amount` float NOT NULL DEFAULT '0' COMMENT '佣金额度',
  `second_amount` float NOT NULL DEFAULT '0' COMMENT '二手房佣金',
  `rent_amount` float NOT NULL DEFAULT '0' COMMENT '租房佣金',
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `update_code` varchar(50) NOT NULL COMMENT '表唯一标识',
  `contract_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `contract_images`
--

CREATE TABLE `contract_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `contract_id` varchar(50) NOT NULL COMMENT '签单编号',
  `url` varchar(255) NOT NULL COMMENT '地址',
  `status_del` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图片';

-- --------------------------------------------------------

--
-- 表的结构 `contract_process`
--

CREATE TABLE `contract_process` (
  `id` int(10) UNSIGNED NOT NULL,
  `contract_number` varchar(50) NOT NULL COMMENT '签单号',
  `type` int(10) UNSIGNED NOT NULL COMMENT '1:网签，2：贷款，3：交税',
  `remark` text COMMENT '备注',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `status_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='签单流程表';

-- --------------------------------------------------------

--
-- 表的结构 `cost_details`
--

CREATE TABLE `cost_details` (
  `id` int(11) NOT NULL,
  `category` varchar(128) NOT NULL COMMENT '类目',
  `amount` float NOT NULL COMMENT '金额',
  `store_code` varchar(50) NOT NULL COMMENT '店铺编码',
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `update_code` varchar(50) NOT NULL COMMENT '表唯一标识',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `employee_position`
--

CREATE TABLE `employee_position` (
  `id` int(11) NOT NULL,
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `position_code` varchar(50) NOT NULL COMMENT '职位编号',
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号'
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `employee_position`
--

INSERT INTO `employee_position` (`id`, `employee_code`, `position_code`, `store_code`) VALUES
(14, '123132123123123123123', 'jl01', 'hj001'),
(15, 'hj001T2', 'cw01', 'hj001'),
(16, '123123', 'gh01', 'hj001');

-- --------------------------------------------------------

--
-- 表的结构 `grant_log`
--

CREATE TABLE `grant_log` (
  `id` int(11) NOT NULL,
  `employee_code` varchar(50) NOT NULL DEFAULT '' COMMENT '员工编号',
  `year` int(50) NOT NULL,
  `month` int(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `record_user` varchar(50) NOT NULL COMMENT '录入员',
  `update_code` varchar(50) NOT NULL,
  `amount` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `position_adjustment_log`
--

CREATE TABLE `position_adjustment_log` (
  `id` int(11) NOT NULL,
  `old_position_code` varchar(50) NOT NULL COMMENT '旧职位编号',
  `new_position_code` varchar(50) NOT NULL COMMENT '新职位编号',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `old_store_code` varchar(50) NOT NULL COMMENT '旧店铺编号',
  `new_store_code` varchar(50) NOT NULL COMMENT '新店铺编号',
  `year` int(10) UNSIGNED NOT NULL COMMENT '年',
  `month` int(10) UNSIGNED NOT NULL COMMENT '月'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `reduce_salary`
--

CREATE TABLE `reduce_salary` (
  `id` int(11) NOT NULL,
  `store_code` varchar(50) NOT NULL,
  `employee_code` varchar(50) NOT NULL,
  `record_user` varchar(50) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `amount` float NOT NULL DEFAULT '0',
  `category` text NOT NULL COMMENT '类目',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `day` int(11) NOT NULL,
  `is_port` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否是端口费'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `salary_details`
--

CREATE TABLE `salary_details` (
  `id` int(11) NOT NULL,
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `salary_amount` float NOT NULL COMMENT '基本工资',
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `store_type` int(11) NOT NULL COMMENT '店铺类型 1-总店 2-分店;3:区域',
  `update_code` varchar(50) NOT NULL COMMENT '表唯一标识',
  `store_code` varchar(50) NOT NULL COMMENT '店铺code'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `staff_bonus_rule`
--

CREATE TABLE `staff_bonus_rule` (
  `id` int(11) NOT NULL,
  `rule_key` int(50) NOT NULL COMMENT '规则key:1:销售阶梯提成；2:助理分红；3:店长分红（本店）；4:区域经理分红；5:总经理；6:二级分店；7:一手分成比例；8:二手房房源分成比例；9:租售房源分成比例，10:销售等级评定，11:一手房提成；12:二租房提成，13:端口申报评定',
  `top` varchar(50) DEFAULT NULL COMMENT '范围上限',
  `bottom` int(11) DEFAULT NULL COMMENT '范围下限',
  `percentage` float NOT NULL COMMENT '百分比',
  `is_cost` int(11) NOT NULL COMMENT '店铺成本:0-不作，1-作',
  `status_del` int(11) NOT NULL DEFAULT '0' COMMENT '0--存在 ，1--不存在',
  `position_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `staff_bonus_rule`
--

INSERT INTO `staff_bonus_rule` (`id`, `rule_key`, `top`, `bottom`, `percentage`, `is_cost`, `status_del`, `position_code`) VALUES
(136, 11, NULL, NULL, 0, 0, 0, NULL),
(137, 12, NULL, NULL, 0, 0, 0, NULL),
(138, 1, '+00', 0, 0, 1, 0, NULL),
(139, 2, NULL, NULL, 0, 0, 0, NULL),
(140, 3, NULL, NULL, 0, 0, 0, NULL),
(141, 4, NULL, NULL, 0, 0, 0, NULL),
(142, 5, NULL, NULL, 0, 0, 0, NULL),
(144, 6, '0', NULL, 0, 0, 0, NULL),
(145, 7, NULL, NULL, 0, 0, 0, NULL),
(146, 8, NULL, NULL, 0, 0, 0, NULL),
(149, 13, NULL, 0, 0, 0, 0, NULL),
(150, 10, NULL, 0, 0, 0, 0, 'xs01'),
(151, 10, NULL, 1, 0, 0, 0, 'xs02'),
(152, 10, NULL, 2, 0, 0, 0, 'xs03'),
(153, 10, NULL, 3, 0, 0, 0, 'xs04'),
(154, 10, NULL, 4, 0, 0, 0, 'xs05'),
(156, 9, NULL, NULL, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `staff_contract`
--

CREATE TABLE `staff_contract` (
  `id` int(11) NOT NULL,
  `number` varchar(255) NOT NULL COMMENT '单号',
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `sign_amount` float NOT NULL COMMENT '签单额度',
  `real_amount` float NOT NULL DEFAULT '0' COMMENT '结单额度',
  `is_signed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否结佣：1-是，0-不是',
  `year` int(11) NOT NULL COMMENT '年',
  `month` int(11) NOT NULL COMMENT '月',
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `day` int(11) NOT NULL,
  `status_del` int(11) NOT NULL DEFAULT '0' COMMENT '0 未删除',
  `type` int(11) NOT NULL COMMENT '单子类型 1-一手， 2-二手， 3 -租单',
  `is_divide` int(11) NOT NULL DEFAULT '0' COMMENT '是否为有房源提供方，0-无，1-有 ',
  `source_employee` varchar(50) DEFAULT '0' COMMENT '房源提供方code',
  `remark` text COMMENT '备注',
  `contract_addr` text NOT NULL COMMENT '房源地址',
  `received_amount` float DEFAULT '0' COMMENT '已收金额',
  `source_store` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `staff_employee`
--

CREATE TABLE `staff_employee` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL COMMENT '员工姓名',
  `sex` int(11) NOT NULL COMMENT '性别：0：男，1-女',
  `birth` varchar(128) DEFAULT NULL COMMENT '出生年月',
  `id_card` varchar(50) DEFAULT NULL COMMENT '身份证',
  `phone` varchar(11) DEFAULT NULL COMMENT '电话',
  `addr` varchar(255) DEFAULT NULL COMMENT '住址',
  `entry_time` varchar(128) DEFAULT NULL COMMENT '入职时间',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态：1-存在，0-不存在',
  `position_code` varchar(10) NOT NULL COMMENT '所属职位',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `code` varchar(50) NOT NULL COMMENT '员工编号，唯一',
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `staff_employee`
--

INSERT INTO `staff_employee` (`id`, `name`, `sex`, `birth`, `id_card`, `phone`, `addr`, `entry_time`, `status`, `position_code`, `updated_at`, `code`, `created_at`) VALUES
(37, 'bruce_zj', 0, '', '2312312312312', '13213123123', 'addr', '2017-07-26', 1, '', '2017-07-24 00:29:16', '123132123123123123123', '2017-06-30 01:29:29'),
(38, 'bruce_cw', 1, '2017-06', '2356456', '12312312312', 'aaa', '2017-07-26', 1, '', '2017-08-03 06:03:21', 'hj001T2', '2017-06-30 01:30:11'),
(39, 'bruce_gh', 1, '2017-06', '123123123123123123', '12312312312', 'addr', '2017-07-26', 1, '', '2017-07-21 09:30:54', '123123', '2017-06-30 01:30:38');

-- --------------------------------------------------------

--
-- 表的结构 `staff_port`
--

CREATE TABLE `staff_port` (
  `id` int(11) NOT NULL,
  `port_name` varchar(255) NOT NULL COMMENT '端口名',
  `employee_code` varchar(50) NOT NULL,
  `store_code` varchar(50) NOT NULL,
  `remark` text,
  `amount` float NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `length` int(11) NOT NULL COMMENT '期数',
  `pay_month` text NOT NULL COMMENT '还款月份',
  `status` int(11) NOT NULL COMMENT '1-存在 0-不存在',
  `port_number` varchar(50) DEFAULT NULL,
  `unit` float DEFAULT NULL,
  `port_place` varchar(255) DEFAULT NULL,
  `start_year_month` int(10) UNSIGNED NOT NULL COMMENT '开始还款年月',
  `end_year_month` int(10) UNSIGNED NOT NULL COMMENT '结束还款年月'
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `staff_position`
--

CREATE TABLE `staff_position` (
  `id` int(11) NOT NULL,
  `store_code` varchar(50) NOT NULL COMMENT '所属店铺',
  `code` varchar(50) NOT NULL COMMENT '职位代号',
  `name` varchar(255) NOT NULL COMMENT '职位名称',
  `level` int(11) NOT NULL DEFAULT '1' COMMENT '级别',
  `salary` float NOT NULL COMMENT '基本工资',
  `status_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-删除，0-未删除',
  `position_tag` varchar(255) NOT NULL COMMENT '头衔'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `staff_position`
--

INSERT INTO `staff_position` (`id`, `store_code`, `code`, `name`, `level`, `salary`, `status_del`, `position_tag`) VALUES
(1, 'hj001', 'jl01', '总经理', 1, 1000, 0, '总经理'),
(2, 'hj001', 'gh01', '过户', 1, 1000, 0, '过户专员'),
(5, 'hj001', 'cw01', '财务', 1, 1000, 0, '财务专员');

-- --------------------------------------------------------

--
-- 表的结构 `staff_position_level`
--

CREATE TABLE `staff_position_level` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `top` varchar(50) NOT NULL,
  `bottom` varchar(50) NOT NULL,
  `position_code` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `staff_transfer_record`
--

CREATE TABLE `staff_transfer_record` (
  `id` int(11) NOT NULL,
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号',
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `amount` float NOT NULL COMMENT '过户费用',
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `contract_number` varchar(50) NOT NULL COMMENT '签单号',
  `day` int(11) NOT NULL,
  `status_del` int(11) NOT NULL DEFAULT '0' COMMENT '0 未删除',
  `remark` text CHARACTER SET utf8 COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `store_city`
--

CREATE TABLE `store_city` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL COMMENT '城市编号',
  `name` varchar(128) NOT NULL COMMENT '城市名称',
  `remark` text CHARACTER SET utf8,
  `status_del` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `store_city`
--

INSERT INTO `store_city` (`id`, `code`, `name`, `remark`, `status_del`, `created_at`) VALUES
(1, 'cs00T1', '常熟', '', 0, '2017-08-09 03:05:24'),
(2, 'cs00T2', '张家港', NULL, 0, '2017-07-31 07:00:18');

-- --------------------------------------------------------

--
-- 表的结构 `store_company`
--

CREATE TABLE `store_company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '公司名',
  `addr` varchar(255) DEFAULT NULL COMMENT '公司地址',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态：1-存在，0-不存在',
  `reamrk` varchar(255) DEFAULT NULL COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `store_company`
--

INSERT INTO `store_company` (`id`, `name`, `addr`, `status`, `reamrk`, `created_at`, `updated_at`, `code`) VALUES
(1, '江苏公司', NULL, 1, NULL, NULL, '2017-05-28 22:32:16', '888');

-- --------------------------------------------------------

--
-- 表的结构 `store_cost`
--

CREATE TABLE `store_cost` (
  `id` int(11) NOT NULL,
  `total` float NOT NULL COMMENT '总额',
  `category` varchar(128) NOT NULL COMMENT '类目',
  `month` int(255) NOT NULL COMMENT '创建月份',
  `length` int(10) NOT NULL COMMENT '分期数',
  `owner_store_code` varchar(50) NOT NULL COMMENT '费用所属店铺',
  `pay_stores` varchar(255) NOT NULL COMMENT '还款店铺',
  `unit` float NOT NULL COMMENT '每期还款金额',
  `pay_month` text NOT NULL COMMENT '偿还月份',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `year` int(11) NOT NULL COMMENT '创建年份',
  `start_year_month` int(11) NOT NULL COMMENT '结束还款年份',
  `end_year_month` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `store_income`
--

CREATE TABLE `store_income` (
  `id` int(10) UNSIGNED NOT NULL,
  `total` float NOT NULL COMMENT '总额',
  `category` varchar(128) NOT NULL COMMENT '类目',
  `month` int(255) NOT NULL COMMENT '创建月份',
  `year` int(11) NOT NULL COMMENT '创建年份',
  `store_code` varchar(50) NOT NULL COMMENT '店铺号',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `remark` text CHARACTER SET utf8 COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `store_store`
--

CREATE TABLE `store_store` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL COMMENT '店铺编号',
  `name` varchar(128) NOT NULL COMMENT '店铺名称',
  `addr` varchar(255) NOT NULL COMMENT '地址',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态：1-存在，0-不存在',
  `type` int(11) NOT NULL COMMENT '店铺类型：1-总店，2-分店',
  `city_code` varchar(50) DEFAULT NULL COMMENT '所属城市邮编',
  `parent_code` varchar(50) DEFAULT '0' COMMENT '父级店铺编号',
  `parent_start_time` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '父级店铺开始时间',
  `company_code` varchar(50) NOT NULL COMMENT '所属公司',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `status_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'del状态 1-删除，0-未删除',
  `zone_code` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '区域code'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `store_store`
--

INSERT INTO `store_store` (`id`, `code`, `name`, `addr`, `status`, `type`, `city_code`, `parent_code`, `parent_start_time`, `company_code`, `updated_at`, `created_at`, `status_del`, `zone_code`) VALUES
(19, 'hj001', 'xxx总公司', 'addr', 1, 1, '0513', '0', '', '888', '2017-07-04 07:34:04', NULL, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `store_zone`
--

CREATE TABLE `store_zone` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '区域名',
  `code` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 -- 存在 0 -- 不存在',
  `remark` text COMMENT '备注',
  `addr` text,
  `city_code` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '城市编号',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `username` varchar(128) NOT NULL COMMENT '用户名',
  `pwd` varchar(255) NOT NULL,
  `employee_code` varchar(50) NOT NULL COMMENT '所属员工编号',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态：1-存在，0-不存在',
  `last_login_time` varchar(128) DEFAULT NULL COMMENT '最后登陆时间',
  `last_login_ip` varchar(128) DEFAULT NULL COMMENT '最后登陆ip'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `pwd`, `employee_code`, `status`, `last_login_time`, `last_login_ip`) VALUES
(5, 'cw', 'e10adc3949ba59abbe56e057f20f883e', 'hj001T2', 1, NULL, NULL),
(7, 'jl', 'e10adc3949ba59abbe56e057f20f883e', '123132123123123123123', 1, NULL, NULL),
(8, 'gh', 'e10adc3949ba59abbe56e057f20f883e', '123123', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_login_ip` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login_time` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '状态：1-存在，0-不存在'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `user_perm`
--

CREATE TABLE `user_perm` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL COMMENT '权限名',
  `code` varchar(128) NOT NULL COMMENT '权限代号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL COMMENT '角色名',
  `code` varchar(128) NOT NULL COMMENT '角色代号',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态：1-存在，0-不存在'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `work_note`
--

CREATE TABLE `work_note` (
  `id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `date` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bonus_details`
--
ALTER TABLE `bonus_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calculate_log`
--
ALTER TABLE `calculate_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calculate_store`
--
ALTER TABLE `calculate_store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commission_details`
--
ALTER TABLE `commission_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contract_images`
--
ALTER TABLE `contract_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contract_process`
--
ALTER TABLE `contract_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cost_details`
--
ALTER TABLE `cost_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_position`
--
ALTER TABLE `employee_position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grant_log`
--
ALTER TABLE `grant_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `position_adjustment_log`
--
ALTER TABLE `position_adjustment_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reduce_salary`
--
ALTER TABLE `reduce_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_details`
--
ALTER TABLE `salary_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_bonus_rule`
--
ALTER TABLE `staff_bonus_rule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_contract`
--
ALTER TABLE `staff_contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_employee`
--
ALTER TABLE `staff_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_port`
--
ALTER TABLE `staff_port`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_position`
--
ALTER TABLE `staff_position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_position_level`
--
ALTER TABLE `staff_position_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_transfer_record`
--
ALTER TABLE `staff_transfer_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_city`
--
ALTER TABLE `store_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_company`
--
ALTER TABLE `store_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_cost`
--
ALTER TABLE `store_cost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_income`
--
ALTER TABLE `store_income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_store`
--
ALTER TABLE `store_store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_zone`
--
ALTER TABLE `store_zone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_perm`
--
ALTER TABLE `user_perm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_note`
--
ALTER TABLE `work_note`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `bonus_details`
--
ALTER TABLE `bonus_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `calculate_log`
--
ALTER TABLE `calculate_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `calculate_store`
--
ALTER TABLE `calculate_store`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `commission_details`
--
ALTER TABLE `commission_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `contract_images`
--
ALTER TABLE `contract_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `contract_process`
--
ALTER TABLE `contract_process`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `cost_details`
--
ALTER TABLE `cost_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `employee_position`
--
ALTER TABLE `employee_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- 使用表AUTO_INCREMENT `grant_log`
--
ALTER TABLE `grant_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `position_adjustment_log`
--
ALTER TABLE `position_adjustment_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `reduce_salary`
--
ALTER TABLE `reduce_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `salary_details`
--
ALTER TABLE `salary_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `staff_bonus_rule`
--
ALTER TABLE `staff_bonus_rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;
--
-- 使用表AUTO_INCREMENT `staff_contract`
--
ALTER TABLE `staff_contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `staff_employee`
--
ALTER TABLE `staff_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- 使用表AUTO_INCREMENT `staff_port`
--
ALTER TABLE `staff_port`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `staff_position`
--
ALTER TABLE `staff_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;
--
-- 使用表AUTO_INCREMENT `staff_position_level`
--
ALTER TABLE `staff_position_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `staff_transfer_record`
--
ALTER TABLE `staff_transfer_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `store_city`
--
ALTER TABLE `store_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `store_company`
--
ALTER TABLE `store_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `store_cost`
--
ALTER TABLE `store_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `store_income`
--
ALTER TABLE `store_income`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `store_store`
--
ALTER TABLE `store_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- 使用表AUTO_INCREMENT `store_zone`
--
ALTER TABLE `store_zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `user_perm`
--
ALTER TABLE `user_perm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `work_note`
--
ALTER TABLE `work_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
