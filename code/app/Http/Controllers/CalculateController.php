<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Session;

date_default_timezone_set('PRC');

class CalculateController extends Controller
{   
    
    /**
     * [cFinalCount 总结算按钮]
     * @return [type] [description]
     */
    public function cFinalCount($year, $month)
    {   
        $employee_code = session::get('employee_code'); //操作人员的employee_code
        $update_code = $this->cAutoUpdateCode($year, $month); //获取update_code
        $this->cEmployeeSalary($update_code, $year, $month); //必须作为最先算
        $this->cSalaryAvg($update_code, $year, $month); //总店人员工资分摊--》先于店铺成本计算
        $this->cQySalaryAvg($update_code, $year, $month); //区域经理区域分摊
        $this->cInsertCostDetail($update_code, $year, $month); //过户费用均摊--》先于店铺成本计算
        $this->cInsertPortFee($update_code, $year, $month); //插入店铺承担的端口费
        $this->cStoreCost($update_code, $year, $month);
        $this->cCommissionDetails($update_code, $year, $month);
        $this->cCalculateStore($update_code, $year, $month);
        $this->cProfit($update_code, $year, $month); // 分红计算
        $this->cUpdateCodeLog($update_code, $employee_code, $year, $month);
        $data['update_code'] = $update_code;
        $data['date'] = date("Y-m-d H:i:s");
        return suc($data);

    }

    public function cFinalCountSeason($year, $season){
        $employee_code = session::get('employee_code'); //操作人员的employee_code
        switch ($season) {
            case '1':
                $start_month = 1;
                break;
            case '2':
                $start_month = 4;
                break;
            case '3':
            $start_month = 7;
            break;
            case '4':
            $start_month = 10;
            break;
            
            default:
                # code...
                break;
        }
        $update_code_return = array();
        $key = 0;
        for ($i=$start_month; $i < $start_month+3; $i++) { 
            $update_code = $this->cAutoUpdateCode($year, $i); //获取update_code
            $this->cEmployeeSalary($update_code, $year, $i); //必须作为最先算
            $this->cSalaryAvg($update_code, $year, $i); //总店人员工资分摊--》先于店铺成本计算
            $this->cQySalaryAvg($update_code, $year, $i); //区域经理区域分摊
            $this->cInsertCostDetail($update_code, $year, $i); //过户费用均摊--》先于店铺成本计算
            $this->cInsertPortFee($update_code, $year, $month); //插入店铺承担的端口费
            $this->cStoreCost($update_code, $year, $i);
            $this->cCommissionDetails($update_code, $year, $i);
            $this->cCalculateStore($update_code, $year, $i);
            $this->cProfit($update_code, $year, $i); // 分红计算
            $this->cUpdateCodeLog($update_code, $employee_code, $year, $i);
            $update_code_return[$key++] = $update_code;
        }
        $data['update_code'] = $update_code_return;
        $data['date'] = date("Y-m-d H:i:s");
        return suc($data);

    }
    /*店铺成本details*/
    public function cStoreCost($update_code, $year, $month)
    {   
        /*先把基本工资details表中的update_code的总店工资拿出来算作分店成本，插入规则cost_new*/
        $store_cost = cost_new()->get();
        foreach ($store_cost as $key => $value) {
            $value->pay_month = json_decode($value->pay_month);
            $value->pay_stores = json_decode($value->pay_stores);
            $get_count = count($value->pay_stores);
            /*按照还款店铺划分*/
            foreach ($value->pay_stores as $ke => $vl) {
                /*根据划分具体期数生成数据*/
                foreach ($value->pay_month as $k => $v) {
                    if($v->year == $year && $v->month == $month){
                        $store_code = $vl;
                        $month = $v->month;
                        $year = $v->year;
                        $amount = $value->unit / $get_count;
                        $created_at = date("Y-m-d H:i:s");
                        if($value->owner_store_code == 'hj001'){
                            $category = $value->category."[总店分摊]";
                        }else if(substr($value->owner_store_code, 0, 2) == 'qy'){
                            $category = $value->category."[区域分摊]";
                        }else{
                            $category = $value->category;
                        }
                            $add_cost_details = DB::table('cost_details')->insert(
                                [
                                'store_code' => $store_code,
                                'month' => $month,
                                'year' => $year,
                                'amount' => $amount,
                                'created_at' => $created_at,
                                'category' => $category,
                                'update_code' => $update_code
                                ]);
                        }
                }
            }
        }
    }
    /*员工基本工资details*/
    public function cEmployeeSalary($update_code, $year, $month)
    {
        /*employee_code salary_amount, year month created_at store_type update_code*/
        $employee_inf = employee_ins()->where('status', 1)->get();
        //$add_salary_details = salary_details_ins();
        foreach ($employee_inf as $key => $value) {
            $employee_position = employee_position()
                ->where('employee_code', $value->code)
                ->with('store')->with('position')->first();
                /*获取员工工资*/
                $employee_code_salary = position_ins()
                    ->where('store_code', $employee_position->store_code)->where('code', $employee_position->position_code)->first();
                $employee_code = $value->code;
                $created_at = date('Y-m-d h:i:sa');
                $salary_amount = $employee_code_salary->salary;
                if(substr($employee_position->store_code, 0, 4) != 'qy00'){
                    $store_type = $employee_position->store->type;
                }else{
                    $store_type = 2; //区域独立出来的
                }
                $store_code = $employee_position->store_code;
                $add_salary_details = DB::table('salary_details')->insert([
                    'employee_code' => $employee_code,
                    'month' => $month,
                    'year' => $year,
                    'created_at' => $created_at,
                    'salary_amount' => $salary_amount,
                    'store_type' => $store_type,
                    'store_code' => $store_code,
                    'update_code' => $update_code
                    ]);

        }
    }

