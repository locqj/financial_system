<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

date_default_timezone_set('Asia/Shanghai');

class StaffPositionController extends Controller
{   
   
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $store_code = store_new()->where('status_del', 0)->orderBy('id', 'desc')->select('code')->first();
        $store_code = $store_code->code;
        $positions = position_ins()
            ->where('store_code', $store_code)
            ->where('status_del', 0)->with('store')->with('positionLevel')->paginate(10);
    
        //return $positions;
        $level_data = DB::table('staff_position_level')
            ->get();
        $store = store_new()->where('status_del', 0)->get();
        $position_code = position_ins()->where('status_del', 0)->where('store_code', $store_code)->count();
        return view('job.job_management', compact('positions', 'store', 'store_code', 'position_code', 'level_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        /*有code 为修改， 无为*/
        if (rq('id')){
            return $this->show(rq('id'));
        }
        if (rq('store_code')){
            $status_blade = 1; //添加职位标识
            return view('job.new_job', compact('status_blade'));
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
        $position = position_ins();
        $code = $this->cPositionCode(rq('store_code'), rq('s_code'), rq('level'));
        /*$exist_name_level = $position
            ->where('name', rq('name'))
            ->where('store_code', rq('store_code'))
            ->where('level', rq('level'))->exists();
        if($exist_name_level)
            return err('职位已存在');*/
        $position->name = rq('name');
        $position->store_code = rq('store_code');
        $position->code = $code;
        $position->level = (rq('level') == null)?1:rq('level');
        $position->salary = rq('salary');
        if($position->save())
            return succ("添加成功");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = position_ins()->where('id', $id)->first();
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
        $position = position_ins()->where('id', $id)->first();
        $old_code = $position->code;
        /*判断职位是否存在*/
        $exist_name_level = $position
            ->where('name', rq('name'))
            ->where('level', rq('level'))->exists();
        if($exist_name_level && ($position->id != $id))
            return err('职位已存在');
        $exist_code = $position
            ->where('status_del', 0)->where('code', rq('code'))->first();
        if($exist_code && ($exist_code->id != $id))
            return err('职位编号重复');
        $position->name = rq('name');
        $position->code = rq('code');
        $position->level = rq('level');
        $position->salary = rq('salary');
        if($position->save()){
            DB::table('employee_position')
                ->where('position_code', $old_code)
                ->update(['position_code' => rq('code')]);
            return succ("修改成功");
        }
    }

    /**
     * [cUpdateSalary 修改工资]
     * @return [type] [description]
     */
    public function cUpdateSalary()
    {
        $update_salary = DB::table('staff_position')->where('id', rq('id'))->update(['salary' => rq('salary')]);
        if($update_salary){
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
        $position = position_ins()->where('id', $id)->update(['status_del' => 1]);
        if($position)
            return suc("删除成功");
        else
            return err("删除失败");
    }

    /**
     * 职位调整展示页面
     */
    public function cJobAdjustment()
    {   
        /*店铺code*/
        $store_code = store_new()->where('status_del', 0)->orderBy('id', 'desc')->select('code')->first();
        $store_code = $store_code->code;
        
        $store = store_new()->where('status_del', 0)->select('name', 'code')->get();

        /*店铺*/
        $employee_position_store = employee_position()
            ->where('store_code', $store_code)
            ->with('employee', 'position', 'store')
            ->paginate(10);
        foreach ($employee_position_store as $key => $value) {
            if($value->employee->status == 0){
                unset($employee_position_store[$key]);
            }
        }
        /*区域*/
        $employee_position_zone = employee_position()
            ->where('store_code', 'like', 'qy%')
            ->with('employee', 'position', 'zone')
            ->with('store')
            ->paginate(10);
        foreach ($employee_position_zone as $key => $value) {
            if($value->employee->status == 0){
                unset($employee_position_zone[$key]);
            }
        }
        $zone_all = store_zone_ins()->where('status', 1)->select('name', 'code')->get();
        
        $select_all = compact('store', 'zone_all');
        return view('job.job_adjustment', compact('store', 'store_code', 'employee_position_store', 'employee_position_zone', 'select_all'));
    }
    /**
     * [cJobAdjustmentAjax 调整职位ajax]
     * @return [type] [description]
     */
    public function cJobAdjustmentAjax()
    {   
        $r_data = employee_position()
            ->where('id', rq('id'))
            ->with('store')
            ->with('position')
            ->with('employee')
            ->first();
        $position = position_ins()
            ->where('status_del', 0)->where('store_code', $r_data->store_code)->get();
        foreach ($position as $key => $value) {
            if($value->code == 'dz01'){
                $employee_position = employee_position()
                    ->where('store_code', $r_data->store_code)
                    ->where('position_code', 'dz01')
                    ->orderBy('id', 'desc')
                    ->with('employee')->first();
                if($employee_position){
                    if($employee_position->employee->status == 1){
                        unset($position[$key]);
                    }
                }
                
            }
        }
        $r_data->positions = $position;
        return suc($r_data);
    }

    /**
     * [cJobAdjustmentSub 职位调整信息提交]
     * @return [type] [description]
     * position_code ，store_code 都是更替后的职位
     * 
     */
    public function cJobAdjustmentSub()
    {   
        /*如果该月员工已签过单，那么不能调整职位*/
        $request = \Request::instance();
        $employee = employee_position()->where('id', $request->id)->first();
        $year = date('Y');
        $month = date('m');
        $re = $employee->contract()->where('status_del', 0)->
        where('month', $month)->where('year', $year)->first();
        if($re)
        {
            return err('该员工在这个月已有签单，不能调整职位');
        }
        /*判断修改的职位是否为店长*/
        if (rq('position_code') == 'dz01') {
            /*检索该调整职位的数据*/
            $exists_dz01 = employee_position()
                ->where('store_code', rq('store_code'))
                ->where('position_code', rq('position_code'))
                ->with('employee', 'store')
                ->first();
            /*查找该店店长职位是否有无原始记录*/
            $exists_dz = employee_position()
                ->where('store_code', rq('store_code'))
                ->where('position_code', rq('position_code'))
                ->with('employee', 'store')
                ->count();
            if($exists_dz == 0){
                /**/
                $this->cPositionAdjustmentLog(rq('id'), rq('store_code'), rq('position_code'));
                $r_data = employee_position()->where('id', rq('id'))->update([
                        'store_code' => rq('store_code'),
                        'position_code' => rq('position_code')
                        ]);
                if ($r_data) {
                    $this->cSetParentStore(rq('old_store_code'), rq('store_code'));
                    return succ('修改成功');
                }
            }else{
                if($exists_dz01->employee->status == '0'){
                    $this->cPositionAdjustmentLog(rq('id'), rq('store_code'), rq('position_code'));
                    $r_data = employee_position()->where('id', rq('id'))->update([
                        'store_code' => rq('store_code'),
                        'position_code' => rq('position_code')
                        ]);
                    if($r_data){
                        $this->cSetParentStore(rq('old_store_code'), rq('store_code'));
                        return succ('修改成功');
                    }
                }else{
                    return err('该店店长已存在');
                }
            }
            
        } else {
            $this->cPositionAdjustmentLog(rq('id'), rq('store_code'), rq('position_code'));
            $r_data = employee_position()->where('id', rq('id'))->update([
                'store_code' => rq('store_code'),
                'position_code' => rq('position_code')
                ]);
            if ($r_data) {
                return succ('修改成功');
            }
        }
    }


    /**
     * [cPositionLevel 修改薪水规则]
     * @return [type] [description]
     */
    public function cPositionLevel()
    {
        $level_data = DB::table('staff_position_level')
            ->get();
        return suc($level_data);
    }

    /**
     * [cPositionLevel 修改薪水规则提交]
     * @return [type] [description]
     */
    public function cPositionLevelSub()
    {
        for($i = 1; $i < 4; $i++){
            $r_data = DB::table('staff_position_level')
            ->where('code', $i)->update([
                'top' => rq('top'.$i),
                'bottom' => rq('bottom'.$i),
                ]);
        }
        return succ('插入成功');
        
    }
    /**
     * [cPositionAdjustmentLog 记录职位修改]
     * @param  [type] $id            [description]
     * @param  [type] $store_code    [description]
     * @param  [type] $position_code [description]
     * @return [type]                [description]
     */
    public function cPositionAdjustmentLog($id, $store_code, $position_code)
    {
        $get_old = employee_position()->where('id', $id)->first();
        $old_position_code = $get_old->position_code;
        $new_position_code = $position_code;
        $created_at = date("Y-m-d H:i:s");
        $employee_code = $get_old->employee_code;
        $old_store_code = $get_old->store_code;
        $new_store_code = $store_code;
        $year = date('Y');
        $month = date('m');
        $exists_log = DB::table('position_adjustment_log')
            ->where('month', $month)->where('year', $year)->where('employee_code', $employee_code)->exists();
        if($exists_log){
            DB::table('position_adjustment_log')->update([
                'new_position_code' => $new_position_code,
                'created_at' => $created_at,
                'employee_code' => $employee_code,
                'new_store_code' => $new_store_code,
                'year' => $year,
                'month' => $month
                ]);
        }else{
             DB::table('position_adjustment_log')->insert([
                'old_position_code' => $old_position_code,
                'new_position_code' => $new_position_code,
                'created_at' => $created_at,
                'employee_code' => $employee_code,
                'old_store_code' => $old_store_code,
                'new_store_code' => $new_store_code,
                'year' => $year,
                'month' => $month
                ]);
        }

    }

    /**
     * [cSetParentStore 设置子店铺]
     * @param  [type] $old_code [description]
     * @param  [type] $new_code [description]
     * @return [type]           [description]
     */
    protected function cSetParentStore($old_store_code, $new_store_code)
    {
        if($old_store_code == $new_store_code) {
            return;
        } else if (substr($old_store_code, 0, 4) == 'qy00'){
            return;
        } else {
            $update_child_store = store_new()->where('code', $new_store_code)->update(['parent_code' => $old_store_code, 'parent_start_time'=>date('Y-m-d')]);
            if($update_child_store) {
                return;
            }
        }
    }


}
