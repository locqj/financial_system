<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Session;

class IndexController extends Controller
{   
    
    public function index(){
        $store_code = Session::get('store_code');
        // 店长或助理限制只能看自己本店信息
        if(Session::get('level_code') == 'dz' || Session::get('level_code') == 'zl'){
            $store = store_new()->where('status_del', 0)->where('code', $store_code)->get(); 
        }else{
            $store = store_new()->where('status_del', 0)->get(); 
        }

    	$years = cost_details_ins()->groupBy('year')->select('year')->get();
        $year = date('Y');
        $month = date('m');
        $best_seller = $this->cGetBestSeller();
        $best_store = $this->cGetBestStore();
        $note = DB::table('work_note')->where('status', 1)->limit(8)->get();
    	return view('index.index', compact('store_code', 'store', 'years', 'year', 'month', 'best_store', 'best_seller', 'note'));
    }

    /*2个饼状图*/
    public function getCalculateStore($store_code, $year, $month)
    {   
        $update_code = $this->cGetUpdateCodeBySearch($year, $month);
        $calculate_store = calculate_store_new()
            ->where('update_code', $update_code)
            ->where('store_code', $store_code)->first();
        if($calculate_store){
            $cost_details = cost_details_ins()->where('update_code', $update_code)
            ->where('store_code', $store_code)->get();
            if(count($cost_details) > 0){
                $amount_ths = 0;
                for($i = 0; $i < count($cost_details) ; $i++){
                    if($i != count($cost_details)){
                        $cost[$i]['name'] = $cost_details[$i]['category'];
                        $cost[$i]['value'] = round($cost_details[$i]['amount'], 2);
                        $amount_ths += $cost[$i]['value'];
                        $cost[$i]['color'] = '#'.rand(10,99).rand(10,99).rand(10,99);
                    }
                }
                $get_store_salary = salary_details_ins()
                            ->where('store_code', $store_code)
                            ->where('update_code', $update_code)
                            ->sum('salary_amount');
                $get_salary_amount['name'] = '本店员工工资';
                $get_salary_amount['value'] = round($get_store_salary, 2);
                $get_salary_amount['color'] = '#454559';
                /*将数组推入到cost*/
                $cost[] = $get_salary_amount;
                $get_bonus_details = bonus_details_new()
                    ->where('store_code', $store_code)
                    ->where('is_cost', 1)
                    ->where('update_code', $update_code)
                    ->sum('bonus_amount');
                $bonus_details_amount['name'] = '员工提成';
                $bonus_details_amount['value'] = round($get_bonus_details, 2);
                $bonus_details_amount['color'] = '#45ada6';
                /*将数组推入到cost*/
                $cost[] = $bonus_details_amount;
                $amount_all = $amount_ths + $get_store_salary + $get_bonus_details;
                //$calculate_store->amount_ths = round($amount_all, 2);
                $calculate_store->bouns_count = $calculate_store->income;
                $calculate_store->cost = $cost;
                return $calculate_store;
            }else{
                return err('暂无数据');
            }

        }else{
            if($store_code == 'hj001'){
                 /*总店显示数据*/
                //$calculate_store->cost = null;
                $get_fendian = store_new()->where('parent_code', 'hj001')->select('code')->get();
                $outcome = 0;
                $profit = 0;
                $calculate = array();
                foreach ($get_fendian as $key => $value) {
                    $calculate = calculate_store_new()->where('update_code', $update_code)
                        ->where('store_code', $value->code)->first();
                    if($calculate){
                        $outcome += $calculate->outcome;
                        $profit += $calculate->profit;
                    }
                }
                if($calculate){
                    $calculate->outcome = $outcome;
                    $calculate->profit = $profit;
                    return $calculate;
                }else{
                    return err('暂无数据');    
                }
                //$calculate->count = $this->cChartYearIncomeData($store_code);
            }else{
                return err('暂无数据');
            }
            
        }

    }
    /*收入，利润总走势图*/
    public function cChartYearIncomeData($store_code)
    {
        $get_update_code = DB::table('calculate_log')->where('is_last',1)->take(12)->orderby('month', 'asc')->get();
        $cost = array();
        foreach ($get_update_code as $key => $value) {
            if($store_code != 'hj001'){
                /*分店的*/
                $calculate_store = calculate_store_new()
                ->where('update_code', $value->update_code)
                ->where('store_code', $store_code)->first();
                if($calculate_store){
                    $cost['income'][$key] = $calculate_store->income;
                    $cost['profit'][$key] = $calculate_store->profit;
                    $cost['index_list'][$key] = $calculate_store->year.'/'.$calculate_store->month;
                }
            }else{
                $get_fendian = store_new()->where('type', '2')->select('code')->get();
                $income = 0;
                $profit = 0;
                foreach ($get_fendian as $key_1 => $value_1) {
                    $calculate = calculate_store_new()->where('update_code', $value->update_code)
                        ->where('store_code', $value_1->code)->first();
                    if($calculate){
                        $income += $calculate->income;
                        $profit += $calculate->profit;    
                    }else{
                        $income += 0;
                        $profit += 0;
                    }
                    
                }
                
                $cost['income'][$key] = round($income, 2);
                $cost['profit'][$key] = round($profit, 2);
                $cost['index_list'][$key] = $value->year.'/'.$value->month;
                
            }
        }
        return $cost;
    }
    /**
     * [cGetBestStore 最佳店铺前8]
     * @return [type] [description]
     */
    public function cGetBestStore()
    {
        $get_season_update_code = $this->cGetSeasonUpdateCode();
        $get_best_income = array();
        $store = store_new()->where('type', 2)->where('status_del', 0)->get();
        if($store) {
            foreach ($store as $key => $value) {
                $sum = 0;
                foreach ($get_season_update_code as $k => $v) {
                    $get_income = calculate_store_new()->where('update_code', $v)->where('store_code', $value->code)->first();
                    if($get_income) {
                        $sum += $get_income->income;
                    } else {
                        $sum += 0;
                        
                    }
                }
                
                $get_best_income[$key]['sum'] = round($sum, 2);
                $get_best_income[$key]['name'] = $value->name;
                $get_best_income[$key]['code'] = $value->code;
            }
            return $this->cSort($get_best_income);
        } else {
            return array();
        }

        
    }

