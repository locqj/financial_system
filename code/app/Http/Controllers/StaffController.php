<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


use DB;

use Session;

class StaffController extends Controller
{   

    public function cSearch(Request $request, $status, $store_code, $year, $month, $employee_code = '', $end_month = '')
    {
        switch ($status) {
            case 'store':
                return $this->cStore($store_code, $year, $month);
                break;
            case 'costdetails':
                return $this->cCostDetails($store_code, $year, $month);
                break;
            case 'salarydetails':
                return $this->cSalaryDetails($store_code, $year, $month);
                break;
            case 'transfer':
                return $this->cTranfer($store_code, $year, $month);
                break;
            case 'contract':
                return $this->cContract($store_code, $year, $month, $end_month, $employee_code);
                break;
            case 'employeewage':
                return $this->cEmployeeWage($store_code, $year, $month);
                break;
            case 'employee':
                return $this->cEmployee($store_code, $year, $month);
                break;
            case 'position':
                return $this->cPosition($store_code, $year, $month);
                break;
            case 'position_adjument':
                return $this->cPositionAdjument($store_code, $year, $month);
                break;
            case 'count_all':
                return $this->cCount($store_code, $year, $month);
                break;
            case 'salary_real':
                return $this->cSalaryReal($request, $store_code, $year, $month, $employee_code);
                break;
            case 'port':
                return $this->cPort($store_code, $year, $month, $employee_code);
                break;
            case 'reducesalary':
                return $this->cReduceSalary($store_code, $year, $month);
            default:
                # code...
                break;
        }
    }


    /**
     * [cSearchSeason 按季度搜索]
     * @param  [type] $status [description]
     * @param  [type] $season [description]
     * @return [type]         [description]
     */
    public function cSearchSeason($status, $season, $store_code, $year)
    {
        switch ($status) {
            case 'costdetails':
                return $this->cSeasonCostDatails($season, $store_code, $year);
                break;
            case 'transfer':
                return $this->cSeasonTransfer($season, $store_code, $year);
                break;
            case 'salarydetails':
                return $this->cSeasonSalaryDatails($season, $store_code, $year);
                break;
            default:
                # code...
                break;
        }
    }



    /**
     * [cDel 删除操作]
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    public function cDel($status, $id)
    {
        switch ($status) {
            case 'employee':
                return $this->cEmployeeDel($id);
                break;
            case 'position':
                return $this->cPositionDel($id);
                break;
            case 'contract':
                return $this->cContractDel($id);
                break;
            case 'transfer':
                return $this->cTransferDel($id);
                break;
            case 'port':
                return $this->cPortDel($id);
                break;
            case 'reduce':
                return $this->cReduceDel($id);
                break;
            default:
                # code...
                break;
        }
        
    }
    /**
     * [cSearchEmployee 按员工名称搜索]
     * @param  [type] $status        [description]
     * @param  [type] $employee_name [description]
     * @return [type]                [description]
     */
    public function cSearchEmployee($status, $employee_name){
        switch ($status) {
            case 'employee':
                return $this->cEmployeeInfo($employee_name);
                break;
            case 'adjustment':
                return $this->cPositionAdjustmentInfo($employee_name);
                break;
            
            default:
                # code...
                break;
        }
    }


    /**
     * [cJobAbjSearchByPosition 根据店铺获取店铺职位]
     * @return [type] [description]
     */
/*    protected function cJobAbjSearchByPosition()
    {
        $r_data = position_ins()
            ->where('status_del', 0)->where('store_code', rq('store_code'))->get();
        return suc($r_data);
    }*/
    /**
     * [cGetPosition 获取店铺职位信息]
     * @param  [type] $store_code [description]
     * @return [type]             [description]
     */
    protected function cGetPosition($store_code)
    {
        $position = position_ins()
            ->where('status_del', 0)
            ->where('store_code', $store_code)->get();
        foreach ($position as $key => $value) {
            if($value->code == 'dz01'){
                $employee_position = employee_position()
                    ->where('store_code', $store_code)
                    ->where('position_code', 'dz01')
                    ->orderBy('id', 'desc')
                    ->with('employee')->first();
                /*如果存在店长就不让其添加*/
                if($employee_position){
                    if($employee_position->employee->status == 1){
                        unset($position[$key]);
                    }
                }
                
            }
        }
        return suc($position);
    }
    /**
     * [cGetEmployee 获取店铺员工信息]
     * @param  [type] $store_code [description]
     * @return [type]             [description]
     */
    protected function cGetEmployee($store_code, $employee_code)
    {   

        $employee_position = employee_position()
            ->where('store_code', $store_code)
            ->whereIn('position_code', ['xs01', 'xs02', 'xs03', 'xs04', 'xs05', 'zl01', 'zl02', 'zl03'])
            ->with('employee')->with('position')->get();
        foreach ($employee_position as $key => $value) {
            if($value->employee->status != 1) {
                unset($employee_position[$key]);
            }
            if($value->employee_code == $employee_code) {
                unset($employee_position[$key]);
            }
        }
        return suc($employee_position);
    }

