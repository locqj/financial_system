<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BonusDetails;
use App\Http\Requests;

class KeyFindController extends Controller
{   

    /**
     * [cKeyFind 月份搜索]
     * @param  [type] $key        [description]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    public function cKeyFind($key, $store_code, $year, $month, $employee_code = ''){

    	switch ($key) {
    		case 'commission_details':
    			return $this->cCommissionDetails($store_code, $year, $month, $employee_code);
    			break;
    		case 'bonus_details':
    			return $this->cBonusDetails($store_code, $year, $month, $employee_code);
    			break;
            case 'commission_details_personal':
                return $this->cCommissionDetailsPersonal($store_code, $year, $month);  //这里的store_code由于路由原因其实是employee_code
                break;
    		default:
    			# code...
    			break;
    	}
    }

    public function cKeyFindSeason($key, $store_code, $year, $season){
        switch ($key){
            case 'commission_details':
                return $this->cCommissionDetailsSeason($store_code, $year, $season);
                break;
            case 'bonus_details':
                return $this->cBonusDetailsSeason($store_code, $year, $season);
                break;
            default:
                # code...
                break;
        }
    }

    /**
     * [cCommissionDetails 佣金搜索]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cCommissionDetails($store_code, $year, $month, $employee_code){
        if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $store = store_new()->where('code',session('store_code'))->select('name','code')->get();
        }else{
            $store = store_new()->where('type',2)->select('name','code')->get();
        }
    	$store_rand = store_new()->where('code',$store_code)->first();
        if(!$store_rand){
            $store_rand = (object)null;
            $store_rand->code = 'null';
            $store_rand->name = '';
        }
        if($employee_code == 'all'){
            $commission_details = commission_details_new()->where('update_code',$this->cGetUpdateCode($year, $month))->where('store_code',$store_code)->where('year',$year)->where('month',$month)->with('store','employee')->paginate(10);
        }else{
            $commission_details = commission_details_new()->where('update_code',$this->cGetUpdateCode($year, $month))->where('store_code',$store_code)->where('year',$year)->where('month',$month)->where('employee_code', $employee_code)->with('store','employee')->paginate(10);
        }
        $search_employee = $this->cGetSaleEmployee($store_code);
        $years = commission_details_new()->groupBy('year')->select('year')->get();
        return view('details.commission_details',compact('commission_details','year','years','month','store_rand','store', 'search_employee', 'employee_code'));
    }

    /**
     * [cCommissionDetails 佣金搜索按季度]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cCommissionDetailsSeason($store_code, $year, $season){
        if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $store = store_new()->where('code',session('store_code'))->select('name','code')->get();
        }else{
            $store = store_new()->where('type',2)->select('name','code')->get();
        }
        $store_rand = store_new()->where('code',$store_code)->first();
        if(!$store_rand){
            $store_rand = (object)null;
            $store_rand->code = 'null';
            $store_rand->name = '';
        }
        $season_updatecode = $this->cUpdateCodeBySearchSeason($season);
        $month = date('m');
        $commission_details = commission_details_new()->whereIn('update_code',$season_updatecode)->where('store_code',$store_code)->with('store','employee')->paginate(10);
        $years = commission_details_new()->groupBy('year')->select('year')->get();
        return view('details.commission_details',compact('commission_details','year','years','month','store_rand','store','season'));
    }

    /**
     * [cBonusDetails 分红提成]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cBonusDetails($store_code, $year, $month, $employee_code){
        if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $store = store_new()->where('code',session('store_code'))->select('name','code')->get();
        }else{
           $store = store_new()->select('name','code')->get();
        }
        $store_rand = store_new()->where('code',$store_code)->first();
        //最新
        $bonus = BonusDetails::where('update_code', $this->cGetUpdateCode($year, $month))
            ->select('employee_code')->get();
        $bonus = array_column($bonus->toArray(), 'employee_code');

        if($employee_code == 'all'){
            // $bonus_employee = employee_position()->where('store_code',$store_rand->code)->with('employee','bonus_details','store','position')->paginate(10);
            $bonus_employee = employee_position()->whereIn('employee_code', $bonus)->get();
            foreach ($bonus_employee as $key => $value) {
                $arr = $value->bonus_details->toArray();
                $value->store_code = $arr[count($arr)-1]['store_code'];
            }
            $bonus_employee = $bonus_employee->where('store_code', $store_rand->code);
        }else{
            // $bonus_employee = employee_position()->where('store_code',$store_rand->code)->where('employee_code', $employee_code)->with('employee','bonus_details','store','position')->paginate(10);
            $bonus_employee = employee_position()->whereIn('employee_code', $bonus)->get();
            foreach ($bonus_employee as $key => $value) {
                $arr = $value->bonus_details->toArray();
                $value->store_code = $arr[count($arr)-1]['store_code'];
            }
            $bonus_employee = $bonus_employee->where('store_code',$store_rand->code)
            ->where('employee_code', $employee_code);        
        }
        foreach ($bonus_employee as $key => $value) {
            if($value->employee->status == 0){
                unset($bonus_employee[$key]);
                continue;
            }else{
                $sum = array();
                $sale = $value->bonus_details()->where('update_code',$this->cGetUpdateCode($year, $month))->where('year',$year)->where('month',$month)->where('bonus_rule_key',1)->sum('bonus_amount');
                $bonus = $value->bonus_details()->where('update_code',$this->cGetUpdateCode($year, $month))->where('year',$year)->where('month',$month)->where('bonus_rule_key','<>',1)->sum('bonus_amount');
                $all = $sale + $bonus;
                // if($all != 0){
                    $sum[0]['sale'] = round($sale, 2);
                    $sum[0]['bonus'] = round($bonus, 2);
                    $sum[0]['all'] = round($all, 2);
                    $sum[0]['month'] = $month;
                    $sum[0]['year'] = $year;
                // }
                $bonus_employee[$key]->bonusAndSale = $sum;            }
        }
        $search_employee = $this->cGetAllEmployee($store_rand->code);
        $years = bonus_details_new()->groupBy('year')->select('year')->get();
        return view('details.bonus_details',compact('bonus_employee','year','years','month','store_rand','store', 'search_employee', 'employee_code'));
    }

    /**
     * [cBonusDetailsSeason 分红搜索按季度]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $season     [description]
     * @return [type]             [description]
     */
    protected function cBonusDetailsSeason($store_code, $year, $season){
         if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $store = store_new()->where('code',session('store_code'))->select('name','code')->get();
        }else{
           $store = store_new()->select('name','code')->get();
        }
        $store_rand = store_new()->where('code',$store_code)->first();
        $months = $this->cSeasonReturnMonth($season);
        $bonus_employee = employee_position()->where('store_code',$store_rand->code)->with('employee','bonus_details','store','position')->paginate(10);
        $month = $this->cTrimZero();
            foreach ($bonus_employee as $key => $value) {
                if($value->employee->status == 0){
                    unset($bonus_employee[$key]);
                    continue;
                }else{
                    $sum = array();
                    foreach ($months as $key_month => $value_month) {
                        $sale= $value->bonus_details()->where('update_code',$this->cGetUpdateCode($year, $value_month))->where('bonus_rule_key',1)->sum('bonus_amount');

                        $bonus = $value->bonus_details()->where('update_code',$this->cGetUpdateCode($year, $value_month))->where('bonus_rule_key','<>',1)->sum('bonus_amount');
                        $all = $sale + $bonus;
                        if($all != 0){
                            $sum[$value_month]['sale'] = round($sale, 2);
                            $sum[$value_month]['bonus'] = round($bonus, 2);
                            $sum[$value_month]['all'] = round($all, 2);
                            $sum[$value_month]['month'] = $value_month;
                            $sum[$value_month]['year'] = $year;
                        }
                    }
                }
                $bonus_employee[$key]->bonusAndSale = $sum;
            }
        $years = bonus_details_new()->groupBy('year')->select('year')->get();
        return view('details.bonus_details',compact('bonus_employee','year','years','month','store_rand','store','season'));
    }

    /**
     * [cCommissionDetailsPersonal 个人佣金查询]
     * @param  [type] $employee_code [description]
     * @param  [type] $year          [description]
     * @param  [type] $month         [description]
     * @return [type]                [description]
     */
    protected function cCommissionDetailsPersonal($store_code, $year, $month){//这里的store_code由于路由原因其实是employee_code
        $employee_code = $store_code;           //这里的store_code由于路由原因其实是employee_code
        $employee_position = employee_position()->where('employee_code', $employee_code)->first();
         if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $store = store_new()->where('code',session('store_code'))->select('name','code')->get();
        }else{
           $store = store_new()->where('type',2)->select('name','code')->get();
        }
        $store_rand = store_new()->where('code', $employee_position->store_code)->first();
        $commission_details = commission_details_new()->where('update_code',$this->cGetUpdateCode($year, $month))->where('employee_code',$employee_code)->where('year',$year)->where('month',$month)->with('store','employee')->paginate(10);
        $years = commission_details_new()->groupBy('year')->select('year')->get();
        $search_employee = $this->cGetSaleEmployee($store_code);
        return view('details.commission_details',compact('commission_details','year','years','month','store_rand','store', 'employee_code', 'search_employee'));
    }
}
