<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

date_default_timezone_set('Asia/Shanghai');

class StaffPortController extends Controller
{   

    public function index()
    {   
        if(Session::get('level_code') == 'dz' || Session::get('level_code') == 'zl'){
            $store_code = Session::get('store_code');
            $store = store_new()->where('status_del', 0)->where('type', 2)->where('code', $store_code)->get(); 
        }else{
            $store = store_new()->where('status_del', 0)->where('type', 2)->get(); 
            $store_code = 'all';
        }
        $year = date('Y');
        $month = date('m');
        $years = array();
        $ports = staff_port_ins()->where('status', 1)->where('year', $year)->where('month', $month)->with('employee', 'store')->paginate(10);
        foreach ($ports as $key => $value) {
            $search_month = json_decode($value->pay_month);
            $sum = 0 ;
            foreach ($search_month as $k => $v) {
                $years[$k] = $v->year;
                if($v->year == $year && $v->month == $month) {
                    $sum ++;
                }
            }
            
            if($sum == 0) {
                unset($ports[$key]);
            }
        }
        
        $years = array_merge(array_unique((array)$years));
        $ports = $this->cPortTrans($ports);
        return view('port.port', compact('year', 'month', 'store', 'store_code', 'years', 'ports'));
    }


    /**
     * 修改端口
     */
    public function cPortChange(){
        $port = staff_port_ins()->where('id', rq('id'))->first();
        $port->store_code = rq('store_code');
        $port->employee_code = rq('employee_code');
        if(rq('employee_code') == '0'){
            $port->is_personal = 0;
        }else{
            $port->is_personal = rq('is_personal');
        }
        if($port->save())
            return suc('修改成功');
        else
            return err('修改失败');
    }

    /**
     * [cSub 更新和添加提交]
     * @return [type] [description]
     */
    public function cSub()
    {   
        /*id == all 为添加*/
            $port = staff_port_ins();
            $date_explode = explode('-', rq('sign_date')); //切割时间
            $length = rq('period');
            $start_year = $date_explode[0];
            $start_month = $date_explode[1];
            $unit = (int)rq('amount') / (int)$length;
            $port->port_number = rq('port_number');
            // $port->employee_code = rq('employee_code');
            $port->store_code = rq('store_code');
            $port->remark = rq('remark');
            $port->amount = rq('amount');
            $port->status = 1;
            $port->port_place = rq('port_place');
            $port->unit = round($unit, 2);
            $port->year =  $start_year;
            $port->month =  $start_month;
            $port->start_year_month = $start_year.$start_month;
            $pay_month_cal = $this->cCalculatePayMonth($start_year, $start_month, $length);
            $port->pay_month = $pay_month_cal['pay_month'];
            $port->end_year_month = $pay_month_cal['end_year_month'];
            $port->length = $length;
            if($port->save()){
                return succ('ok');
            }
            

    }
    /**
     * [cCalculatePayMonth 计算偿还月份]
     * @param  [type] $start_year  [description]
     * @param  [type] $start_month [description]
     * @param  [type] $length      [description]
     * @return [type]              [description]
     */
    public function cCalculatePayMonth($start_year, $start_month, $length)
    {
        if($start_month + $length > 13){  //先计算当年剩余月份
                for ($i=0; $i <= 12 - $start_month ; $i++) { 
                    $pay_month[$i] = array(
                        'year'=>(int)$start_year,
                        'month'=>(int)($start_month+$i)
                        );
                }
                                              //剩余依次自增
                $leng_left = ($length + $start_month) -13 ;
                $count_year = 1;
                while($leng_left > 0 ){
                        $count = 1;
                        while ( $count <= 12 && $leng_left > 0 ) {
                            $pay_month[$i]['year'] = (int)($start_year + $count_year);
                            $pay_month[$i]['month'] = (int)$count++;
                            $i++;
                            $leng_left--;
                        }
                        $count_year++;
                    }
            if($count < 11)
                $end_month = '0'.($count - 1);
            else
                $end_month = ($count -1);
            $end_year_month = ($start_year + $count_year - 1).$end_month;
            }else{                             //未超过所在年份的自增
                $i = 0;
                while ($length > 0) {
                    $pay_month[$i] = array(
                        'year' => (int)$start_year,
                        'month' => (int)$start_month ++
                        );
                    $length--;
                    $i++;
                }
             if($start_month < 11)
                 $end_month = '0'.($start_month - 1);
            else
                $end_month = ($start_month -1);
            $end_year_month = ($start_year).$end_month;
            }
            $pay_month = json_encode($pay_month);
        return ['end_year_month'=>$end_year_month,'pay_month'=>$pay_month];
    }



    
}