    /**
     * [cProfit 分红录入]
     * @param  [type] $update_code [description]
     * @param  [type] $year        [description]
     * @param  [type] $month       [description]
     * @return [type]              [description]
     */
    public function cProfit($update_code, $year, $month)
    {
        $employee_position = employee_position()->with('employee', 'store')->get();
        //遍历每个员工
        foreach ($employee_position as $key => $value) {
            /*员工存在才去帮他算*/
            if($value->employee->status == 1) {
                /*不考虑职位调整*/
                // $chack_adj_log = DB::table('position_adjustment_log')
                // ->where('employee_code', $value->employee_code)->where('year',$year)->where('month',$month)->first();
                // if($chack_adj_log){
                //     $value->position_code = $chack_adj_log->old_position_code;
                //     $value->store_code = $chack_adj_log->old_store_code;
                //     $store_old = store_new()->where('code',$chack_adj_log->old_store_code)->first();
                //     $store_type = $store_old->type;
                // }else{
                    if(substr($value->store_code, 0, 4) == 'qy00'){
                        $store_type = '3';
                    }else{
                        $store_type = $value->store->type;
                    }
                // }

                switch (substr($value->position_code, 0, 2)) {
                    case 'zl':
                        $this->cProfitStorezl($update_code, $value->store_code, $store_type,
                        $value->position_code, $year, $month, $value->employee_code);
                        break;
                    case 'qy':
                        $this->cProfitZoneSave($update_code, $value->store_code, $store_type,
                        $value->position_code, $year, $month, $value->employee_code);
                        break;
                    case 'dz':
                        $this->cProfitStoredz($update_code, $value->store_code, $store_type,
                        $value->position_code, $year, $month, $value->employee_code);
                        break;
                    case 'jl':
                         $this->cProfitjl($update_code, $value->store_code, $store_type,
                         $value->position_code, $year, $month, $value->employee_code);
                        break;
                    default:
                        # code...
                        break;
                }
                // if($value->position_code == "zl01")
                // {
                //     /*店长的分红提成*/
                //     $this->cProfitStoredz($update_code, $value->store_code, $store_type,
                //         $value->position_code, $year, $month, $value->employee_code);
                // }else if($value->position_code == 'qy01') {
                //     /*区域经理的分红提成*/
                //     $this->cProfitZoneSave($update_code, $value->store_code, $store_type,
                //         $value->position_code, $year, $month, $value->employee_code);
                // }else if($value->position_code == "dz01") {
                //     /*助理的分红提成*/
                //     $this->cProfitStorezl($update_code, $value->store_code, $store_type,
                //         $value->position_code, $year, $month, $value->employee_code);
                // }else if($value->position_code == "jl01") {
                //     /*总经理的分红提成*/
                //     $this->cProfitjl($update_code, $value->store_code, $store_type,
                //         $value->position_code, $year, $month, $value->employee_code);
                // }
            }
        }
    }

