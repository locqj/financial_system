<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Session;

date_default_timezone_set('Asia/Shanghai');

class StaffContractController extends Controller
{

    public function searchContract($year, $month, $end_month)
    {   
        // 店长或助理限制只能看自己本店信息
        if(in_array(Session::get('level_code'), ['xs', 'dz', 'zl'])){
            $store_code = Session::get('store_code');
            $store = store_new()->where('status_del', 0)->where('type', 2)->where('code', $store_code)->get(); 
        }else{
            $store = store_new()->where('status_del', 0)->where('type', 2)->get(); 
            $store_code = store_new()->where('status_del', 0)->where('type', 2)->first();
            if($store_code == null){
                $store_code = null;
            }else{
                $store_code = 'all';
            }
        }
        if(session('level_code') == 'xs'){
            $allContracts = contract_ins()
            ->where('status_del', 0)->where('employee_code', session('employee_code'))->where('year', $year)->where('month','>=', $month)->where('month', '<=', $end_month)->get();

             $contracts = contract_ins()
            ->where('status_del', 0)->where('employee_code', session('employee_code'))->where('year', $year)->where('month','>=', $month)->where('month', '<=', $end_month)
            ->with('employee')->with('store')->paginate(10);
        }else{
            if($store_code == 'all'){
                $allContracts = contract_ins()
                ->where('status_del', 0)->where('year', $year)->where('month','>=', $month)->where('month', '<=', $end_month)->with('employee')->with('store')->orderBy('store_code')->get();
                $contracts = contract_ins()
                ->where('status_del', 0)->where('year', $year)->where('month','>=', $month)->where('month', '<=', $end_month)->with('employee')->with('store')->orderBy('store_code')->paginate(10);
            }else{
                $allContracts = contract_ins()
                ->where('status_del', 0)->where('store_code', $store_code)->where('year', $year)->where('month','>=', $month)->where('month', '<=', $end_month)
                ->with('employee')->with('store')->get();
                $contracts = contract_ins()
                ->where('status_del', 0)->where('store_code', $store_code)->where('year', $year)->where('month','>=', $month)->where('month', '<=', $end_month)
                ->with('employee')->with('store')->paginate(10);
            }
            
        }

        $received_amount_all = 0;
        foreach ($allContracts as $key => $value) {
             $received_amount_all += $value->received_amount;
         } 
        foreach ($contracts as $key => $value) {
            
            if($value->type == 1) {
                $value->type_name = '一手';
            } else if ($value->type == 2) {
                $value->type_name = '二手';
            } else {
                $value->type_name = '租单';   
            }
        }
        if(in_array(session('level_code'), ['xs'])){
            $sign_employee = employee_position()
                ->where('employee_code', session('employee_code'))
                ->with('employee')->with('position')->get();
            }else{
                if($store_code == 'all'){
                    $sign_employee = employee_position()
                    ->whereIn('position_code', ['xs01', 'xs02', 'xs03', 'xs04', 'xs05', 'zl01', 'zl03', 'zl02'])
                    ->with('employee')->with('position')->get();
                }
            $sign_employee = employee_position()
                ->where('store_code', $store_code)
                ->whereIn('position_code', ['xs01', 'xs02', 'xs03', 'xs04', 'xs05', 'zl01', 'zl03', 'zl02'])
                ->with('employee')->with('position')->get();
        }
        foreach ($sign_employee as $key => $value) {
            $get_level = DB::table('staff_position_level')->where('position_code', $value->position_code)->first();
            if($get_level){
                $value->position_level = '销售'.$get_level->name;
            }else{
                $value->position_level = null;
            }
            if($value->employee->status == 0){
                unset($sign_employee[$key]);
            }
        }
        $get_tax = bonus_rule_ins()->where('rule_key', 7)->where('status_del', 0)->first();
        $get_tax = $get_tax->percentage * 100;
        /*获取房源店铺*/
        $store_list = store_new()->where('status_del', 0)->where('type', 2)->get();
        $years = contract_ins()->where('status_del', 0)->groupBy('year')->select('year')->get();
        $transferEmployee = employee_position()
            ->where('position_code', 'gh01')
            ->with('position')->with('employee')->get(); //查找过户专员
        $employee_code = '';
        return view('contract.contract', compact('contracts', 'store', 'sign_employee', 'years', 'year', 'month', 'end_month', 'store_code', 'store_list', 'get_tax','transferEmployee','employee_code', 'received_amount_all', 'allContracts'));
    }  
   
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // 店长或助理限制只能看自己本店信息
        if(in_array(Session::get('level_code'), ['xs', 'dz', 'zl'])){
            $store_code = Session::get('store_code');
            $store = store_new()->where('status_del', 0)->where('type', 2)->where('code', $store_code)->get(); 
        }else{
            $store = store_new()->where('status_del', 0)->where('type', 2)->get(); 
            $store_code = store_new()->where('status_del', 0)->where('type', 2)->first();
            if($store_code == null){
                $store_code = null;
            }else{
                $store_code = 'all';
            }
        }
        $year = date('Y');
        $month = date('m');
        if(session('level_code') == 'xs'){
            $allContracts = contract_ins()
            ->where('status_del', 0)->where('employee_code', session('employee_code'))->where('month', $month)->where('year', $year)->get();

             $contracts = contract_ins()
            ->where('status_del', 0)->where('employee_code', session('employee_code'))->where('month', $month)->where('year', $year)
            ->with('employee')->with('store')->paginate(10);
        }else{
            if($store_code == 'all'){
                $allContracts = contract_ins()
                ->where('status_del', 0)->where('month', $month)->where('year', $year)->with('employee')->with('store')->orderBy('store_code')->get();
                $contracts = contract_ins()
                ->where('status_del', 0)->where('month', $month)->where('year', $year)->with('employee')->with('store')->orderBy('store_code')->paginate(10);
            }else{
                $allContracts = contract_ins()
                ->where('status_del', 0)->where('store_code', $store_code)->where('month', $month)->where('year', $year)
                ->with('employee')->with('store')->get();
                $contracts = contract_ins()
                ->where('status_del', 0)->where('store_code', $store_code)->where('month', $month)->where('year', $year)
                ->with('employee')->with('store')->paginate(10);
            }
            
        }