    /**
     * [cGetBestSeller 最佳销售前8]
     * @return [type] [description]
     */
    protected function cGetBestSeller()
    {
        $get_season_update_code = $this->cGetSeasonUpdateCode();
        $get_best_commission = array();
        $employee_position = employee_position()->where('position_code', 'like', 'xs%')->orWhere('position_code', 'like', 'zl%')->with('employee', 'store')->get();
        if($employee_position){
            
            foreach ($employee_position as $key => $value) {
                if($value->employee->status == 1) {
                    $sum = 0;
                    foreach ($get_season_update_code as $k => $v) {
                        $get_commission = commission_details_new()->with('store', 'employee')
                            ->where('employee_code', $value->employee_code)
                            ->where('update_code', $v)->first();
                        if($get_commission) {
                            $sum += $get_commission->amount + $get_commission->second_amount + $get_commission->rent_amount;
                        } else {
                            $sum += 0;
                        }
                    }
                    $get_best_commission[$key]['sum'] = round($sum, 2);
                    $get_best_commission[$key]['name'] = $value->employee->name;
                    $get_best_commission[$key]['store_name'] = $value->store->name;
                    $get_best_commission[$key]['code'] = $value->employee_code;
                }
            }

            return $this->cSort($get_best_commission);
        }else{
            return array();
        }
    }



    /**
     * [cSort 二维数组排序]
     * @param  [type] $carray [description]
     * @return [type]         [description]
     */
    protected function cSort($carray)
    {   
        $sort = array(
            'direction' => 'SORT_DESC',
            'field'     => 'sum'
        );
        $arrSort = array();
        if($carray == null){
            return $carray;
        }
        foreach($carray as $uniqid => $row){
            foreach($row as $key=>$value){
                $arrSort[$key][$uniqid] = $value;
            }
        }

        if($sort['direction']){
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $carray);
        }
        return $carray;
    }


    /**
     * [cAddNote 添加备忘录]
     * @return [type] [description]
     */
    public function cAddNote()
    {   
        $date = date('Y-m-d h:i:s');
        $data = DB::table('work_note')->insert(['text' => rq('text'), 'date' => $date, 'status' => 1]);
        if($data) {
            return suc('ok');
        } else {
            return err('error');
        }
    }

    public function cDelNote($id)
    {   
        $data = DB::table('work_note')->where('id', $id)->update(['status' => 0]);
        if($data) {
            return suc('ok');
        } else {
            return err('error');
        }
    }

}