    protected function cGetPortEmployee($store_code)
    {
        $employee_position = employee_position()
            ->where('store_code', $store_code)
            ->whereIn('position_code', ['xs01', 'xs02', 'xs03', 'xs04', 'xs05', 'zl01'])
            ->with('employee')->with('position')->get();
        foreach ($employee_position as $key => $value) {
            if($value->employee->status != 1) {
                unset($employee_position[$key]);
            }
        }
        return suc($employee_position);   
    }

    /**
     * [cGetEmployee 获取店铺所有员工]
     * @param  [type] $store_code [description]
     * @return [type]             [description]
     */
    protected function cGetStoreAllEmployee($store_code)
    {
        $employee_position = employee_position()
            ->where('store_code', $store_code)
            ->with('employee')->with('position')->get();
        foreach ($employee_position as $key => $value) {
            if($value->employee->status != 1){
                unset($employee_position[$key]);
            }
        }
        return suc($employee_position);
    }

    /**************************************关于删除*********************************************/
    /**
     * [cEmployeeDel 员工删除]
     * @param  [type] $id [code]
     * @return [type]     [description]
     */
    protected function cEmployeeDel($id)
    {
        $employee = employee_ins()->where('code', $id)->update(['status' => 0]);
        if($employee){
            $find_user = DB::table('user')->where('employee_code', $id)->first();
            if($find_user){
                DB::table('user')->where('employee_code', $id)->update(['status' => 0]);
            }
            return succ('删除成功');
        }
        else{
            return err("删除失败");
        }
    }
    /**
     * [cPositionDel 职位删除]
     * @param  [type] $id [code]
     * @return [type]     [description]
     */
    protected function cPositionDel($id)
    {
        $employee = position_ins()->where('code', $id)->update(['status_del' => 1]);
        if($employee){
            return succ("删除成功");
        }
        else
            return err("删除失败");
    }
    /**
     * [cContractDel 合同删除]
     * @param  [type] $id [id]
     * @return [type]     [description]
     */
    protected function cContractDel($id)
    {   

        $contract = contract_ins()->where('id', $id)
            ->first();
        $transfer = transfer_ins()
            ->where('contract_number', $contract->number)
            ->where('status_del', 0)->exists();
        if($transfer){
            DB::table('staff_contract')->where('id', $id)->update(['status_del' => 1]);
            DB::table('staff_transfer_record')
                ->where('contract_number', $contract->number)
                ->update(['status_del' => 1]);
            return succ("ok");
        }else{
            DB::table('staff_contract')->where('id', $id)->update(['status_del' => 1]);
            return succ("ok");
        }
    }
    /**
     * [cTransferDel 过户删除]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    protected function cTransferDel($id)
    {
        $transfer = DB::table('staff_transfer_record')
            ->where('id', $id)
            ->update(['status_del' => 1]);
        if($transfer){
            // $this->cDelStoreCost($id);
            return suc($transfer);
        }
    }
    /**
     * [cTransferDel 端口删除]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    protected function cPortDel($id)
    {
        $port = staff_port_ins()->find($id);
        $port->status = 0;
        if($port->save()){
            return succ('ok');
        }else{
            return err('网络问题');
        }
    }

    protected function cReduceDel($id)
    {
        $reduce = salary_reduce_ins()->find($id);
        $reduce->status = 0;
        if($reduce->save()){
            return succ('ok');
        }else{
            return err('网络问题');
        }
    }
    /**************************************关于删除*********************************************/

