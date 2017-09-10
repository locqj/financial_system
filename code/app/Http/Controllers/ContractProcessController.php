<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

date_default_timezone_set('Asia/Shanghai');

class ContractProcessController extends Controller
{
	/**
	 * 存储动态
	 * @return [type] [description]
	 */
    public function cStore(){
    	if(contract_process_new()->where('contract_number', rq('contract_number'))->where('type',rq('type'))->where('status_del', 0)->exists())
    		return err('已'.$this->cGetTypeName(rq('type')));
    	$process = contract_process_new();
    	$process->contract_number = rq('contract_number');
    	$process->type = rq('type');
    	$process->remark = rq('remark');
    	$process->created_at = date('Y-m-d H:i:s');
    	if($process->save()){
    		$process_return = contract_process_new()->where('contract_number', rq('contract_number'))->where('type',rq('type'))->where('status_del', 0)->first();
    		$process_return->type_name = $this->cGetTypeName(rq('type'));
    		return suc($process_return);
    	}
    	else
    		return err('添加失败！');
    }

    /**
     * 获取动态类型
     */
    protected function cGetTypeName($type){
    	switch ($type) {
    			case '1':
    				return '网签';
    				break;
    			case '2':
    				return '贷款';
    				break;
    			case '3':
    				return '交税';
    				break;
    		}
    }
    /**
     * 获取签单动态
     */
    public function cShow(){
    	$process = contract_process_new()->where('contract_number', rq('contract_number'))->where('status_del', 0)->get();
    	foreach ($process as $key => $value) {
    		$process[$key]->type_name = $this->cGetTypeName($value->type);
    	}
    	$trans = transfer_ins()->where('contract_number', rq('contract_number'))->where('status_del', 0)->first();
    	if(!isset($key))
    		$key = -1;
    	if($trans){
    		$process[$key+1] = $trans;
    		$process[$key+1]->type_name = '过户';
    		$process[$key+1]->type = 'trans';
    	}

    	return suc($process);
    }

    /**
     * 编辑动态
     */
    public function cEdit(){
        $process = contract_process_new()->where('id', rq('id'))->first();
        $process->remark = rq('remark');
        if($process->save()){
            return suc('修改成功！');
        }else{
            return err('修改失败！');
        }
    }
    /**
     * 删除动态
     */
    public function cDel(){
    	if(contract_process_new()->where('id', rq('id'))->update(['status_del'=>1])){
    		return suc('删除成功！');
    	}else{
    		err('删除失败！');
    	}
    }


}
