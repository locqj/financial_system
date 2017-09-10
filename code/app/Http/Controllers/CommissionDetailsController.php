<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CommissionDetailsController extends Controller
{   
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $store = store_new()->where('code',session('store_code'))->select('name','code')->get();
            $store_rand = store_new()->where('code',session('store_code'))->first();
        }else{
            $store = store_new()->where('type', 2)->select('name','code')->get();
            $store_rand = store_new()->where('type', 2)->first();
        }
        if(!$store_rand){
            $store_rand = (object)null;
            $store_rand->code = 'null';
            $store_rand->name = '';
        }
        $year = date('Y');
        $month = $this->cTrimZero();
        $years = commission_details_new()->groupBy('year')->select('year')->get();
        $commission_details = commission_details_new()->where('update_code',$this->cGetUpdateCode($year, $month))->where('store_code',$store_rand->code)->where('year',$year)->where('month',$month)->with('store','employee')->paginate(10);
        $search_employee = $this->cGetSaleEmployee($store_rand->code);
        $employee_code = '';
        return view('details.commission_details',compact('commission_details','year','years','month','store_rand','store', 'search_employee', 'employee_code'));
    }

    /**
     * [cGetContractDetail 获取佣金细节]
     * @return [type] [description]
     */
    public function cGetContractDetail(){
        $type = rq('type');
        $employee_code = rq('employee_code');
        $year = rq('year');
        $month = rq('month');
        $contract_return = array();
         //取出二手房和租房的提供房源的分成比例
        $second_rule = bonus_rule_ins()->where('rule_key', 8)->where('status_del', 0)->first();
        $rent_rule = bonus_rule_ins()->where('rule_key', 9)->where('status_del', 0)->first();
        switch ($type) {
            case 'amount':
                $contract_return = contract_ins()->where('employee_code', $employee_code)->where('year', $year)->where('month', $month)->where('type', 1)->where('is_signed', 1)->where('status_del','0')->with('store')->get();
                foreach ($contract_return as $key => $value) {
                    $contract_return[$key]->owner_store_name = $value->store->name; //所属店铺名称
                    $contract_return[$key]->is_source = '否';
                }
                break;
            case 'second':
                $contract = contract_ins()->where('employee_code', $employee_code)->where('year', $year)->where('month', $month)->where('type', 2)->where('is_signed', 1)->where('status_del','0')->with('store')->get();
                foreach ($contract as $key => $value) {
                    $contract_return[$key] = (object)null;
                    $contract_return[$key]->number = $value->number;
                    $contract_return[$key]->created_at = $value->created_at;
                    $contract_return[$key]->owner_store_name = $value->store->name;
                    if($value->is_divide){
                        $contract_return[$key]->real_amount = round($value->real_amount * $second_rule->percentage, 2);
                        $contract_return[$key]->employee_role = '业务员';
                        $contract_return[$key]->is_source = '是';
                    }else{
                        $contract_return[$key]->real_amount = $value->real_amount;
                        $contract_return[$key]->is_source = '否';
                        $contract_return[$key]->employee_role = '业务员+房源提供者';
                    }
                    $contract_return[$key]->signed_amount = $value->real_amount;

                }
                if($contract_return)
                    $key++;
                else
                    $key = 0;
                //提供房源给别人
                $contract = contract_ins()->where('source_employee', $employee_code)->where('year', $year)->where('month', $month)->where('type', 2)->where('is_signed', 1)->where('status_del','0')->with('store')->get();
                foreach ($contract as $key_source => $value_source) {
                    $contract_return[$key] = (object)null;
                    $contract_return[$key]->number = $value_source->number;
                    $contract_return[$key]->created_at = $value_source->created_at;
                    $contract_return[$key]->owner_store_name = $value_source->store->name;
                    $contract_return[$key]->employee_role = '房源提供者';
                    $contract_return[$key]->is_source = '是';//是否提供房源
                    $contract_return[$key]->signed_amount = $value_source->real_amount;
                    $contract_return[$key++]->real_amount = round($value_source->real_amount * (1 - $second_rule->percentage), 2);
                }
                break;
            case 'rent':
                $contract = contract_ins()->where('employee_code', $employee_code)->where('year', $year)->where('month', $month)->where('type', 3)->where('is_signed', 1)->where('status_del','0')->with('store')->get();
                foreach ($contract as $key => $value) {
                    $contract_return[$key] = (object)null;
                    $contract_return[$key]->number = $value->number;
                    $contract_return[$key]->created_at = $value->created_at;
                    $contract_return[$key]->owner_store_name = $value->store->name;
                    if($value->is_divide){
                        $contract_return[$key]->real_amount = round($value->real_amount * $rent_rule->percentage, 2);
                        $contract_return[$key]->employee_role = '业务员';
                        $contract_return[$key]->is_source = '是';
                    }else{
                        $contract_return[$key]->employee_role = '业务员+房源提供者';
                        $contract_return[$key]->real_amount = $value->real_amount;
                        $contract_return[$key]->is_source = '否';
                    }
                     $contract_return[$key]->signed_amount = $value->real_amount;
                }
                if($contract_return)
                    $key++;
                else
                    $key = 0;
                //提供房源给别人
                $contract = contract_ins()->where('source_employee', $employee_code)->where('year', $year)->where('month', $month)->where('type', 3)->where('is_signed', 1)->where('status_del','0')->with('store')->get();
                foreach ($contract as $key_source => $value_source) {
                    $contract_return[$key] = (object)null;
                    $contract_return[$key]->number = $value_source->number;
                    $contract_return[$key]->created_at = $value_source->created_at;
                    $contract_return[$key]->owner_store_name = $value_source->store->name;
                    $contract_return[$key]->employee_role = '房源提供者';
                    $contract_return[$key]->is_source = '是';
                    $contract_return[$key]->signed_amount = $value_source->real_amount;
                    $contract_return[$key++]->real_amount = round($value_source->real_amount * (1 - $rent_rule->percentage), 2);
                }
                break;
            default:
                # code...
                break;
        }
        if($contract_return)
            return suc($contract_return);
        else
            return err('查询失败');
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