    /**************************************关于员工名字搜索*************************************/
    /**
     * [cEmployeeInfo 员工页面的员工搜索]
     * @param  [type] $employee_name [description]
     * @return [type]                [description]
     */
    protected function cEmployeeInfo($employee_name)
    {
        $exist_name = employee_ins()->where('status', 1)->where('name', $employee_name)->first();
        if(!$exist_name){
            $data['message'] = $employee_name.'不存在！';
            $data['url'] = '/employee';
            $data['jumpTime'] = 2;
            return view('jump', compact('data', 'user'));
        }
        $lists = employee_position()
            ->where('employee_code', $exist_name->code)
            ->with('position')
            ->with('employee')
            ->paginate(10);
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
        $store = store_new()->where('status_del', 0)->get();
        $employee_count = 1;
        return view('employee.employee_list', compact('lists', 'store', 'employee_count', 'code'));

    }
    /**
     * [cPositionAdjustmentInfo 职位调整页按员工搜索]
     * @param  [type] $employee_name [description]
     * @return [type]                [description]
     */
    protected function cPositionAdjustmentInfo($employee_name)
    {   
        $exist_name = employee_ins()
            ->where('name', $employee_name)->where('status', 1)->first();
        if(!$exist_name){
            $data['message'] = $employee_name.'不存在！';
            $data['url'] = '/position/adjustment';
            $data['jumpTime'] = 2;
            return view('jump', compact('data', 'user'));
        }
        $store = store_new()->where('status_del', 0)->get();
        $employee_position = employee_position()
            ->where('employee_code', $exist_name->code)
            ->with('employee')->with('position')
            ->with('store')
            ->paginate(10);
        foreach ($employee_position as $key => $value) {
            if($value->employee->status == 0){
                unset($employee_position[$key]);
            }
        }
        $code = null;    
        return view('job.job_adjustment', compact('store', 'code', 'employee_position'));
    }
    /**************************************关于员工名字搜索*************************************/

