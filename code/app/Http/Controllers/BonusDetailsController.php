<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BonusDetails;
use App\Http\Requests;

date_default_timezone_set('Asia/Shanghai');

class BonusDetailsController extends Controller
{

    public function searchBonus($year, $month)
    {
         if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $store = store_new()->where('code',session('store_code'))->select('name','code')->get();
            $store_rand = store_new()->where('code',session('store_code'))->with('employee')->first();
        }else{
            $store = store_new()->select('name','code')->get();
            // $store_rand = store_new()->with('employee')->first();
            $store_rand = 'all';
        }
        $bonus = BonusDetails::where('update_code', $this->cGetUpdateCode($year, $month))
            ->select('employee_code')->get();
        $bonus = array_column($bonus->toArray(), 'employee_code');
        if($store_rand == 'all')
        {
            //dd($bonus);
            $bonus_employee = employee_position()->whereIn('employee_code', $bonus)->paginate(30);
            foreach ($bonus_employee as $key => $value) {
                $arr = $value->bonus_details->toArray();
                $value->store_code = $arr[count($arr)-1]['store_code'];
            }
            
        }
        else
        {
            $bonus_employee = employee_position()->whereIn('employee_code', $bonus)->get();
            foreach ($bonus_employee as $key => $value) {
                $arr = $value->bonus_details->toArray();
                $value->store_code = $arr[count($arr)-1]['store_code'];
            }
            $bonus_employee = $bonus_employee->where('store_code', $store_rand->code);
        }
        //dd($bonus_employee);
        foreach ($bonus_employee as $key => $value) {
            if($value->employee->status == 0){
                unset($bonus_employee[$key]);
                continue;
            }else{
                $sum = array();
                $sale = $value->bonus_details()->where('update_code',$this->cGetUpdateCode($year, $month))->where('year',$year)->where('month',$month)->where('bonus_rule_key',1)->sum('bonus_amount');
                $bonus = $value->bonus_details()->where('update_code',$this->cGetUpdateCode($year, $month))->where('year',$year)->where('month',$month)->where('bonus_rule_key','<>',1)->sum('bonus_amount');
                $all = $sale + $bonus;
                
                    $sum[0]['sale'] = round($sale, 2);
                    $sum[0]['bonus'] = round($bonus, 2);
                    $sum[0]['all'] = round($all, 2);
                    $sum[0]['month'] = $month;
                    $sum[0]['year'] = $year;
                
                $bonus_employee[$key]->bonusAndSale = $sum;
            }
        }
        $employee_code = '';
        if($store_rand == 'all')
        {
            $search_employee = [];
        }
        else
        {
            $search_employee = $this->cGetAllEmployee($store_rand->code);
        }
        
        $years = bonus_details_new()->groupBy('year')->select('year')->get();
        //dd($bonus_employee);
        return view('details.bonus_details',compact('bonus_employee','year','years','month','store_rand','store', 'employee_code', 'search_employee'));
    }   
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $store = store_new()->where('code',session('store_code'))->select('name','code')->get();
            $store_rand = store_new()->where('code',session('store_code'))->with('employee')->first();
        }else{
            $store = store_new()->select('name','code')->get();
            // $store_rand = store_new()->with('employee')->first();
            $store_rand = 'all';
        }
        $year = date('Y');
        $month = $this->cTrimZero();
        $bonus = BonusDetails::where('update_code', $this->cGetUpdateCode($year, $month))
            ->select('employee_code')->get();
        $bonus = array_column($bonus->toArray(), 'employee_code');
        if($store_rand == 'all')
        {
            $bonus_employee = employee_position()->whereIn('employee_code', $bonus)->paginate(10);

            //dd($bonus_employee);
            foreach ($bonus_employee as $key => $value) {
                $arr = $value->bonus_details->toArray();
                $value->store_code = $arr[count($arr)-1]['store_code'];
            }
        }
        else
        {
            $bonus_employee = employee_position()->whereIn('employee_code', $bonus)->get();
            //dd($bonus_employee);
            foreach ($bonus_employee as $key => $value) {
                $arr = $value->bonus_details->toArray();
                $value->store_code = $arr[count($arr)-1]['store_code'];
            }
            $bonus_employee = $bonus_employee->where('store_code', $store_rand->code);
            //dd($bonus_employee);
        }
        //$bonus_employee->toArray();
        //dd($bonus_employee);
        foreach ($bonus_employee as $key => $value) {
            if($value->employee->status == 0){
                unset($bonus_employee[$key]);
                continue;
            }else{
                $sum = array();
                $sale = $value->bonus_details()->where('update_code',$this->cGetUpdateCode($year, $month))->where('year',$year)->where('month',$month)->where('bonus_rule_key',1)->sum('bonus_amount');
                $bonus = $value->bonus_details()->where('update_code',$this->cGetUpdateCode($year, $month))->where('year',$year)->where('month',$month)->where('bonus_rule_key','<>',1)->sum('bonus_amount');
                $all = $sale + $bonus;
                
                    $sum[0]['sale'] = round($sale, 2);
                    $sum[0]['bonus'] = round($bonus, 2);
                    $sum[0]['all'] = round($all, 2);
                    $sum[0]['month'] = $month;
                    $sum[0]['year'] = $year;
                
                $bonus_employee[$key]->bonusAndSale = $sum;
            }
        }
        $employee_code = '';
        if($store_rand == 'all')
        {
            $search_employee = [];
        }
        else
        {
            $search_employee = $this->cGetAllEmployee($store_rand->code);
        }
        
        $years = bonus_details_new()->groupBy('year')->select('year')->get();

        return view('details.bonus_details',compact('bonus_employee','year','years','month','store_rand','store', 'employee_code', 'search_employee', 'sum'));
    }

    public function cGetBonusDetail(){
        $employee_code = rq('employee_code');
        $year = rq('year');
        $month = rq('month');
        $bonus_details = bonus_details_new()->where('update_code',$this->cGetUpdateCode($year, $month))->where('employee_code',$employee_code)->where('year', $year)->where('month', $month)->where('bonus_rule_key', '<>', 1)->with('cstore')->get();
        foreach ($bonus_details as $key => $value) {
            $bonus_details[$key]->store_name = "";
            switch ($value->bonus_rule_key) {
                case '2':
                    $bonus_type = '销售助理分红';
                    break;
                case '3':
                    $bonus_type = '店长分红';
                    break;
                case '4':
                    $bonus_type = '区域经理分红';
                    $bonus_details[$key]->cstore_name = $value->cstore->name;
                    break;
                case '5':
                    $bonus_type = '总经理分红';
                    $bonus_details[$key]->cstore_name = $value->cstore->name;
                    break;
                case '6':
                    $bonus_type = '二级店铺分红';
                    $bonus_details[$key]->cstore_name = $value->cstore->name;
                    break;
                default:
                    # code...
                    break;
            }
            $bonus_details[$key]->bonus_type = $bonus_type;
        }
        return suc($bonus_details);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
