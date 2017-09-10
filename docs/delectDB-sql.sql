	/*
	 * 使用说明：将以下语句直接放在SQL中执行即可
	 */
		delete from user where username <> 'cw' AND username <> 'jl' AND username <> 'gh';
		delete from employee_position where position_code <> 'cw01' AND position_code <> 'jl01' AND position_code <> 'gh01';
		delete from store_store where code <> 'hj001';
		delete from staff_position where store_code <> 'hj001';
		delete from staff_employee where name <> 'bruce_zj' AND name <> 'bruce_cw' AND name <> 'bruce_gh';
		delete from staff_bonus_rule where rule_key <> '1' AND rule_key <> 7;
		truncate table bonus_details;
		truncate table calculate_log;
		truncate table calculate_store;
		truncate table commission_details;
		truncate table cost_details;
		truncate table grant_log;
		truncate table migrations;
		truncate table password_resets;
		truncate table position_adjustment_log;
		truncate table reduce_salary;
		truncate table salary_details;
		truncate table staff_contract;
		truncate table staff_port;
		truncate table staff_position_level;
		truncate table staff_transfer_record;
		truncate table store_cost;
		truncate table store_income;
		truncate table store_zone;
		truncate table work_note;