    /********************************************搜索*******************************************/
    /**
     * [cCostDetails 成本详情记录]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cCostDetails($store_code, $year, $month)
    {   
        if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $store = store_new()->where('code', '<>', 'hj001')->where('status_del', 0)->where('code', session('store_code'))->get();  //根据权限进入相应的店铺
        }else{
            $store = store_new()->where('code', '<>', 'hj001')->where('status_del', 0)->get();
        }
        $years = cost_details_ins()->where('store_code', $store_code)->groupBy('year')->select('year')->get();
        $get_update_code = $this->cGetUpdateCodeBySearch($year, $month);
        if(!$get_update_code){
            $cost_details = array(); //无记录
        }else{
            $cost_details = cost_details_ins()
            ->where('update_code', $get_update_code)
            ->where('store_code', $store_code)->where('month', $month)->where('year', $year)->with('store')->paginate(10);
        }
        
        return view('store.store_cost_detail', compact('store', 'cost_details', 'years', 'year', 'month', 'store_code'));
    }
    /**
     * [cSalaryDetails 基本工资记录]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cSalaryDetails($store_code, $year, $month)
    {   
        
        if(in_array(Session::get('level_code'), ['dz', 'zl', 'xs'])){
            $store = store_new()->where('status_del', 0)->where('code', $store_code)->get();
        }else{
            $store = store_new()->where('status_del', 0)->get(); 
        }
        $years = salary_details_ins()->where('store_code', $store_code)->groupBy('year')->select('year')->get();
        $get_update_code = $this->cGetUpdateCodeBySearch($year, $month);
        if(!$get_update_code){
            $salary_details = array();//无记录
        }else{
            $salary_details = salary_details_ins()
                ->where('update_code', $get_update_code)
                ->where('store_code', $store_code)->where('month', $month)
                ->where('year', $year)->with('store')->with('employee')->paginate(10);
            $salary_details = $this->cGetSalaryDetailPosition($salary_details);
        }
        return view('job.salary_details', compact('store', 'salary_details', 'years', 'year', 'month', 'store_code'));   
    }
    /**
     * [cTranfer 过户页面]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cTranfer($store_code, $year, $month)
    {
        $transfer = transfer_ins()
            ->where('store_code', $store_code)
            ->where('status_del', 0)
            ->where('year', $year)->where('month', $month)
            ->with('employee')->with('store')->with('contract')
            ->paginate(10);
        $guohus = employee_position()
            ->where('position_code', 'gh01')
            ->with('position')->with('employee')->get(); //查找过户专员
        foreach ($guohus as $key => $value) {
            if($value->employee->status == 0){
                unset($guohus[$key]);
            }
        }

        $contract_count = $this->cGetContract($store_code);
        $contract_count = count($contract_count['data']);
        $store = store_new()->where('status_del', 0)->where('type', 2)->get();
        $years = transfer_ins()->where('status_del', 0)->groupBy('year')->select('year')->get();
        return view('transfer.transfer_record', 
            compact('transfer', 'store', 'contract_count', 'guohus', 'store_code', 'years', 'year', 'month'));
    }
    /**
     * [cContract 签单页面]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cContract($store_code, $year, $month, $end_month, $employee_code)
    {   
        if(in_array(session('level_code'), ['dz', 'zl', 'xs'])){
            $store = store_new()->where('status_del', 0)->where('code', $store_code)->get(); 
        }else{
            $store = store_new()->where('status_del', 0)->where('type', 2)->get();
        }
        if(session('level_code') == 'xs'){
            $allContracts = contract_ins()
            ->where('status_del', 0)->where('employee_code', session('employee_code'))->where('month', '>=', $month)->where('month', '<=', $end_month)->where('year', $year)
            ->get();

             $contracts = contract_ins()
            ->where('status_del', 0)->where('employee_code', session('employee_code'))->where('month', '>=', $month)->where('month', '<=', $end_month)->where('year', $year)
            ->with('employee')->with('store')->paginate(10);
        }else{
            if($employee_code == 'all'){
                $allContracts = contract_ins()->where('status_del', 0)
                    ->where('year', $year)->where('month','>=', $month)->where('month', '<=', $end_month)
                    ->where('store_code', $store_code)->get();

                $contracts = contract_ins()->where('status_del', 0)
                    ->where('year', $year)->where('month','>=', $month)->where('month', '<=', $end_month)
                    ->where('store_code', $store_code)->paginate(10);
                }else{
                    $allContracts = contract_ins()->where('status_del', 0)
                    ->where('year', $year)->where('month','>=', $month)->where('month', '<=', $end_month)
                    ->where('store_code', $store_code)->where('employee_code', $employee_code)->get();

                    $contracts = contract_ins()->where('status_del', 0)
                    ->where('year', $year)->where('month','>=', $month)->where('month', '<=', $end_month)
                    ->where('store_code', $store_code)->where('employee_code', $employee_code)->paginate(10);
                }
        }
        $received_amount_all = 0;
        foreach ($allContracts as $key => $value)
        {
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
                ->where('employee_code', $employee_code)
                ->with('employee')->with('position')->get();
            }else{
                $sign_employee = employee_position()
                ->where('store_code', $store_code)
                ->whereIn('position_code', ['xs01', 'xs02', 'xs03','xs04' , 'xs05', 'zl01', 'zl02', 'zl03'])
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
        $times = contract_ins()->where('status_del', 0)->groupBy('year')->where('store_code', $store_code)->get();
        $transferEmployee = employee_position()
            ->where('position_code', 'gh01')
            ->with('position')->with('employee')->get(); //查找过户专员
        return view('contract.contract', compact('contracts', 'store', 'times', 'sign_employee', 'years', 'year', 'month', 'store_code', 'store_list', 'get_tax','transferEmployee', 'employee_code', 'end_month', 'received_amount_all', 'allContracts'));
    }

    /**
     * [cEmployeeWage 员工工资记录表]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cEmployeeWage($store_code, $year, $month)
    {
        $store = store_new()->where('status_del', 0)->get();
        $get_update_code = $this->cGetUpdateCodeBySearch($year, $month);
        if(!$get_update_code){
            $grant_log = array();
        }else{
            $grant_log = grant_log_ins()->where('update_code', $get_update_code)
                ->where('store_code', $store_code)->with('employee', 'store', 'position')->paginate(10);
            foreach ($grant_log as $key => $value) {
                $grant_log[$key]['amount'] = $value->salary + $value->bonus + $value->dividend + $value->other;
            }
        }
        $years = salary_details_ins()->groupBy('year')->select('year')->get();
        return view('employee.employee_wage', compact('store_code', 'store', 'years', 'year', 'month', 'grant_log'));
    }
    /**
     * [cEmployee 员工管理]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cEmployee($store_code, $year, $month)
    {   
        if(substr($store_code, 0, 4) == 'qy00'){
            $lists = employee_position()
            ->where('store_code', $store_code)
            ->with('position')
            ->with('employee')
            ->paginate(10);
            foreach ($lists as $key => $value) {

                if($value->employee->sex == '0'){
                    $value->employee->sex = '男';
                }
                else{
                    $value->employee->sex = '女';
                }
                $get_store_name = store_zone_ins()
                    ->where('status', 1)
                    ->where('code', $value->store_code)
                    ->first();
                $value->store_name = $get_store_name->name;

                if($value->employee->status == 0){
                    unset($lists[$key]);
                }
            }
        
            $employee_count = $this->cEmployeeCount($store_code);    
            $store = store_zone_ins()->where('status', 1)->get();
                return view('employee.employee_qy_list', 
                    compact('lists', 'store', 'employee_count', 'store_code'));
        }else{
            $lists = employee_position()
            ->where('store_code', $store_code)
            ->with('position')
            ->with('employee')
            ->paginate(10);
            //return $lists;
            foreach ($lists as $key => $value) {

                if($value->employee->sex == '0'){
                    $value->employee->sex = '男';
                }else{
                    $value->employee->sex = '女';
                }
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
            $code = store_new()->where('code', $store_code)->first();
            $store = store_new()->where('status_del', 0)->get();
                return view('employee.employee_list', 
                    compact('lists', 'store', 'code', 'employee_count', 'store_code'));
        }
    }
    /**
     * [cPosition 职位管理]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cPosition($store_code, $year, $month)
    {   
        if(substr($store_code, 0, 4) == 'qy00'){
            $positions = position_ins()
                ->where('store_code', $store_code)
                ->with('positionLevel')
                ->with('zone')
                ->where('status_del', 0)
                ->paginate(10);
            foreach ($positions as $key => $value) {
                $value->store = $value->zone;
            }
            $store = store_zone_ins()->where('code', $store_code)->get();
            //return $positions;
        }else{
            $positions = position_ins()
                ->where('store_code', $store_code)
                ->with('positionLevel')
                ->with('store')
                ->where('status_del', 0)
                ->paginate(10);
            $store = store_new()->where('status_del', 0)->where('code', $store_code)->get();

        }

        /*return $positions;*/
        $level_data = DB::table('staff_position_level')
            ->get();
        $position_code = position_ins()
            ->where('store_code', $store_code)
            ->where('status_del', 0)->count();
        return view('job.job_management', 
            compact('positions', 'position_code', 'store', 'level_data', 'store_code'));
    }
    /**
     * [cPositionAdjument 职位调整]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cPositionAdjument($store_code, $year, $month)
    {   

        $store = store_new()->where('status_del', 0)->get();
    
        $employee_position_store = employee_position()
            ->where('store_code', $store_code)
            ->with('employee', 'position', 'store')
            ->paginate(10);
        foreach ($employee_position_store as $key => $value) {
            if($value->employee->status == 0){
                unset($employee_position_store[$key]);
            }
        }

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
        return view('job.job_adjustment', compact('store', 'employee_position_store', 'employee_position_zone', 'store_code', 'select_all'));
    }
    /**
     * [cCount 财务总计算页面]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cCount($store_code, $year, $month)
    {
        $years = cost_details_ins()->groupBy('year')->select('year')->get();
        $update_code = DB::table('calculate_log')->where('year', $year)->where('month', $month)->orderBy('id', 'desc')->paginate(10);
        return view('count.count', compact('years', 'year', 'month', 'update_code'));
    }
    /**
     * [cSalaryReal 实发工资结算页面]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cSalaryReal(Request $request, $store_code, $year, $month, $employee_code)
    {   
        //$store_code = Session::get('store_code');
        //$employee_code = Session::get('employee_code');
        // 店长或助理限制只能看自己本店信息
        if(substr($store_code, 0, 4) == 'qy00') {
            $store = store_zone_ins()->where('status', 1)->get(); 
        } else {
            $store = store_new()->where('status_del', 0)->get(); 
        }
        $get_update_code = $this->cGetUpdateCodeBySearch($year, $month);
        if(!$get_update_code){
            $get_employee = array();
        }else{
            if(substr($store_code, 0, 4) == 'qy00') {
                $get_employee = employee_position()->where('store_code', $store_code)->with('employee', 'position', 'zone')->get();
            } else {
                $get_employee = employee_position()->where('store_code', $store_code)->with('employee', 'position', 'store')->get();
            }
            foreach ($get_employee as $key => $value) {
                if($value->employee->status == 0){
                    unset($get_employee[$key]);
                }
            }
        }

        $years = calculate_log_ins()->groupBy('year')->select('year')->get();

        $record_user = Session::get('employee_code');
        if($employee_code == 'all'){
            $salary_list = $this->cGrantLog($year, $month, $record_user, $store_code);
        }else{
            $salary_list = $this->cGrantLog($year, $month, $record_user, $store_code, $employee_code);
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

        $paginator = new LengthAwarePaginator($item, $total, $perPage, $current_page, [
                'path' => Paginator::resolveCurrentPath(),  //注释2
                'pageName' => 'page',
        ]);
        $salary_list = $paginator->toArray()['data'];
        
        return view('job.salary_real', compact('year', 'years', 'month', 'store_code', 'store', 'salary_list', 'get_employee', 'employee_code', 'paginator'));
    }

   
    /**
     * [cStore 店铺搜索]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    public function cStore($store_code, $year, $month)
    {
        $zoneCode = "";
        $cityCode = "";
        if(substr($store_code, 0, 4) == 'qy00'){
            $store = store_new()->where('zone_code', $store_code)->where('status_del', 0)->paginate(10);
            $zoneCode= $store_code;
            $cityCode = store_zone_ins()->where('code', $zoneCode)->first();
            $cityCode = $cityCode->city_code;
        }else{
            $store = store_new()->where('status_del',0)->where('code', $store_code)->paginate(10);
            $zoneCode = $store[0]->zone_code;
        }        
        $zone = store_zone_ins()->where('status', 1)->get();
        $store = $this->storeTrans($store);
        $companyName =['name'=>'','code'=>''];
        $cityName = ['name'=>'','code'=>''];
        $parentStore = store_new()->where('status_del',0)->get();
        return view('store.store',compact('store','companyName','cityName','parentStore','zoneCode', 'cityCode', 'zone'));

    }
    /**
     * [cPort 端口费用搜索]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cPort($store_code, $year, $month, $employee_code)
    {
        if(strlen($month) == 1)
            $month = '0'.$month;
        $store = store_new()->where('status_del', 0)->where('type', 2)->get(); //限定只有分店
        $search_employee = $this->cGetSaleEmployee($store_code);
        if($employee_code != 'all'){
            $ports = staff_port_ins()
            ->where('store_code', $store_code)
            ->where('employee_code', $employee_code)
            ->where('status', 1)->where('start_year_month', '<=', $year.$month)->where('end_year_month', '>=', $year.$month)->with('employee', 'store')->paginate(10);
        }else{
            $ports = staff_port_ins()
            ->where('store_code', $store_code)
            ->where('status', 1)->where('start_year_month', '<=', $year.$month)->where('end_year_month', '>=', $year.$month)->with('employee', 'store')->paginate(10);
        }
        $pay_year_start = staff_port_ins()->where('store_code', $store_code)->where('status', 1)->min('year');
        $pay_year_end = staff_port_ins()->where('store_code', $store_code)->where('status', 1)->max('end_year_month');
        $pay_year_end = substr($pay_year_end, 0, 4);
        $ports = $this->cPortTrans($ports);
        return view('port.port', compact('year', 'month', 'store', 'store_code', 'pay_year_start','pay_year_end', 'ports', 'search_employee', 'employee_code'));
    }


    /**
     * [cReduceSalary 扣除工资搜索]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    protected function cReduceSalary($store_code, $year, $month)
    {   
        $store = store_new()->where('status_del', 0)->get(); //限定只有分店
        $reduce = salary_reduce_ins()->where('status', 1)
            ->where('store_code', $store_code)
            ->groupBy('employee_code')
            ->where('year', $year)->where('month', $month)
            ->with('employee', 'store')->paginate(10);
        foreach ($reduce as $key => $value) {
            $sum = salary_reduce_ins()->where('employee_code', $value->employee_code)->where('status', 1)->where('year', $value->year)->where('month', $value->month)->sum('amount');
            $value->sum_all = round($sum, 2);
        }
        $years = salary_reduce_ins()->groupBy('year')->select('year')->get();
        return view('job.salary_reduce', compact('year', 'month', 'store', 'store_code', 'years', 'reduce'));
    }

    /********************************************搜索*******************************************/
    /**
     * [cDelStoreCost 删除成本相应过户记录]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    protected function cDelStoreCost($id)
    {
        $find_tranfer = transfer_ins()->where('id', $id)->first();
        $find_store_cost = DB::table('cost_details')->where('tranfer_code', $find_tranfer->contract_number)->first();
        if($find_store_cost){
            $del_store_cost = DB::table('cost_details')->where('tranfer_code', $find_tranfer->contract_number)->delete();    
            return succ('ok');
        }else{
            return succ('ok');
        }
    }

    public function cCrontab($u, $p)
    {
        if($u == 'locqj' && $p == '159357') {
            $year = date('Y');
            $month = date('m');
            $update_code = $this->cGetUpdateCodeBySearch($year, $month);
            if($update_code != 0) {
                
            }else{
                return err('暂无数据');
            }
        }
    }

    /********************************************搜索季度*******************************************/

    /**
     * [cSeasonCostDatails 成本明细季度搜索]
     * @param  [type] $season [description]
     * @return [type]         [description]
     */
    protected function cSeasonCostDatails($season, $store_code, $year)
    {   
        if(Session::get('level_code') == 'dz' || Session::get('level_code') == 'zl'){
            $store = store_new()->where('status_del', 0)->where('code', $store_code)->where('code', '<>', 'hj001')->get();
        }else{
            $store = store_new()->where('status_del', 0)->where('code', '<>', 'hj001')->get(); 
        }
        $month = date('m');
        $season = $this->cUpdateCodeBySearchSeason($season);
        $years = cost_details_ins()->where('store_code', $store_code)->groupBy('year')->select('year')->get();
        
        if(!$season){
            $cost_details = array(); //无记录
        }else{
            $cost_details = cost_details_ins()
            ->whereIn('update_code', $season)
            ->where('store_code', $store_code)->with('store')->paginate(10);
        }
        
        return view('store.store_cost_detail', compact('store', 'cost_details', 'years', 'year', 'month', 'store_code'));
    }

    /**
     * [cSeasonTransfer 过户记录季度搜索]
     * @param  [type] $season [description]
     * @return [type]         [description]
     */
    protected function cSeasonTransfer($season, $store_code, $year)
    {   
        
        $month = date('m');
        $months = $this->cSeasonReturnMonth($season);
        $transfer = transfer_ins()
            ->where('store_code', $store_code)
            ->where('status_del', 0)
            ->where('year', $year)->whereIn('month', $months)
            ->with('employee')->with('store')->with('contract')
            ->paginate(10);

        
        $guohus = employee_position()
            ->where('position_code', 'gh01')
            ->with('position')->with('employee')->get(); //查找过户专员
        foreach ($guohus as $key => $value) {
            if($value->employee->status == 0){
                unset($guohus[$key]);
            }
        }

        $contract_count = $this->cGetContract($store_code);
        $contract_count = count($contract_count['data']);
        $store = store_new()->where('status_del', 0)->where('type', 2)->get();
        $years = transfer_ins()->where('status_del', 0)->groupBy('year')->select('year')->get();
        
        return view('transfer.transfer_record', 
            compact('transfer', 'store', 'contract_count', 'guohus', 'store_code', 'years', 'year', 'month'));
    }

    /**
     * [cSeasonSalaryDatails 基本工资季度搜索]
     * @param  [type] $season [description]
     * @return [type]         [description]
     */
    protected function cSeasonSalaryDatails($season, $store_code, $year)
    {
        
        if(in_array(Session::get('level_code'), ['dz', 'zl', 'xs'])){
            $store = store_new()->where('status_del', 0)->where('code', $store_code)->get();
        }else{
            $store = store_new()->where('status_del', 0)->get(); 
        }
        $month = date('m');
        $season = $this->cUpdateCodeBySearchSeason($season);
        $years = salary_details_ins()->where('store_code', $store_code)->groupBy('year')->select('year')->get();
        
        if(!$season){
            $salary_details = array();//无记录
        }else{
            $salary_details = salary_details_ins()
                ->whereIn('update_code', $season)
                ->where('store_code', $store_code)->with('store')->with('employee')->paginate(10);
            $salary_details = $this->cGetSalaryDetailPosition($salary_details);
        }
        return view('job.salary_details', compact('store', 'salary_details', 'years', 'year', 'month', 'store_code'));   
    }


}