    /**
     * [cCommissionDetails 计算佣金提成]
     * @param  [type] $update_code [description]
     * @return [type]              [description]
     */
    public function cCommissionDetails($update_code, $year, $month){
        $employee_position = employee_position()->with('contract','positionAdjustment','source_contract', 'employee')->get();
        //遍历每个员工
         //取出二手房和租房的提供房源的分成比例
        $second_rule = bonus_rule_ins()->where('rule_key', 8)->where('status_del', 0)->first();
        $rent_rule = bonus_rule_ins()->where('rule_key', 9)->where('status_del', 0)->first();
        ////取出一手手房和租房的提供房源的提成规则
        $first_sale_rule = bonus_rule_ins()->where('rule_key', 11)->where('status_del', 0)->first();
        $rent_sale_rule = bonus_rule_ins()->where('rule_key', 12)->where('status_del', 0)->first();
        foreach ($employee_position as $key => $value) {
            //echo $value->employee_code.'--->';
            //查询员工是否改变职位
            // $position_adjustment = $value->positionAdjustment()->where('year',$year)->where('month',$month)->first();
            // if($position_adjustment){
            //     $value->position_code = $position_adjustment->old_position_code;
            //     $value->store_code = $position_adjustment->old_store_code;
            //     $store_old = store_new()->where('code',$position_adjustment->old_store_code)->first();
            // }
            if(substr($value->position_code, 0, 2) == 'xs' ||substr($value->position_code, 0, 2) == 'zl'){
                //计算签单金额
                //主动签单方
                $contract = $value->contract()->where('year', $year)->where('month', $month)->where('is_signed', 1)->where('status_del','0')->get();
                //提供房源方
                $source_contract = $value->source_contract()->where('year', $year)->where('month', $month)->where('is_signed', 1)->where('status_del','0')->get();

                //定义一手二手和租房的金额
                $amount = 0;
                $second_amount = 0;
                $rent_amount = 0;
                $contract_num = 0;
                //
                if(count($contract)){
                    foreach ($contract as $key_contract => $value_contract) {
                        $contract_num++;
                            //结算的根据三种单子计算佣金
                            switch ($value_contract->type) {
                                case '1':
                                    $amount += $value_contract->real_amount;
                                    break;
                                case '2':
                                    if($value_contract->is_divide)
                                        $second_amount += $value_contract->real_amount * $second_rule->percentage;
                                    else
                                        $second_amount += $value_contract->real_amount;
                                    break;
                                case '3':
                                    if($value_contract->is_divide)
                                        $rent_amount += $value_contract->real_amount * $rent_rule->percentage;
                                    else
                                        $rent_amount += $value_contract->real_amount;
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                    }
                }

                if(count($source_contract)){
                    foreach ($source_contract as $key_source_contract => $value_source_contract) {
                        $contract_num++;
                            //结算的根据三种单子计算佣金
                            switch ($value_source_contract->type) {
                                case '2':
                                        $second_amount += $value_source_contract->real_amount * (1 - $second_rule->percentage );
                                    break;
                                case '3':
                                        $rent_amount += $value_source_contract->real_amount * (1- $rent_rule->percentage );
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                    }
                }

                    //求总和插入佣金
                    $amount_all = $amount + $second_amount + $rent_amount;
                    // echo $value->employee_code.'--->'.$amount_all.'---';
                    
                    //计算端口费
                    $this->cCalculatePort($year, $month, $amount_all, $value->employee_code, $value->store_code, $update_code);
                   
                    if($amount_all > 0){

                        //插入佣金
                        $commission_detail = commission_details_new();
                        // $test =$value->contract()->first();
                        $arr = $contract->toArray();
                        if($contract->isEmpty())
                        {
                            $source_contract = $value->source_contract;
                            $arr = $source_contract->toArray();
                            $commission_detail->store_code = $arr['0']['source_store'];
                            //dd($value);
                        }else
                        {
                           $commission_detail->store_code = $arr['0']['store_code'];//bug员工所属店铺调整后，佣金所属店铺出错 
                        }
                        
                        $commission_detail->amount = round($amount, 2);
                        $commission_detail->second_amount = round($second_amount, 2);
                        $commission_detail->rent_amount = round($rent_amount, 2);
                        $commission_detail->contract_number = $contract_num;
                        $commission_detail->employee_code = $value->employee_code;
                        $commission_detail->created_at = date('Y-m-d H:i:s');
                        $commission_detail->year = $year;
                        $commission_detail->month = $month;
                        $commission_detail->update_code = $update_code;
                        $commission_detail->save();

                        //计算提成
                        //二手房销售提成
                        $bonus_rule = bonus_rule_ins()->where('rule_key', 1)->where('status_del', 0)->get(); //取出销售阶梯提成
                        $bonus_sale = 0;
                        foreach ($bonus_rule as $key_rule => $value_rule) {
                            if($value_rule->bottom == 0)
                                    $value_rule->bottom = 1;
                            if($second_amount > $value_rule->top && $value_rule->top != "+00")
                            {
                                $bonus_sale += ($value_rule->top - $value_rule->bottom + 1)*$value_rule->percentage;
                            }
                            if(($value_rule->top == '+00' && $second_amount >= $value_rule->bottom) || ($second_amount >= $value_rule->bottom && $second_amount <= $value_rule->top)){
                                $bonus_sale += ($second_amount - $value_rule->bottom + 1)*$value_rule->percentage;
                            }
                        }

                        //一手房销售提成
                        $bonus_sale += $first_sale_rule->percentage * $amount;
                        //租售房
                        $bonus_sale += $rent_sale_rule->percentage * $rent_amount;
                        // echo 'bonus:'.$bonus_sale.';';echo '--first:'.$amount.';';echo '--second:'.$second_amount.';';echo 'rent:'.$rent_amount.';';die;
                        $bonus_detail = bonus_details_new();
                        $bonus_detail->bonus_amount = round($bonus_sale, 2);
                        $bonus_detail->employee_code = $value->employee_code;
                        $bonus_detail->created_at = date('Y-m-d H:i:s');
                        $bonus_detail->year = $year;
                        $bonus_detail->month = $month;
                        $bonus_detail->is_cost = $value_rule->is_cost;
                        
                        $arr = $contract->toArray();
                        if($contract->isEmpty()){
                            $source_contract = $value->source_contract;
                            $arr = $source_contract->toArray();
                            $bonus_detail->store_code = $arr['0']['source_store'];
                        }else{
                            $bonus_detail->store_code = $arr['0']['store_code'];
                        }
                        /*不考虑职位调整*/
                        // if($position_adjustment)
                        //     $bonus_detail->store_type = $store_old->type;
                        // else{
                        $store_now = store_new()->where('code',$value->store_code)->first();
                        $bonus_detail->store_type = $store_now->type;
                        // }
                        $bonus_detail->update_code = $update_code;
                        $bonus_detail->bonus_rule_key = $value_rule->rule_key;
                        $bonus_detail->save();
                    }
                
            }
        }
    }

    /**
     * 计算端口费---未绑定员工算入工资的店铺自己承担
     */
    public function cInsertPortFee($update_code, $year, $month){
        $store = store_new()->where('type','2')->with('port')->get();
        if(strlen($month) == 1){
            $year_month = $year.'0'.$month;
        }else{
            $year_month = $year.$month;
        }
        foreach ($store as $key => $value) {
            $port_fee = $value->port()->where('is_personal', 0)->where('start_year_month', '<=', $year_month)->where('end_year_month', '>=', $year_month)->where('status', 1)->sum('unit');
            if($port_fee > 0){
                //店铺支付
                $cost_details = cost_details_ins();
                $cost_details->category = '店铺自付端口费';
                $cost_details->amount = $port_fee;
                $cost_details->store_code = $value->code;
                $cost_details->year = $year;
                $cost_details->month = $month;
                $cost_details->update_code = $update_code;
                $cost_details->created_at = date("Y-m-d H:i:s");
                $cost_details->save();
            }
        }
    }
    
    /**
     * 计算端口费---绑定员工算入工资的
     */
    public function cCalculatePort($year, $month,$amount_all, $employee_code, $store_code, $update_code){
        //端口计算规则
        $port_rule = bonus_rule_ins()->where('rule_key', 13)->where('status_del', 0)->get();
        //店铺和人都对的情况下再计算，防止调整店铺
        if(strlen($month) == 1)
            $month = '0'.$month;
        $port_amount = staff_port_ins()->where('is_personal', 1)->where('start_year_month', '<=', $year.$month)->where('end_year_month', '>=', $year.$month)->where('employee_code', $employee_code)->where('store_code', $store_code)->where('status', 1)->sum('unit');
        if($port_amount == 0){
            return 0;
        }
        $percentage = 0;
        foreach ($port_rule as $key => $value) {
            if($key == 0 && $amount_all < $value->bottom){
                break;
            }else if($key == (count($port_rule) - 1) && $amount_all >= $value->bottom){
                $percentage = $value->percentage;
                break;
            }else if($amount_all >= $value->bottom && $amount_all < $port_rule[$key + 1]->bottom){
                $percentage = $value->percentage;
                break;
            }
        }

        $reduce_del = salary_reduce_ins()->where('employee_code', $employee_code)->where('store_code', $store_code)->where('status', 1)->where('is_port', 1)->first();
        if($reduce_del){
            $reduce_del->status = 0;
            $reduce_del->save();
        }
        if($percentage != 1){
            //自付
            $reduce = salary_reduce_ins();
            $reduce->employee_code = $employee_code;
            $reduce->store_code = $store_code;
            $reduce->category = '自付端口费【自付比例：'.(100 - $percentage*100).'%】';
            $reduce->amount = $port_amount*(1 - $percentage);
            $reduce->record_user = 'hj001T2';
            $reduce->status = 1;
            $reduce->created_at = date("Y-m-d H:i:s");
            $reduce->year =  $year;
            $reduce->month =  $month;
            $reduce->day =  1;
            $reduce->is_port = 1;
            $reduce->save();
        }
        if($percentage != 0){
            //店铺支付
            $cost_details = cost_details_ins();
            $cost_details->category = '分摊员工端口费【员工编号：'.$employee_code.',当月佣金总额：'.$amount_all.',承担比例：'.($percentage*100).'%】';
            $cost_details->amount = $port_amount * $percentage;
            $cost_details->store_code = $store_code;
            $cost_details->year = $year;
            $cost_details->month = $month;
            $cost_details->update_code = $update_code;
            $cost_details->created_at = date("Y-m-d H:i:s");
            $cost_details->save();
        }
    }

     /**
     * [cCalculateStore description]
     * @param  [type] $update_code [更新标志]
     * @param  [type] $year        [年]
     * @param  [type] $month       [月]
     * @return [type]              [description]
     */
    public function cCalculateStore($update_code, $year, $month){
        $store = store_new()->where('type','2')->with('contract', 'cost_details','salary','bonus','income')->get();
        //取出二手房和租房的提供房源的分成比例
        $second_rule = bonus_rule_ins()->where('rule_key', 8)->where('status_del', 0)->first();
        $rent_rule = bonus_rule_ins()->where('rule_key', 9)->where('status_del', 0)->first();
        //遍历每个店铺
        foreach ($store as $key_store => $value_store) {
            $income = 0; //总收入
            //计算签单金额[总收入]
            $contract = $value_store->contract()->where('year',$year)->where('month',$month)->where('is_signed', 1)->where('status_del','0')->get();
            if($contract){
                foreach ($contract as $key_contract => $value_contract) {
                   //结算的根据三种单子计算佣金
                            switch ($value_contract->type) {
                                case '1':
                                    $income += $value_contract->real_amount;
                                    break;
                                case '2':
                                    if($value_contract->is_divide)
                                        $income += $value_contract->real_amount * $second_rule->percentage;
                                    else
                                        $income += $value_contract->real_amount;
                                    break;
                                case '3':
                                    if($value_contract->is_divide)
                                        $income += $value_contract->real_amount * $rent_rule->percentage;
                                    else
                                        $income += $value_contract->real_amount;
                                    break;
                                default:
                                    # code...
                                    break;
                            }

                }
            }
            //遍历提供房源
            $contract_source = $value_store->contract_source()->where('year',$year)->where('month',$month)->where('is_signed', 1)->where('status_del','0')->get();
            foreach ($contract_source as $key_contract_source => $value_contract_source) {
                //结算的根据三种单子计算佣金
                switch ($value_contract_source->type) {
                    case '2':
                            $income += $value_contract_source->real_amount * (1 - $second_rule->percentage );
                        break;
                    case '3':
                            $income += $value_contract_source->real_amount * (1- $rent_rule->percentage );
                        break;
                    default:
                        # code...
                        break;
                }
            }
            //计算录入金额[总收入]
            $income += $value_store->income()->where('year', $year)->where('month', $month)->sum('total');
            //计算店铺成本[总支出]
            $outcome = 0;
            //计算店铺支出
            $cost_all = $value_store->cost_details()->where('update_code',$update_code)->where('year',$year)->where('month',$month)->sum('amount');
            $outcome += $cost_all;
            //计算基本工资[支出]
            $salary_all = $value_store->salary()->where('update_code',$update_code)->where('year',$year)->where('month',$month)->sum('salary_amount');
            $outcome += $salary_all;
            //计算佣金提成支出
            $bonus_all = $value_store->bonus()->where('update_code',$update_code)->where('year',$year)->where('month',$month)->where('is_cost','1')->sum('bonus_amount');
            $outcome += $bonus_all;
            //计算利润
            $profit = $income - $outcome;

            //插入数据
            $calculate_store = calculate_store_new();
            $calculate_store->income = round($income, 2);
            $calculate_store->outcome = round($outcome, 2);
            $calculate_store->profit = round($profit, 2);
            $calculate_store->store_code = $value_store->code;
            $calculate_store->created_at = date('Y-m-d H:i:s');
            $calculate_store->update_code = $update_code;
            $calculate_store->year = $year;
            $calculate_store->month = $month;
            $calculate_store->save();
        }
    }


    public function cEmployeeWage()
    {
        $store = store_new()->where('status_del', 0)->get();
        $store_code = store_new()->where('status_del', 0)->where('type', 2)->orderBy('id', 'desc')->select('code')->first();
        $store_code = $store_code->code;
        $employee_wage = employee_wage_ins()
            ->where('store_code', $store_code)->get();
        $years = employee_wage_ins()->groupBy('year')->select('year')->get();
        $year = employee_wage_ins()->groupBy('year')->orderBy('id', 'desc')->select('year')->first();
        $year = $year->year;
        $month = employee_wage_ins()->groupBy('month')->orderBy('id', 'desc')->select('month')->first();
        $month = $month->month;
        return view('employee.employee_wage', compact('store', 'store_code', 'year', 'month', 'yaers', 'employee_wage'));
    }
    /**
     * [cSalaryAvg 录入分店分摊总店员工工资费用]
     * @param  [type] $update_code [description]
     * @return [type]              [description]
     */
    protected function cSalaryAvg($update_code, $year, $month)
    {
        $get_salary_count_hj001 = salary_details_ins()->where('update_code', $update_code)->where('store_code', 'hj001')->sum('salary_amount');
        $get_store = store_new()->where('status_del', 0)->where('type', '2')->get(); //获取所所有分店
        $amount = round($get_salary_count_hj001 / count($get_store), 2);
        foreach ($get_store as $key => $value) {
            $cost_details = cost_details_ins();
            $cost_details->category = '人员工资[总店分摊]';
            $cost_details->amount = $amount;
            $cost_details->store_code = $value->code;
            $cost_details->year = $year;
            $cost_details->month = $month;
            $cost_details->update_code = $update_code;
            $cost_details->created_at = date("Y-m-d H:i:s");
            $cost_details->save();
        }
    }

    /**
     * [cSalaryAvg 录入该区域分店分摊区域工资费用]
     * @param  [type] $update_code [description]
     * @return [type]              [description]
     */
    protected function cQySalaryAvg($update_code, $year, $month)
    {
        $get_salary_count_qy = salary_details_ins()->where('update_code', $update_code)->where('store_code', 'like', 'qy00%')->get();
        foreach ($get_salary_count_qy as $key => $value) {
            $get_store = store_new()->where('status_del', 0)->where('zone_code', $value->store_code)->get(); //获取所所有分店
            if(count($get_store) > 0){
                $amount = round($value->salary_amount / count($get_store), 2);
                foreach ($get_store as $k => $v) {
                    $cost_details = cost_details_ins();
                    $cost_details->category = '区域经理工资[区域分摊]';
                    $cost_details->amount = $amount;
                    $cost_details->store_code = $v->code;
                    $cost_details->year = $year;
                    $cost_details->month = $month;
                    $cost_details->update_code = $update_code;
                    $cost_details->created_at = date("Y-m-d H:i:s");
                    $cost_details->save();
                }
            }
        }
    }


    /**
     * [cUpdateCodeLog 更新update_code记录]
     * @param  [type] $update_code   [description]
     * @param  [type] $employee_code [description]
     * @return [type]                [description]
     */
    protected function cUpdateCodeLog($update_code, $employee_code, $year, $month)
    {
        $update_code_exist = DB::table('calculate_log')->
            where('year', $year)->where('month', $month)->where('is_last', 1)->exists();
        if($update_code_exist){

            DB::table('calculate_log')->where('year', $year)
                ->where('month', $month)->where('is_last', 1)->update([
                'is_last' => 0
                    ]);
            DB::table('calculate_log')->insert([
                'update_code' => $update_code,
                'employee_code' => $employee_code,
                'year' => $year,
                'month' => $month,
                'created_at' => date("Y-m-d H:i:s"),
                'is_last' => 1,
                    ]);
        }else{
            DB::table('calculate_log')->insert([
                'update_code' => $update_code,
                'employee_code' => $employee_code,
                'year' => $year,
                'month' => $month,
                'created_at' => date("Y-m-d H:i:s"),
                'is_last' => 1,
                    ]);
        }
    }

    /**
     * [cInsertCostDetail 过户录入cost_deatails（改为均分下去）]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @param  [type] $total      [description]
     * @param  [type] $store_code [description]
     * @param  [type] $number     [description]
     * @return [type]             [description]
     */
    protected function cInsertCostDetail($update_code, $year, $month)
    {
        $get_transer_amount = transfer_ins()
            ->where('status_del', 0)->where('year', $year)->where('month', $month)->sum('amount');
        /*没有过户费用就不记录*/
        if($get_transer_amount != 0){
            $get_store = store_new()->where('status_del', 0)->where('type', '2')->get();
            $avg = round($get_transer_amount / count($get_store), 2); //保留一位小数
            foreach ($get_store as $key => $value) {
                $cost_detail = cost_details_ins();
                $cost_detail->category = '过户费用[总店分摊]';
                $cost_detail->amount = $avg;
                $cost_detail->store_code = $value->code;
                $cost_detail->month = $month;
                $cost_detail->year = $year;
                $cost_detail->update_code = $update_code;
                $cost_detail->created_at = date("Y-m-d H:i:s");
                $cost_detail->save();
            }
        }
    }

    /*店长分红提成*/
    protected function cProfitStoredz($update_code, $store_code, $store_type, $position_code, $year, $month, $employee_code)
    {   
        $get_profit = DB::table('calculate_store')->where('update_code', $update_code)->where('store_code', $store_code)->first();
            // 获取分红规则
        if($get_profit->profit > 0){
            $bonus_rule = bonus_rule_ins()->where('rule_key', '3')->where('status_del', 0)->first();
            $bonus_detail = bonus_details_new();
            $bonus_detail->bonus_amount = round($get_profit->profit * $bonus_rule->percentage, 2);
            $bonus_detail->employee_code = $employee_code;
            $bonus_detail->created_at = date('Y-m-d H:i:s');
            $bonus_detail->year = $year;
            $bonus_detail->month = $month;
            $bonus_detail->is_cost = '0';
            $bonus_detail->store_code = $store_code;
            $bonus_detail->store_type = $store_type;
            $bonus_detail->update_code = $update_code;
            $bonus_detail->bonus_rule_key = $bonus_rule->rule_key; //!!需要考虑
            $bonus_detail->save();
        }
        // 其下的子店铺
        $this->cProfitStoredzOther($update_code, $store_code, $store_type, $position_code, $year, $month, $employee_code);
    }

    /*助理分红提成*/
    protected function cProfitStorezl($update_code, $store_code, $store_type, $position_code, $year, $month, $employee_code)
    {
        $get_profit = DB::table('calculate_store')->where('update_code', $update_code)->where('store_code', $store_code)->first();
            // 获取分红规则
        if($get_profit->profit > 0){
            $bonus_rule = bonus_rule_ins()->where('rule_key', '2')->where('status_del', 0)->first();
            $bonus_detail = bonus_details_new();
            $bonus_detail->bonus_amount = round($get_profit->profit * $bonus_rule->percentage, 2);
            $bonus_detail->employee_code = $employee_code;
            $bonus_detail->created_at = date('Y-m-d H:i:s');
            $bonus_detail->year = $year;
            $bonus_detail->month = $month;
            $bonus_detail->is_cost = '0';
            $bonus_detail->store_code = $store_code;
            $bonus_detail->store_type = $store_type;
            $bonus_detail->update_code = $update_code;
            $bonus_detail->bonus_rule_key = $bonus_rule->rule_key;
            $bonus_detail->save();
        }
    }


    /*区域经理分红提成*/
    protected function cProfitZoneSave($update_code, $store_code, $store_type, $position_code, $year, $month, $employee_code)
    {
        /*跟上面店铺的一样*/
        $get_stores = $this->cGetZoneStore($store_code);
        foreach ($get_stores as $key => $value) {
            $get_zone_profit = calculate_store_new()->where('update_code', $update_code)->where('store_code', $value->code)->first();
            if($get_zone_profit->profit > 0){
                //区域提成规则
                $bonus_rule = bonus_rule_ins()->where('rule_key', '4')->where('status_del', 0)->first();
                /*插入bonus_details*/
                $bonus_detail = bonus_details_new();
                $bonus_detail->bonus_amount = round($get_zone_profit->profit * $bonus_rule->percentage, 2);
                $bonus_detail->employee_code = $employee_code;
                $bonus_detail->created_at = date('Y-m-d H:i:s');
                $bonus_detail->year = $year;
                $bonus_detail->month = $month;
                $bonus_detail->is_cost = '0';
                $bonus_detail->store_code = $store_code;
                $bonus_detail->store_type = $store_type;
                $bonus_detail->update_code = $update_code;
                $bonus_detail->bonus_rule_key = $bonus_rule->rule_key;
                $bonus_detail->cstore_code = $value->code; //子类的store_code
                $bonus_detail->save();
            }
        }
        

    }
    /*总经理分红提成*/ 
    protected function cProfitjl($update_code, $store_code, $store_type, $position_code, $year, $month, $employee_code)
    {
    
        $get_stores = store_new()->where('status', 1)->where('type', 2)->get();
        foreach ($get_stores as $key => $value) {
            $get_zone_profit = calculate_store_new()->where('update_code', $update_code)->where('store_code', $value->code)->first();
            if($get_zone_profit->profit > 0){
                //区域提成规则
                $bonus_rule = bonus_rule_ins()->where('rule_key', '5')->where('status_del', 0)->first();
                /*插入bonus_details*/
                $bonus_detail = bonus_details_new();
                $bonus_detail->bonus_amount = round($get_zone_profit->profit * $bonus_rule->percentage, 2);
                $bonus_detail->employee_code = $employee_code;
                $bonus_detail->created_at = date("Y-m-d H:i:s");
                $bonus_detail->year = $year;
                $bonus_detail->month = $month;
                $bonus_detail->is_cost = '0';
                $bonus_detail->store_code = $store_code;
                $bonus_detail->store_type = $store_type;
                $bonus_detail->update_code = $update_code;
                $bonus_detail->bonus_rule_key = $bonus_rule->rule_key;
                $bonus_detail->cstore_code = $value->code; //子类的store_code
                $bonus_detail->save();
            }
        }
    }
    // 录入该店铺的子店铺的利润算作本店店长分红
    protected function cProfitStoredzOther($update_code, $store_code, $store_type, $position_code, $year, $month, $employee_code)
    {   
        //二级店铺分红规则
        $bonus_rule = bonus_rule_ins()->where('rule_key', '6')->where('status_del', 0)->first();
        // 找到该店的子店铺
        $get_stores = store_new()->where('status', 1)->where('parent_code', $store_code)->get();
        foreach ($get_stores as $key => $value) {
            $get_zone_profit = calculate_store_new()->where('update_code', $update_code)->where('store_code', $value->code)->first();
            $effect_months = $this->cCountMonths($value->parent_start_time, $year.'-'.$month);
            if($get_zone_profit->profit > 0 && $effect_months >= 0 && $effect_months <= $bonus_rule->top){
                /*插入bonus_details*/
                $bonus_detail = bonus_details_new();
                $bonus_detail->bonus_amount = round($get_zone_profit->profit * $bonus_rule->percentage, 2);
                $bonus_detail->employee_code = $employee_code;
                $bonus_detail->created_at = date('Y-m-d H:i:s');
                $bonus_detail->year = $year;
                $bonus_detail->month = $month;
                $bonus_detail->is_cost = '0';
                $bonus_detail->store_code = $store_code;
                $bonus_detail->store_type = $store_type;
                $bonus_detail->update_code = $update_code;
                $bonus_detail->bonus_rule_key = $bonus_rule->rule_key;
                $bonus_detail->cstore_code = $value->code; //子类的store_code
                $bonus_detail->save();
            }
        }
    }

    /**
     * 计算月份
     */
    public function cCountMonths($start_day, $end_day){
        $start_explode = explode('-', $start_day);
        $end_explode = explode('-', $end_day);
        $months = 0;
        if($end_explode[0] > $start_explode[0]){
            $months += ($end_explode[0] - $start_explode[0]) * 12;
            $months += $end_explode[1] - $start_explode[1];
        }else if($end_explode[0] = $start_explode[0]){
            if($end_explode[1] >= $start_explode[1]){
                $months += $end_explode[1] - $start_explode[1];
            }else{
                return -1;
            }
        }
        return $months;
    }
}
