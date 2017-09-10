<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Session;
use DB;

date_default_timezone_set('Asia/Shanghai');
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * [cConutContract 未过户订单数]
     * @param  [type] $store_code [description]
     * @return [type]             [description]
     */
    public function cConutContract($store_code)
    {

        $contract = contract_ins()
            ->where('status_del', 0)->where('store_code', $store_code)->get();
        $contract_number = null;
        $i = 0;
        /*找出没有过户的单号*/
        foreach ($contract as $key => $value) {
            $exist_transfers = transfer_ins()
                ->where('status_del', 0)
                ->where('store_code', $store_code)
                ->where('contract_number', $value->number)->exists();
            if(!$exist_transfers){
                $contract_number[$i] = $value->number;
                $i++;
            }
        }
        return $i;
    
    }
    
    /**
     * 获取某个店铺销售人员
     */
    public function cGetSaleEmployee($store_code){
        $employee = employee_position()
                ->where('store_code', $store_code)
                ->whereIn('position_code', ['xs01', 'xs02', 'xs03','xs04' , 'xs05', 'zl01', 'zl02', 'zl03'])
                ->with('employee')->with('position')->get();
        foreach ($employee as $key => $value) {
            $get_level = DB::table('staff_position_level')->where('position_code', $value->position_code)->first();
            if($get_level){
                $value->position_level = '销售'.$get_level->name;
            }else{
                $value->position_level = null;
            }
            if($value->employee->status == 0){
                unset($employee[$key]);
            }
        }
        return $employee;
    }
    
    /**
     * 获取所有员工
     */
    public function cGetAllEmployee($store_code){
        $employee = employee_position()
                ->where('store_code', $store_code)
                ->with('employee')->with('position')->get();
        foreach ($employee as $key => $value) {
            $get_level = DB::table('staff_position_level')->where('position_code', $value->position_code)->first();
            if($get_level){
                $value->position_level = '销售'.$get_level->name;
            }else{
                $value->position_level = null;
            }
            if($value->employee->status == 0){
                unset($employee[$key]);
            }
        }
        return $employee;
    }

    public function cGetSalaryDetailPosition($data)
    {
        foreach ($data as $key => $value) {
            $r_data = employee_position()->where('employee_code', $value->employee_code)->with('position')->first();
            $data[$key]['position'] = $r_data->position;
        }
        return $data;
    }
    /*页内跳转*/
    public function cJump($message, $url, $jumpTime = 2)
    {
        $data['message'] = $message;
        $data['url'] = $url;
        $data['jumpTime'] = $jumpTime;
        return view('jump', compact('data', 'user'));
    }
    /*登陆跳转*/
    public function cLoginJump($message, $url, $jumpTime = 2)
    {
        $data['message'] = $message;
        $data['url'] = $url;
        $data['jumpTime'] = $jumpTime;
        return view('login_jump', compact('data', 'user'));
    }
    /**
     * [cEmployeeCount 计算店铺员工总数]
     * @param  [type] $store_code [description]
     * @return [type]             [description]
     */
    public function cEmployeeCount($store_code)
    {
        $employee_count = 0;
        $get_employee_code = employee_position()
            ->where('store_code', $store_code)->with('employee')->get();
        foreach ($get_employee_code as $key => $value) {
            if($value->employee->status == 1){
                $employee_count++;
            }
        }
        return $employee_count;
    }

    /**
     * [cGetContract 获取店铺下的签单号]
     * @param  [type] $store_code [description]
     * @return [type]             [description]
     */
    public function cGetContract($store_code)
    {   
        $contract = contract_ins()
            ->where('status_del', 0)->where('store_code', $store_code)->get();
        $contract_number = null;
        $i = 0;
        /*找出没有过户的单号*/
        foreach ($contract as $key => $value) {
            $exist_transfers = transfer_ins()
                ->where('status_del', 0)
                ->where('store_code', $store_code)
                ->where('contract_number', $value->number)->exists();
            if(!$exist_transfers){
                $contract_number[$i] = $value->number;
                $i++;
            }
        }
        return suc($contract_number);
    }
    /**
     * [cGetUpdateCode 获取最后一次操作的update_code]
     * @return [type] [description]
     */
    public function cGetUpdateCode($year, $month){
        $update_code = DB::table('calculate_log')->where('year', $year)->where('month', $month)->where('is_last','1')->first();
        if($update_code)
            return $update_code->update_code;
        else 
            return null;
    }
    /**
     * [cGetUpdateCodeBySearch 选择当月最新的一个update_code]
     * @param  [type] $year  [description]
     * @param  [type] $month [description]
     * @return [type]        [description]
     */
    public function cGetUpdateCodeBySearch($year, $month){

        $update_code = DB::table('calculate_log')->where('year', $year)->where('month', $month)->where('is_last', 1)->first();
        if($update_code){
            return $update_code->update_code;    
        }else{
            return '0';
        }
        
    }

    /**
     * [cGetUpdateCode 生成update_code]
     * @param  [type] $year  [description]
     * @param  [type] $month [description]
     * @return [type]        [description]
     */
    public function cAutoUpdateCode($year, $month)
    {
        $get_count = calculate_log_ins()->where('year', $year)->where('month', $month)->count();
        $get_count = $get_count + 1;
        return $year.$month.'T'.$get_count;
    }

    /**
     * [cGrantLog 员工工资查询] 
     * @param  [type] $update_code [description]
     * @param  [type] $year        [description]
     * @param  [type] $month       [description]
     * @return [type]              [description]
     */
    public function cGrantLog($year, $month, $record_user, $store_code, $employee_code = '')
    {
        $grant_log = array(); //设置初始值
        $update_code = $this->cGetUpdateCodeBySearch($year, $month);
        if($update_code == '0'){
            return $grant_log = array();
        }
        if($employee_code != ''){
            $get_employee = employee_ins()->where('status', 1)->where('code', $employee_code)->with('employee_position')->get();
        }else{
            $get_employee = employee_ins()->where('status', 1)->with('employee_position')->get();
        }
        foreach ($get_employee as $key => $value) {
            if($value->employee_position->store_code == $store_code){
                /*先初始化数据*/
                $bonus = 0;
                $dividend = 0;
                /*员工基本工资*/
                $get_employee_salary = salary_details_ins()->where('update_code', $update_code)->where('employee_code', $value->code)->first();
                if(!$get_employee_salary){
                    $get_employee_salary = 0;
                }
                /*销售提成或者分红*/
                $get_bonus_or_dividend = bonus_details_new()->where('update_code', $update_code)->where('employee_code', $value->code)->with('employee_position')->get();
                /*tranfer*/
                $get_transfer_record = transfer_ins()
                    ->where('status_del', 0)
                    ->where('employee_code', $value->code)
                    ->where('year', $year)
                    ->where('month', $month)
                    ->sum('amount');
                /*获取员工基本信息*/
                if(substr($store_code, 0, 4) == 'qy00'){
                    $get_employee_position = employee_position()->where('employee_code', $value->code)->with('employee', 'zone', 'position')->first();
                } else {
                    $get_employee_position = employee_position()->where('employee_code', $value->code)->with('employee', 'store', 'position')->first();
                }
                if(count($get_bonus_or_dividend) > 0){
                    foreach ($get_bonus_or_dividend as $key_1 => $value_1) {
                        /*bonus_rule_key equal 1 means sell bonus*/
                        if($value_1->bonus_rule_key == 1){
                            $bonus += $value_1->bonus_amount;
                        }
                        /*bonus_rule_key equal 2 means dz or zl or qy get bouns*/
                        if(substr($store_code, 0, 4) == 'qy00'){
                            if($value_1->bonus_rule_key == 4){
                                $dividend += $value_1->bonus_amount;
                            }
                        } elseif ($store_code == 'hj001') {
                            if($value_1->bonus_rule_key == 5){
                                $dividend += $value_1->bonus_amount;
                            }
                        } else {
                            if($value_1->employee_position->position_code = 'dz01') {
                                if($value_1->bonus_rule_key == 3){
                                    $dividend += $value_1->bonus_amount;
                                }
                            } else {
                                if($value_1->bonus_rule_key == 2){
                                    $dividend += $value_1->bonus_amount;
                                }
                            }
                        }

                    }
                }
                /*实际发放工资*/
                $real_salary = grant_log_ins()->where('employee_code', $value->code)->where('year', $year)->where('month', $month)->sum('amount');
                if(!$real_salary){
                    $real_salary = 0;
                }
                /*reduce money*/
                $reduce_salary = salary_reduce_ins()->where('employee_code', $value->code)->where('year', $year)->where('status', 1)->where('month',$month)->sum('amount');
                $reduce_salary = round($reduce_salary, 2);
                $reduce_salary_details = salary_reduce_ins()->where('employee_code', $value->code)->where('year', $year)->where('month',$month)->get();
                if(!$reduce_salary_details){
                    $reduce_salary = 0;
                    $reduce_salary_details = array();
                }

                /*录入*/
                $grant_log[$key]['employee_code'] = $value->code;
                $grant_log[$key]['employee_name'] = $value->name;
                $grant_log[$key]['store_code'] = $get_employee_position->store_code;
                if(substr($store_code, 0, 4) == 'qy00'){
                    $grant_log[$key]['store_name'] = $get_employee_position->zone->name;
                } else {
                    $grant_log[$key]['store_name'] = $get_employee_position->store->name;
                }

                $grant_log[$key]['position_code'] = $get_employee_position->position->code;
                $grant_log[$key]['position_name'] = $get_employee_position->position->name;
                $grant_log[$key]['position_tag'] = $get_employee_position->position->position_tag;
                $grant_log[$key]['created_at'] = date("Y-m-d H:i:s");
                $grant_log[$key]['year'] = $year;
                $grant_log[$key]['month'] = $month;
                $grant_log[$key]['record_user'] = $record_user;
                $grant_log[$key]['update_code'] = $update_code;
                $grant_log[$key]['reduce_salary'] = $reduce_salary;
                $grant_log[$key]['reduce_salary_details'] = $reduce_salary_details;
                if(isset($get_employee_salary->salary_amount)){
                    $grant_log[$key]['salary'] = $get_employee_salary->salary_amount;
                }else{
                    $grant_log[$key]['salary'] = 0;
                }
                $sum = $grant_log[$key]['salary'] + $bonus + $dividend + $get_transfer_record - $reduce_salary; //all_aount
                $sum = round($sum, 2);
                $grant_log[$key]['bonus'] = $bonus;
                $grant_log[$key]['dividend'] = $dividend;
                $grant_log[$key]['transfer'] = $get_transfer_record;
                $grant_log[$key]['amount'] = $sum;
                $grant_log[$key]['real_salary'] = $real_salary;
            }

        }
        return $grant_log;

    }

     /**
     * [storeTrans 给店铺赋予中文属性]
     * @param  [type] $store [二维对象]
     * @return [type]        [description]
     */
    public function storeTrans($store){
        foreach ($store as $key => $value) {
            if($value->city_zone){
                $city = city_new()->where('zone',$value->city_zone)->first();
                $store[$key]->city_name = $city->name;
            }
            if($value->company_code){
                $company = company_new()->where('code',$value->company_code)->first();
                $store[$key]->company_name = $company->name;
            }
            if($value->parent_code){
                $store[$key]->parent_name = $value->parent_store->name;
            }else{
                $store[$key]->parent_name = "";
            }
            $store[$key]->type_name = ($value->type == 1)?'总店':'分店';
        }
        $store->company = company_new()->where('status',1)->get();
        $store->city = city_new()->get();
        return $store;
    }
    /**
     * [cGetZoneStore 获取区域下面的店铺]
     * @param  [type] $zone_code [description]
     * @return [type]            [description]
     */
    public function cGetZoneStore($zone_code)
    {
        $stores = store_new()->where('zone_code', $zone_code)->where('status', 1)->get();
        return $stores;
    }

    /**
     * [cDistSeason 获取当前season的月份]
     * @return [type] [description]
     */
    public function cDistSeason()
    {
        $month = (int)date('m');
        switch ($month) {
            case '1':
            case '2':
            case '3':
                return [1, 2, 3];
                break;
            case '4':
            case '5':
            case '6':
                return [4, 5, 6];
                break;
            case '7':
            case '8':
            case '9':
                return [7, 8, 9];
                break;
            default:
                return [10, 11, 12];
                break;
        }
    }


    /**
     * [cGetSeasonUpdateCode 获取当前season的update_code]
     * @param  [type] $season [description]
     * @return [type]         [description]
     */
    public function cGetSeasonUpdateCode()
    {   
        $season = $this->cDistSeason(); /*获取所属季度*/
        $year = date('Y');
        $set_update_code = array();
        foreach ($season as $key => $value) {
            $update_code = $this->cGetUpdateCodeBySearch($year, $value);
            if($update_code != '0'){
                $set_update_code[$key] = $update_code;
            }
        }
        return $set_update_code;
    }



    /**
     * [cUpdateCodeBySearchSeason 获取选择季度的月份]
     * @return [type] [description]
     */
    protected function cSeasonReturnMonth($season)
    {
        switch ($season) {
            case '1':
                return [1, 2, 3];
                break;
            case '2':
                return [4, 5, 6];
                break;
            case '3':
                return [7, 8, 9];
                break;
            default:
                return [10, 11, 12];
                break;
        }
    }
    /**
     * [cUpdateCodeBySearchSeason 获取所季度的update_code]
     * @param  [type] $season [description]
     * @return [type]         [description]
     */
    public function cUpdateCodeBySearchSeason($season)
    {
        $get_month = $this->cSeasonReturnMonth($season);
        $year = date('Y');
        $set_update_code = array();
        foreach ($get_month as $key => $value) {
            $update_code = $this->cGetUpdateCodeBySearch($year, $value);
            if($update_code != '0'){
                $set_update_code[$key] = $update_code;
            }
        }
        return $set_update_code;

    }

    /**
     * [cTrimZero 去月份0]
     * @param  [type] $mont [description]
     * @return [type]       [description]
     */
    public function cTrimZero(){
        $month = date('m');
        $month_0 = substr($month, 0, 1);
        if($month_0 == '0')
            return substr($month, 1, 1);
        else
            return $month;
    }



    /**
     * [cCostTrans 给成本赋予中文属性]
     * @param  [type] $cost [description]
     * @return [type]       [description]
     */
    public function cPortTrans($posts){
        foreach ($posts as $key => $value) {
            $pay_month = '<tr class="detailTr">';
            $pay_stores = '<tr class="detailTr">';
            $pay_month_arr = json_decode($value->pay_month);

            foreach ($pay_month_arr as $key1 => $value1) {
                if($key1 % 4 == 0 && $key1 != 0)
                    $pay_month .= '</tr><tr class="detailTr">';
                $pay_month .='<td>'.$value1->year.'年'.$value1->month.'月</td>';
            }
            $pay_month .= '</tr>';
           
            $posts[$key]->pay_month = $pay_month;
        }
        return $posts;
    }

    /**
     * 关键词设置
     */
    public function cUsingWords(){
        $words = rq('words');
        using_words_new()->where('type', 1)->where('status_del', 0)->update(['status_del' => 1]);
        foreach ($words as $key => $value) {
            $words_new = using_words_new();
            $words_new->value = $value;
            $words_new->type = rq("type");
            $words_new->save();
        }
        return suc('保存成功');
    }
}