        $received_amount_all = 0;
        foreach ($allContracts as $key => $value) {
             $received_amount_all += $value->received_amount;
         } 
        foreach ($contracts as $key => $value) {
            
            if($value->type == 1) {
                $value->type_name = '一手';
            } else if ($value->type == 2) {
                $value->type_name = '二手';
            } else {
                $value->type_name = '租单';   
            }
        }
        if(in_array(session('level_code'), ['xs'])){
            $sign_employee = employee_position()
                ->where('employee_code', session('employee_code'))
                ->with('employee')->with('position')->get();
            }else{
                if($store_code == 'all'){
                    $sign_employee = employee_position()
                    ->whereIn('position_code', ['xs01', 'xs02', 'xs03', 'xs04', 'xs05', 'zl01', 'zl03', 'zl02'])
                    ->with('employee')->with('position')->get();
                }
            $sign_employee = employee_position()
                ->where('store_code', $store_code)
                ->whereIn('position_code', ['xs01', 'xs02', 'xs03', 'xs04', 'xs05', 'zl01', 'zl03', 'zl02'])
                ->with('employee')->with('position')->get();
        }
        foreach ($sign_employee as $key => $value) {
            $get_level = DB::table('staff_position_level')->where('position_code', $value->position_code)->first();
            if($get_level){
                $value->position_level = '销售'.$get_level->name;
            }else{
                $value->position_level = null;
            }
            if($value->employee->status == 0){
                unset($sign_employee[$key]);
            }
        }
        $get_tax = bonus_rule_ins()->where('rule_key', 7)->where('status_del', 0)->first();
        $get_tax = $get_tax->percentage * 100;
        /*获取房源店铺*/
        $store_list = store_new()->where('status_del', 0)->where('type', 2)->get();
        $years = contract_ins()->where('status_del', 0)->groupBy('year')->select('year')->get();
        $transferEmployee = employee_position()
            ->where('position_code', 'gh01')
            ->with('position')->with('employee')->get(); //查找过户专员
        $employee_code = '';
        return view('contract.contract', compact('contracts', 'store', 'sign_employee', 'years', 'year', 'month', 'store_code', 'store_list', 'get_tax','transferEmployee','employee_code', 'received_amount_all', 'allContracts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(rq('store_code')){
            $store_name = store_new()
                ->where('status', 1)->where('code', rq('store_code'))->first();
            $employees = employee_position()
                ->where('store_code', rq('store_code'))
                ->with('employee')->with('position')->get();
            $status_blade = 1; //代表新增数据
            /*return $employees;*/
            return view('contract.new_contract', compact('store_name', 'employees', 'status_blade'));    
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //return $request->all();
        $contract = contract_ins();
        $exist_number = $contract->where('number', rq('number'))->where('status_del', 0)->exists();
        if($exist_number)
            return err('单号已存在');
        $contract->type = rq('sign_type'); //签单类型
        if(rq('sign_type') != 1){
            $contract->is_divide = rq('is_divide');
            if(rq('is_divide') == 1){
                $contract->source_employee = rq('source_employee');
                
            }
        }
    
        $date_explode = explode('-', rq('sign_date')); //切割时间
        $contract->remark = rq('remark');
        $contract->source_store = rq('source_store');
        $contract->contract_addr = rq('contract_addr');
        $contract->employee_code = rq('employee_code');
        $contract->sign_amount = rq('sign_amount');
        $contract->is_signed = 0;
        $contract->year =  $date_explode[0];
        $contract->month =  $date_explode[1];
        $contract->day = $date_explode[2];
        if($contract->type == 1){
            $number_count = contract_ins()->where('year', $contract->year)->where('month', $contract->month)->where('day', $contract->day)->where('type', $contract->type)->count() + 1;
            $contract->number = 'hjf'.$contract->year.$contract->month.$contract->day.$number_count;
        }else{
            $contract->number = rq('number');
        }
        $contract->store_code = rq('store_code');
        $contract->created_at = date("Y-m-d H:i:s");
        if($contract->save())
            return suc($contract->id);
    }

    /**
     * 存储图片
     */
    public function cStoreImages(Request $request, $contract_id){
        $file = $request->file();
        if(count($file) > 0){
            $count = 0;
            foreach ($file as $key => $value) {
                $tmpName    = $value->getFileName(); //文件临时名称
                $entension  = $value->getClientOriginalExtension();//文件后缀
                $name = date('YmdHi').$tmpName.'.'.$entension;
                $path = $value->move(public_path().'/static/files/images', $name);//移动文件到指定目录
                if(DB::table('contract_images')->insert(['url' => '/static/files/images/'.$name, 'contract_id' => $contract_id]))
                    $count++;

            }
            return suc('共计'.$count.'张图片！');
        }else{
            return suc('无图片！');
        }
    }

    /**
     * 删除图片
     */
    public function cDelImage($id){
        if(DB::table('contract_images')->where('id', $id)->update(['status_del' => 1])){
            return suc('删除成功！');
        }else{
            return err('删除失败');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $show = contract_ins()->where('id', $id)->with('employee', 'store', 'source_employee')->first();
        if (strlen($show->month) == 1){
            $show->month = '0'.$show->month;
        }
        if (strlen($show->day) == 1){
            $show->day = '0'.$show->day;
        }
        $show->sign_date = $show->year."-".$show->month."-".$show->day;
        if($show->type == 1) {
            $show->type_name = '一手';
        } else if($show->type == 2) {
            $show->type_name = '二手';
        } else {
            $show->type_name = '租单';
        }
        $show->images = DB::table('contract_images')->where('contract_id', $show->id)->where('status_del', 0)->get();
        return suc($show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $date_explode = explode('-', rq('sign_date')); //切割时间
        $contract = contract_ins()->where('id', $id)->first();
        $old_contract_number = $contract->number; //要修改的签单编号
        $exist_number = contract_ins()->where('number', rq('number'))->first();
        if($exist_number && ($exist_number->id != $id)){
            return err('合同单号重复');
        }
        $contract->number = rq('number');
        $contract->contract_addr = rq('contract_addr');
        $contract->remark = rq('remark');
        $contract->employee_code = rq('employee_code');
        //$contract->sign_amount = rq('sign_amount');
        $contract->real_amount = rq('real_amount');
        $contract->year = $date_explode[0];
        $contract->month = $date_explode[1];
        $contract->day = $date_explode[2];
        if($contract->save()){
            DB::table('staff_transfer_record')
                ->where('contract_number', $old_contract_number)
                ->update(['contract_number' => rq('number')]);
            return succ('修改成功');
        }
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
        
    }
    /**
     * [cUpdateRealAmount 更新结佣金额]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function cUpdateRealAmount($id)
    {
        $real_amount = contract_ins()
            ->where('id', $id)
            ->update([
                'real_amount' => rq('real_amount'),
                ]);
        return suc($real_amount);

    }
    /**
     * [cRecevicedAmount 更新实收金额]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function cRecevicedAmount($id)
    {
        $received_amount = contract_ins()
            ->where('id', $id)
            ->update([
                'received_amount' => rq('received_amount'),
                ]);
        return suc($received_amount);
    }
    /**
     * [cUpdateisSign 更新结佣状态]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function cUpdateisSign($id)
    {
        $contract = contract_ins()
            ->where('id', $id)
            ->first();
        if($contract->type == 2 && !(transfer_ins()->where('contract_number', $contract->number)->exists()))
            return err('未过户，不得结佣！');
        $contract->is_signed = 1;
        $contract->remark = $contract->remark.'    结佣备注：'.rq('remark');
        if($contract->save())
            return succ('ok');
    }


    
}
