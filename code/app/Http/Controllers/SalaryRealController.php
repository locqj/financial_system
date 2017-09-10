<?php

namespace App\Http\Controllers;



use App\Http\Requests;


use Illuminate\Support\Collection;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;

use Session;
date_default_timezone_set('Asia/Shanghai');

class SalaryRealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        $store_code = Session::get('store_code');
        $employee_code = Session::get('employee_code');
        $years = calculate_log_ins()->groupBy('year')->select('year')->get();
        $year = date('Y');
        $month = date('m');
        if(Session::get('level_code') == 'dz' || Session::get('level_code') == 'zl' || Session::get('level_code') == 'xs'){
            /*dz,zl,xs只能看自己的信息*/
            $store = store_new()->where('status_del', 0)->where('code', $store_code)->get(); 
            /*获取员工*/
            $get_employee = employee_position()->where('store_code', $store_code)
                ->where('employee_code', $employee_code)->with('employee', 'position', 'store')->get();
            /*获取相应员工工资详情*/
            $salary_list = $this->cGrantLog($year, $month, $employee_code, $store_code, $employee_code);
            
        }else{
            $store = store_new()->where('status_del', 0)->get(); 
            $employee_code = 'all';
            $get_employee = employee_position()->where('store_code', $store_code)
                ->with('employee', 'position', 'store')->get();
            $salary_list = $this->cGrantLog($year, $month, $employee_code, $store_code);    
        }
        

        foreach ($get_employee as $key => $value) {
            if($value->employee->status == 0){
                unset($get_employee[$key]);
            }
        }
        /*分页*/
        $perPage = 10;
        if ($request->has('page')) {
            $current_page = $request->input('page');
            $current_page = $current_page <= 0 ? 1 :$current_page;
        } else {
            $current_page = 1;
        }
        $item = array_slice($salary_list, ($current_page-1)*$perPage, $perPage); //注释1
        $total = count($salary_list);
        $paginator =new LengthAwarePaginator($item, $total, $perPage, $current_page, [
                'path' => Paginator::resolveCurrentPath(),  //注释2
                'pageName' => 'page',
        ]);
        $salary_list = $paginator->toArray()['data'];
        
        return view('job.salary_real', compact('year', 'years', 'month', 'store_code', 'store', 'salary_list', 'get_employee', 'employee_code', 'paginator'));

    }

    /**
     * 确认工资
     */
    public function cSalaryConfirm(){
        if(session('employee_code') == rq('employee_code')){
            grant_log_ins()->where('id', rq('id'))->update(['is_confirm' => 1]);
            return suc('确认成功');
        }else{
            return err('必须本人操作');
        }
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
        $grant_log = grant_log_ins();
        $grant_log->year = rq('year');
        $grant_log->month = rq('month');
        $grant_log->amount = rq('amount');
        $grant_log->employee_code = rq('employee_code');
        $grant_log->created_at = date('Y-m-d h:m:sa');
        $grant_log->record_user = 'xxx';
        if($grant_log->save()){
            return succ('录入成功');
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
        //
    }

    /**
     * 删除信息
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $del = grant_log_ins()->where('id', $id)->delete();
        if($del){
            return succ('ok');
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
        //
    }
    /*获取grant_log信息*/
    public function cEmployeeRealSalary()
    {
        $employee_code = grant_log_ins()
            ->where('employee_code', rq('employee_code'))
            ->where('year', rq('year'))->where('month', rq('month'))->get();
        return suc($employee_code);
    }
    /*
    * 获取员工的职位规则
    * 销售-1, 助理分红-2，店长分红-3， 4-区域经理， 5-总经理
    */
    public function cGetBonusRules($position_code)
    {
        $get_position_key = substr($position_code, 0, 2);
        $rule_key = $this->cSelectRuleKey($get_position_key);
        $get_bonus_rule = bonus_rule_ins()
            ->where('status_del', 0)->where('rule_key', $rule_key)->get();
        $data = compact('get_bonus_rule', 'get_position_key');
        return suc($data);

    }


    // 返回对应规则
    protected function cSelectRuleKey($get_position_key)
    {
        switch ($get_position_key) {
            case 'xs':
                return 1;
                break;
            case 'zl':
                return 2;
                break;
            case 'dz':
                return 3;
                break;
            case 'qy':
                return 4;
                break;
            case 'jl':
                return 5;
                break;
            default:
                # code...
                break;
        }
    }

}
