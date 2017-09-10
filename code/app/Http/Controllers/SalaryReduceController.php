<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

use Excel;

date_default_timezone_set('Asia/Shanghai');

class SalaryReduceController extends Controller
{	
	/**
	 * [index 内容展示]
	 * @return [type] [description]
	 */
    public function index()
    {
       
        if(Session::get('level_code') == 'dz' || Session::get('level_code') == 'zl'){
            $store_code = Session::get('store_code');
            $store = store_new()->where('status_del', 0)->where('code', $store_code)->get(); 
        }else{
            $store = store_new()->where('status_del', 0)->get(); 
            $store_code = store_new()->where('status_del', 0)->first();
            if($store_code == null){
                $store_code = null;
            }else{
                $store_code = $store_code->code;
            }
        }
        $year = date('Y');
        $month = date('m');
        $reduce = salary_reduce_ins()->where('status', 1)
        	->where('store_code', $store_code)->with('employee', 'store')->groupBy('employee_code')
            ->where('year', $year)->where('month', $month)->groupBy('employee_code')->paginate(10);
        foreach ($reduce as $key => $value) {
            $sum = salary_reduce_ins()->where('employee_code', $value->employee_code)->where('year', $value->year)->where('status', 1)->where('month', $value->month)->sum('amount');
        	$value->sum_all = round($sum, 2);
        }
        $years = salary_reduce_ins()->groupBy('year')->select('year')->get();
        return view('job.salary_reduce', compact('year', 'month', 'store', 'store_code', 'years', 'reduce'));
    
    }

    /**
     * [store 提交]
     * @return [type] [description]
     */
    public function store()
    {	
    	$date_explode = explode('-', rq('sign_date')); //切割时间
    	$reduce = salary_reduce_ins();
    	$reduce->employee_code = rq('employee_code');
    	$reduce->store_code = rq('store_code');
    	$reduce->category = rq('category');
    	$reduce->amount = rq('amount');
    	$reduce->record_user = session('employee_code');
    	$reduce->status = 1;
    	$reduce->created_at = date("Y-m-d H:i:s");
    	$reduce->year =  $date_explode[0];
        $reduce->month =  $date_explode[1];
        $reduce->day =  $date_explode[2];
        if($reduce->save()){
        	return succ('ok');
        }else{
        	return err('网络错误!');
        }


    }

    /**
     * [cGetDetails 获取员工扣钱详情]
     * @param  [type] $employee_code [description]
     * @param  [type] $year          [description]
     * @param  [type] $month         [description]
     * @return [type]                [description]
     */
    public function cGetDetails($employee_code, $year, $month)
    {
    	$reduce = salary_reduce_ins()
    		->where('employee_code', $employee_code)
    		->where('year', $year)->where('month', $month)->with('employee', 'store')->where('status', 1)->get();
    	return suc($reduce);
    }


    /**
     * 导入excel
     */
    public function cImport(Request $request){
        $file = $request->file('excel');
        $result = $this->cExcelToArray($file);
        if($result['status']){
            $excel = $result['excel'];
            $count = 0;
            foreach ($excel as $key => $value) {
                if($value[1] == '')
                    break;
                if($value[4] == '' || $value[2] == '' || $value[8] == '' || $value[9] == ''||$value[6] == '' || $value[7] == ''){
                    continue;
                }else if(!is_float($value[9]) || !is_numeric($value[7]) || !is_numeric($value[6]) || $value[6] < 1000 ){
                    continue;
                }
                $reduce = salary_reduce_ins();
                $reduce->employee_code = $value[4];
                $reduce->store_code = $value[2];
                $reduce->category = $value[8];
                $reduce->amount = $value[9];
                $reduce->record_user = session('employee_code');
                $reduce->status = 1;
                $reduce->created_at = date("Y-m-d H:i:s");
                $reduce->year =  $value[6];
                $reduce->month =  $value[7];
                $reduce->day =  0;
                $reduce->save();
                $count++;
            }
            return succ('成功：'.$count.'条记录，失败：'.(count($excel)-$count).'条记录');
        }else{
            return err($result['msg']);
        }
    }

    /**
     * [excelToArray excel转化为数组以及跳转提示]
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    private function cExcelToArray($file){
            $tmpName    = $file->getFileName(); //文件临时名称
            $entension  = $file->getClientOriginalExtension();//文件后缀
            if(substr($entension, 0,2) == 'xl'){
                $name = $tmpName.'.'.$entension;
                $path = $file->move('uploads/excel', $name);//移动文件到指定目录
                $movepath = 'uploads/excel/'.$name;
                $excel =Excel::load($movepath, function($reader) {
                })->toArray();
                $result['excel'] = $excel;   //转化数组
                $result['originalName'] = substr($file->getClientOriginalName(), 0,stripos($file->getClientOriginalName(), '.xl')); //获取文件名
                $result['status'] = 1;
            }else{
                $result['status'] = 0;
                $result['msg'] = '请选择正确的文件类型';
            }
        return $result;
    }
}
