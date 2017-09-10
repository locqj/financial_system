<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

date_default_timezone_set('Asia/Shanghai');

class StaffCalculateController extends Controller
{   
   
	/**
	 * [cCommissionDetails 计算佣金提成]
	 * @param  [type] $update_code [description]
	 * @return [type]              [description]
	 */
    public function cCommissionDetails($update_code, $year, $month){
    	$employee_position = employee_position()->with('contract','positionAdjustment')->get();
    	//遍历每个员工
    	foreach ($employee_position as $key => $value) {
    		$store_now = store_new()->where('code',$value->store_code)->first();
    		//查询员工是否改变职位
    		$position_adjustment = $value->positionAdjustment()->where('year',$year)->where('month',$month)->first();
    		if($position_adjustment){
    			$value->position_code = $position_adjustment->old_position_code;
    			$value->store_code = $position_adjustment->old_store_code;
    			$store_now = store_new()->where('code',$position_adjustment->old_store_code)->first();
    		}

    		//计算签单金额
    		$contract = $value->contract()->where('year', $year)->where('month', $month)->where('status_del','0')->get();
    		if($contract){
	    		$amount_all = 0;
	    		foreach ($contract as $key_1 => $value_1) {
	    			if($value_1->is_signed)
	    				$amount_all += $value_1->real_amount;
	    			else
	    				$amount_all += $value_1->sign_amount;
	    		}

	    		if($amount_all > 0){
	    			//插入佣金
	    			$commission_detail = commission_details_new();
	    			$commission_detail->store_code = $value->store_code;
					$commission_detail->amount = $amount_all;
					$commission_detail->employee_code = $value->employee_code;
					$commission_detail->created_at = date('Y-m-d H:i:s');
					$commission_detail->year = $year;
					$commission_detail->month = $month;
					$commission_detail->update_code = $update_code;
					$commission_detail->save();

	    			//计算提成
	    			//销售提成
	    			$bonus_rule = bonus_rule_ins()->where('store_position_code',$value->store_code.$value->position_code)->get();
	    			
	    			foreach ($bonus_rule as $key_rule => $value_rule) {
	    				if($value_rule->rule_key == '1' && $amount_all > $value_rule->bottom && $amount_all < $value_rule->top){
	    					$bonus_detail = bonus_details_new();
	    					$bonus_detail->bonus_amount = $amount_all * $value_rule->percentage;
	    					$bonus_detail->employee_code = $value->employee_code;
	    					$bonus_detail->created_at = date('Y-m-d H:i:s');
	    					$bonus_detail->year = $year;
	    					$bonus_detail->month = $month;
	    					$bonus_detail->is_cost = $value_rule->is_cost;
	    					$bonus_detail->store_code = $value->store_code;
	    					
	    					$bonus_detail->store_type = $store_now->type;
	    					$bonus_detail->update_code = $update_code;
	    					$bonus_detail->bonus_rule_key = $value_rule->rule_key;
	    					$bonus_detail->save();
	    					break;
	    				}
	    			}
	    		}
	    	}
    	}
    	echo 'finish';

    }

    /**
     * [cCalculateStore description]
     * @param  [type] $update_code [更新标志]
     * @param  [type] $year        [年]
     * @param  [type] $month       [月]
     * @return [type]              [description]
     */
    public function cCalculateStore($update_code, $year, $month){
    	$store = store_new()->with('contract', 'cost_details','salary','bonus')->get();
    	//遍历每个店铺
    	foreach ($store as $key_store => $value_store) {
    		//计算签单金额[总收入]
    		$contract = $value_store->contract()->where('year',$year)->where('month',$month)->where('status_del','0')->get();
    		if($contract){
    			$income = 0;
    			foreach ($contract as $key_contract => $value_contract) {
    				if($value_contract->is_signed)
	    				$income += $value_contract->real_amount;
	    			else
	    				$income += $value_contract->sign_amount;
    			}
    		}

    		//计算店铺成本[总支出]
    		$outcome = 0;
    		//计算店铺支出
    		$cost_all = $value_store->cost_details()->where('year',$year)->where('month',$month)->sum('amount');
    		$outcome += $cost_all;
    		//计算基本工资[支出]
    		$salary_all = $value_store->salary()->where('year',$year)->where('month',$month)->sum('salary_amount');
    		$outcome += $salary_all;
    		//计算分红总支出
    		$bonus_all = $value_store->bonus()->where('year',$year)->where('month',$month)->where('is_cost','1')->sum('bonus_amount');
    		$outcome += $bonus_all;
    		//计算利润
    		$profit = $income - $outcome;

    		//插入数据
    		$calculate_store = calculate_store_new();
    		$calculate_store->income = $income;
    		$calculate_store->outcome = $outcome;
    		$calculate_store->profit = $profit;
    		$calculate_store->store_code = $value_store->code;
    		$calculate_store->created_at = date('Y-m-d H:i:s');
    		$calculate_store->update_code = $update_code;
    		$calculate_store->year = $year;
    		$calculate_store->month = $month;
    		$calculate_store->save();
    	}
    }

    public function cUse(){
    	$update_code = 'hj'.time();
    	$this->cCommissionDetails($update_code, 2017, 6);
    	// $this->cCalculateStore($update_code, 2017, 6);
    }
}
