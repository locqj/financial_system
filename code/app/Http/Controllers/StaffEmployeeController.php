<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\User;
use Session;
/*use App\StaffPosition;*/
date_default_timezone_set('Asia/Shanghai');

class StaffEmployeeController extends Controller
{   
    
     /**
     * Display a listing of the resource.
     * 展示全部员工信息
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        $store_code = Session::get('store_code');
        // 店长或助理限制只能看自己本店信息
        if(Session::get('level_code') == 'dz' || Session::get('level_code') == 'zl'){
            $store = store_new()->where('status_del', 0)->where('code', $store_code)->get(); 
        }else{
            $store = store_new()->where('status_del', 0)->get(); 
        }

        $lists = employee_position()->where('store_code', $store_code)->with('position', 'employee', 'positionLevel')->paginate(10);
        foreach ($lists as $key => $value) {
            if($value->employee->sex == '0')
                $value->employee->sex = '男';
            else
                $value->employee->sex = '女';
            $get_store_name = DB::table('store_store')
                ->where('status_del', 0)
                ->where('code', $value->store_code)
                ->first();
            $value->store_name = $get_store_name->name;
            if($value->employee->status == 0){
                unset($lists[$key]);
            }
        }
        
        $employee_count = $this->cEmployeeCount($store_code);
        return view('employee.employee_list', compact('lists', 'employee_count', 'store', 'store_code'));
    }

    /**
     * Show the form for creating a new resource.
     * 显示表单(一个界面)
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

    }

    /**
     * 查找店铺职位
     */
    public function cGetPosition()
    {   
        /*$position = position_ins()->where('status_del', 0)
            ->where('store_code', rq('store_code'))->get();
        
        if($position)
            return suc($position);*/
    }
    
    /**
     * Store a newly created resource in storage.
     * 提交表单(添加员工)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = employee_ins();
        $code = $this->cEmployeeCode(rq('store_code')); //自定生成code
        $exist_name = $employee
            ->where('status', 1)
            ->where('name', rq('name'))->exists();//判断员工是否存在
        /*$exist_code = $employee
            ->where('status', 1)->where('code', $code)->exists();*/
        if($exist_name)
            return err('该员工已存在');
        /*if($exist_code)
            return err('员工编号重复');*/
        $employee->name = rq('name');
        $employee->sex = rq('sex'); //男--0， 女--1
        $employee->birth = rq('birth');
        $employee->id_card = rq('id_card');
        $employee->phone = rq('phone');
        $employee->addr = rq('addr');
        $employee->entry_time = rq('entry_time');
        $employee->code = $code;
        $employee->created_at = date("Y-m-d H:i:s");
        $employee_position = employee_position();
        $employee_position->position_code = rq('position_code');
        $employee_position->store_code = rq('store_code');
        $employee_position->employee_code = $code;
        if($employee->save() && $employee_position->save()){
            $data = $this->cInsertLoginUser(rq('name'), $code);
            return suc($data);
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
        $show = employee_position()
            ->with('employee')->with('position')
            ->where('id', $id)->first();
        return suc($show);
    }

    /**
     * Show the form for editing the specified resource.
     * 修改提交员工信息
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $employee_position = employee_position()->where('id', $id)->first(); //传过来的id是employee_position
        $employee = employee_ins()
            ->where('code', $employee_position->employee_code)->first();
        if ($employee) {
            $is = \App\StaffEmployee::where('status', 1)
            ->where('code', '<>', $employee_position->employee_code)
            ->where('name', rq('name'))->first();
            if($is){
                return err('该用户名已存在！');
            }       
            $employee->name = rq('name');
            $employee->sex = rq('sex');
            $employee->birth = rq('birth');
            $employee->id_card = rq('id_card');
            $employee->phone = rq('phone');
            $employee->addr = rq('addr');
            $employee->entry_time = rq('entry_time');
            
            if ($employee->save()) {
                $this->updateUserName($employee->code, $employee->name);
                return succ('修改成功');
            }
        }
    }

    /**
     * 更新员工姓名
     * @param  [type] $employee_code [description]
     * @param  [type] $username      [description]
     * @return [type]                [description]
     */
    public function updateUserName($employee_code, $username){
        $user = User::where('status', 1)->where('employee_code', $employee_code)->first();
        $user->username = $username;
        $user->save();
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
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     * 删除员工
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function cInsertLoginUser($name, $employee_code)
    {
        $pwd = '123456';
        $user = user_ins();
        $user->username = $name;
        $user->employee_code = $employee_code;
        $user->pwd = md5($pwd);
        $user->status = 1;
        $user->save();
        return ['username' => $name, 'pwd' => $pwd];

    }

    /**
     * [cEmployeeCode 自动生成员工code]
     * @param  [type] $store_code [description]
     * @return [type]             [description]
     */
    public function cEmployeeCode($store_code)
    {   
        $employee_count = employee_ins()->count();
        return $store_code.'T'.$employee_count;
    }



 
}
