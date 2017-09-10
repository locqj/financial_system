<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

date_default_timezone_set('Asia/Shanghai');

class StoreCompanyController extends Controller
{   
    
   /**
	 * [index 公司首页]
	 * @return [type] [description]
	 */
    public function index(){
    	$company = company_new()->paginate(10);
    	dd($company);
    	// if(!$company)
    	// 	return err('查询为空');
    	// return arrayChange( 1, 'success',$company);
    }

    public function create(){

    }

    /**
     * [company 录入城市]
     * @param  Request $Request [description]
     * @return [json]           [返回状态]
     */
    public function store(Request $Request){
    	if(!rq('code'))
    		return err('公司编号不能为空');
    	if(company_new()->where('code',rq('code'))->exists())
    		return err('公司编号已存在');
    	if(!rq('name'))
    		return err('公司名称不能为空');
    	$company = company_new();
    	$company->code = rq('code');
    	$company->name = rq('name');
    	$company->addr = rq('addr');
    	$company->remark = rq('remark');
        date_default_timezone_set('Asia/Shanghai');
    	$company->created_at = date('Y-m-d H:i:s');
    	if($company->save())
    		return suc('添加成功');
    	else
    		return err('添加失败');


    }
    
    /**
     * [show 单个城市api]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id){
    	$company = company_new()->where('id',$id)->first();
    	if($company)
    		return arrayChange(1, 'success', $company);
    	return err('查询为空');
    }

    /**
     * [edit 编辑城市api]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id){
    	$company = company_new()->where('id',$id)->first();
		$company_exist = company_new()->where('code',rq('code'))->first();
    	if($company_exist && $company->id != $company_exist->id)
    		return err('区号号存在');
    	if(!rq('name'))
    		return err('名称不能为空');
    	$company->code = rq('code');
    	$company->name = rq('name');
    	$company->addr = rq('addr');
    	$company->remark = rq('remark');
    	if($company->save())
    		return suc('修改成功');
    	else
    		return err('修改失败');
    }

    public function update(){
    	//
    }

    /**
     * [destroy 删除城市api 暂不用]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id){
    	if(company_new()->where('id',$id)->update(['status'=>0]))
    		return suc('删除成功');
    	return err('删除失败');
    }}
