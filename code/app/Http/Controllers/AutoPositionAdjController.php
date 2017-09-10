<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AutoPositionAdjController extends Controller
{
    
    /**
     * crontab !!!!!!!! 三月执行一次
     * 自动调整职位
     */
    public function cCronTab($u, $p)
    {   
        /*验证*/
        if($u == 'locqj' && $p == '159753') {
            $get_season_update_code = $this->cGetSeasonUpdateCode();
            $get_season_bouns = $this->cGetSeasonBouns($get_season_update_code); //获取销售员工的季度提成总和
            foreach ($get_season_bouns as $key => $value) {
                if($value['position_code'] != 'xs01'){ /*除见习以外---每三月执行一次*/
                    $this->cPositionAdjustment($value['code'], $value['position_code'], $value['sum']);
                }
                //降职
                // if(substr($value['position_code'], 0, 2) == 'xs' && $value['position_code'] != 'xs01' && $value['position_code'] != 'xs02')
                //     $this->cSetNewPosition($value);
                // else if(substr($value['position_code'], 0, 2) == 'zl' && $value['position_code'] != 'zl01')
                //     $this->cSetNewPositionZl($value);
            }

            $this->cBackupMysql();
            return 'finish';
        }
    }

    /**
     * crontab !!!!!!!! 三月执行一次
     * 自动调整职位
     */
    public function cCronTabJianxi($u, $p)
    {   
        /*验证*/
        if($u == 'locqj' && $p == '159753') {
            $get_season_update_code = $this->cGetSeasonUpdateCode();
            $get_season_bouns = $this->cGetSeasonBouns($get_season_update_code); //获取销售员工的季度提成总和
            foreach ($get_season_bouns as $key => $value) {
                if($value['position_code'] === 'xs01'){  /*见习---每月执行一次*/
                    $this->cPositionAdjustmentJianxi($value['code'], $value['position_code'], $value['sum'], $value['entry_time']);
                }
            }

            $this->cBackupMysql();
            return 'finish';
        }
    }

    /**
     * 
     */

    /**
     * 备份数据库
     */
    public function cBackupMysql(){
        $mysqlbak_url = public_path().'/backupMysql/backup_mysql.sh';
        system($mysqlbak_url);
    }
    /*
    * 获取对应员工的季度提成
    */
    protected function cGetSeasonBouns($update_code)
    {   
        $get_xs =  $this->cGetXs(); //获取当前存在销售员工 
        $amount = array();
        /*遍历所有员工*/
        foreach ($get_xs as $key => $value) {
            $sum = 0;
            /*遍历该季度对应的结算月份*/
            foreach ($update_code as $k => $v) {
                
                $get_bouns = commission_details_new()->where('employee_code', $value->code)->where('update_code', $v)->first();
                if($get_bouns){
                	$sum_child = $get_bouns->amount + $get_bouns->second_amount + $get_bouns->rent_amount;
                    $sum += $sum_child;
                } else {
                    $sum += 0;
                }
            }
            $amount[$key]['name'] = $value->name;
            $amount[$key]['code'] = $value->code;
            $amount[$key]['position_code'] = $value->employee_position->position_code;
            $amount[$key]['sum'] = $sum;
            $amount[$key]['entry_time'] = $value->entry_time;
        }
        return array_values($amount); //取消key
    }

    /**
     * 获取当前存在销售员工
     */
    protected function cGetXs()
    {
        /*找销售*/
            $get_xs = employee_ins()->where('status', 1)->with('employee_position')->get();
            foreach ($get_xs as $key => $value) {
                if(substr($value->employee_position->position_code, 0, 2) != 'xs' && substr($value->employee_position->position_code, 0, 2) != 'zl') {
                    unset($get_xs[$key]);
                }
            }
            return $get_xs;
    }

    /**
     * 销售或助理升职调整
     * @param  [var] $employee_code [员工编号]
     * @param  [var] $position_code [职位编号]
     * @param  [int] $amount_all [佣金总和]
     */
    protected function cPositionAdjustment($employee_code, $position_code, $amount_all){
        $rule_up = bonus_rule_ins()->where('status_del', 0)->where('rule_key', 10)->whereNotIn('position_code', ['xs01', 'xs02'])->orderBy('bottom', 'desc')->get();
        $position_code_old = $position_code;
        if(substr($position_code, 0, 2) == 'xs'){
            foreach ($rule_up as $key => $value) {
                if($amount_all >= $value->bottom && $key == 0){
                    $position_code = 'xs05';
                    if($position_code != $position_code_old){
                        employee_position()->where('employee_code', $employee_code)->update(['position_code' => $position_code]);
                    }
                    return 1;
                }else if($amount_all >= $value->bottom && $key >0 &&$amount_all < $rule_up[$key-1]->bottom){
                    $level = substr($value->position_code, 3);
                    $position_code = 'xs0'.$level;
                    if($position_code != $position_code_old){
                        employee_position()->where('employee_code', $employee_code)->update(['position_code' => $position_code]);
                    }
                    return 1;
                }
            }
            $position_code = 'xs02';
            if($position_code != $position_code_old){
                employee_position()->where('employee_code', $employee_code)->update(['position_code' => $position_code]);
            }
        }else if(substr($position_code, 0, 2) == 'zl'){/*助理*/
                if($amount_all >= $rule_up[0]->bottom){
                    $position_code = 'zl03';
                }else if($amount_all >= $rule_up[1]->bottom ){
                    $position_code = 'zl02';
                }else{
                    $position_code = 'zl01';
                }
                if($position_code != $position_code_old){
                    employee_position()->where('employee_code', $employee_code)->update(['position_code' => $position_code]);
                }
                return 1;
        } 
        return 0;
    }

    /**
     * 见习职位调整--每月执行一次
     * @param  [type] $employee_code [description]
     * @param  [type] $position_code [description]
     * @param  [type] $amount_all    [description]
     * @param  [type] $entry_time    [description]
     * @return [type]                [description]
     */
    protected function cPositionAdjustmentJianxi($employee_code, $position_code, $amount_all, $entry_time){
        $rule = bonus_rule_ins()->where('status_del', 0)->where('position_code', 'xs02')->first();
        $entry_date = explode('-', $entry_time);
        $months = 0;
        if(date('Y') >= $entry_date[0]){
            $months = (date('Y') - $entry_date[0]) * 12;
            $months += date('m') - $entry_date[1] -1;
            if(date('m') > $entry_date[1] && date('d') >= $entry_date[2]){
                $months++;
            }
        }
        if($months >= 3 || $amount_all >= $rule->bottom){
                employee_position()->where('employee_code', $employee_code)->update(['position_code' => 'xs02']);
                return 1;
        }
    }

    /**
     * 助理职位降职
     */
    // protected function cSetNewPositionZl($employee){
    //     //降级
    //     $level = substr($employee['position_code'], 3);
    //     $rule_down = bonus_rule_ins()->where('status_del', 0)->where('position_code', 'xs0'.($level + 2))->first();
    //     if($employee['sum'] < $rule_down->bottom){
    //         $get_index = substr($employee['position_code'], 3) - 1;
    //         $employee['position_code'] = 'zl0'.$get_index;
    //         if($employee['position_code'] == 'zl02'){
    //             $rule_down = bonus_rule_ins()->where('status_del', 0)->where('position_code', 'xs04')->first();
    //             if($employee['sum'] < $rule_down->bottom){
    //                 $employee['position_code'] = 'zl01';
    //             }
    //         }
    //         $down_level = employee_position()->where('employee_code', $employee['code'])->update(['position_code' => $employee['position_code']]);
    //         return 0;
    //     }


    // }

    // /**
    //  * 销售职位降职
    //  */
    // protected function cSetNewPosition($employee)
    // {	
    //     //降级
    //     $rule_down = bonus_rule_ins()->where('status_del', 0)->where('rule_key', 10)->where('position_code', '<>', 'xs01')->orderBy('bottom', 'desc')->get();
    //     foreach ($rule_down as $key => $value) {
    //         if(substr($position_code, 0, 2) == 'xs' && substr($value->position_code, 3) > $level){
    //             if($amount_all >= $value->bottom){
    //                 $level = substr($value->position_code, 3);
    //                 $position_code = 'xs0'.$level;
    //                 employee_position()->where('employee_code', $employee_code)->update(['position_code' => $position_code]);
    //                 return 1;
    //             }
    //         }else if(substr($position_code, 0, 2) == 'zl' && substr($value->position_code, 3) > ($level + 2)){
    //             if($amount_all >= $value->bottom){
    //                 $level = substr($value->position_code, 3) - 2;
    //                 $position_code = 'zl0'.$level;
    //                 employee_position()->where('employee_code', $employee_code)->update(['position_code' => $position_code]);
    //                 return 1;
    //             }
    //         } 
    //     }

    //     if($employee['sum'] < $rule_down->bottom){
    //         $get_index = substr($employee['position_code'], 3) - 1;
    //         $employee['position_code'] = 'xs0'.$get_index;
    //         $down_level = employee_position()->where('employee_code', $employee['code'])->update(['position_code' => $employee['position_code']]);
    //         return 0;
    //     }

    // }

}
