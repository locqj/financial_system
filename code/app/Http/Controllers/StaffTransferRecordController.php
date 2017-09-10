<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Session;

date_default_timezone_set('Asia/Shanghai');

class StaffTransferRecordController extends Controller
{   
   
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // 店长或助理限制只能看自己本店信息
        if(Session::get('level_code') == 'dz' || Session::get('level_code') == 'zl'){
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
        $guohus = employee_position()
            ->where('position_code', 'gh01')
            ->with('position')->with('employee')->get(); //查找过户专员
        foreach ($guohus as $key => $value) {
            if($value->employee->status == 0){
                unset($guohus[$key]);
            }
        }
        $year = date('Y');
        $month = date('m');
        $contract_count = $this->cGetContract($store_code, $year, $month);
        $contract_count = count($contract_count['data']);
        $years = transfer_ins()->where('status_del', 0)->groupBy('year')->select('year')->get();
        if($store_code == 'all'){
            $transfer = transfer_ins()->where('year', $year)
            ->where('month', $month)->where('status_del', 0)->with('store')
            ->with('employee')->with('contract')->orderBy('store_code')->paginate(10);
        }else{
            $transfer = transfer_ins()
            ->where('year', $year)->where('month', $month)
            ->where('status_del', 0)->where('store_code', $store_code)
            ->with('store')->with('employee')->with('contract')->paginate(10);
        }
        
        return view('transfer.transfer_record', 
            compact('transfer', 'store', 'contract_count', 'guohus', 'store_code', 'years', 'year', 'month'));
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
        date_default_timezone_set('Asia/Shanghai');
        if(transfer_ins()->where('contract_number', rq('contract_number'))->where('status_del', 0)->exists()){
            return err('已过户');
        }
        $transfer = transfer_ins();
        $date_explode = explode('-', rq('transfer_date')); //切割时间
        $transfer->year = $date_explode[0];
        $transfer->month = $date_explode[1];
        $transfer->day = $date_explode[2];
        $transfer->store_code = rq('store_code');
        $transfer->employee_code = rq('employee_code');
        $transfer->amount = rq('amount');
        $transfer->created_at = date("Y-m-d H:i:s");
        $transfer->contract_number = rq('contract_number');
        $transfer->remark = rq('remark');
        if($transfer->save()){
            $transfer_return = transfer_ins()->where('contract_number', rq('contract_number'))->where('status_del', 0)->first();
            $transfer_return->type_name = '过户';
            return suc($transfer_return);
        }else{
            return err("添加失败！");
        }
    }

    /**
     * 签单动态编辑过户
     */
    public function cEdit(){
        $transfer = transfer_ins()->where('id', rq('id'))->first();
        $date_explode = explode('-', rq('transfer_date')); //切割时间
        $transfer->year = $date_explode[0];
        $transfer->month = $date_explode[1];
        $transfer->day = $date_explode[2];
        $transfer->employee_code = rq('employee_code');
        $transfer->amount = rq('amount');
        $transfer->remark = rq('remark');
        if($transfer->save()){
            return suc('修改成功！');
        }else{
            return err('修改失败！');
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
        $show = transfer_ins()
            ->where('id', $id)->with('store')
            ->with('employee')->with('contract')->first();
        if (strlen($show->month) == 1){
            $show->month = '0'.$show->month;
        }
        if (strlen($show->day) == 1){
            $show->day = '0'.$show->day;
        }    
        $show->date = $show->year."-".$show->month."-".$show->day;
        if($show)
            return suc($show);
        return err('无该记录');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transfer = transfer_ins()->where('id', $id)->first();
        $old_contract = $transfer->contract_number;
        $date_explode = explode('-', rq('transfer_date')); //切割时间
        $transfer->year = $date_explode[0];
        $transfer->month = $date_explode[1];
        $transfer->day = $date_explode[2];
        $transfer->employee_code = rq('employee_code');
        $transfer->amount = rq('amount');
        $transfer->contract_number = rq('contract_number');
        if($transfer->save()){
            $transfer = transfer_ins()
                ->with('store')->with('employee')->with('contract')
                ->where('id', $id)->first();
            return suc($transfer);
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
    


    public function cGetTranfer()
    {
        $tranfer_employee = employee_position()
            ->where('status', 1)->with('employee')->with('position')->where('position_code', 'gh01')
            ->get();
        return suc($tranfer_employee);
    }


    public function test()
    {
        $get_update_code = calculate_log_ins()->where('is_last', 1)->select('update_code')->first();
        return $get_update_code->update_code;
    }
}
