<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


date_default_timezone_set('Asia/Shanghai');

class StoreStoreController extends Controller
{	
	/**
	 * [index 店铺首页api]
	 * @return [type] [description]
	 */
    public function index(){
    	$store = store_new()->where('status_del',0)->paginate(10);
        $store = $this->storeTrans($store);
        $companyName =['name'=>'','code'=>''];
        $cityName = ['name'=>'','code'=>''];
        $parentStore = store_new()->where('status_del',0)->get();
    	return view('store.store',compact('store','companyName','cityName','parentStore'));
    }



    /**
     * [company_key 公司为关键词查找]
     * @param  [type] $company_code [description]
     * @return [type]               [description]
     */
    public function company_key($company_code){
        if($company_code == 'allCompany'){
            $store = store_new()->where('status_del',0)->paginate(10);
            $companyName = ['name'=>'','code'=>''];
        }
        else{
            $store = store_new()->where('status_del',0)->where('company_code',$company_code)->paginate(10);
            $companyName = company_new()->where('code',$company_code)->first();
            $companyName = ['name'=>$companyName->name,'code'=>$companyName->code];
        }
        $store = $this->storeTrans($store);
        $cityName = ['name'=>'','code'=>''];
        return view('store.store',compact('store','companyName','cityName'));
    }

    /**
     * [name_key 店铺名为关键词查找]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function name_key($name){
        if($name == 'allName')
            $store = store_new()->where('status_del',0)->paginate(10);
        else
            $store = store_new()->where('status_del',0)->where('name','like','%'.$name.'%')->paginate(10);
        $store = $this->storeTrans($store);
        $companyName =['name'=>'','code'=>''];
        $cityName = ['name'=>'','code'=>''];
        return view('store.store',compact('store','companyName','cityName'));
    }

    /**
     * [city_key 城市为关键词查找]
     * @param  [type] $city_zone [description]
     * @return [type]            [description]
     */
    public function city_key($city_zone){
        if($city_zone == 'allCity'){
            $store = store_new()->where('status_del',0)->paginate(10);
            $cityName = ['name'=>'','code'=>''];
        }else{
            $store = store_new()->where('status_del',0)->where('city_zone',$city_zone)->paginate(10);
            $cityName = city_new()->where('zone',$city_zone)->first();
            $cityName = ['name'=>$cityName->name,'code'=>$cityName->zone];
        }
        $store = $this->storeTrans($store);
        $companyName = ['name'=>'','code'=>''];
        return view('store.store',compact('store','companyName','cityName'));
    }

    /**
     * [create 创建店铺页面]
     * @return [type] [description]
     */
    public function create(){
        // $store = store_new()->where('status_del',0)->where('type',1)->get();
        // $company = company_new()->where('status', 1)->get();
        // $city = city_new()->get();
        // return view('store.store_create', compact('store','company','city'));
    }

    /**
     * [store 新添店铺]
     * @param  Request $Request [description]
     * @return [json]           [返回状态]
     */
    public function store(Request $request){
        if(rq('id')){
            $store = store_new()->where('id',rq('id'))->first();
            // $store_exist = store_new()->where('code',rq('code'))->first();
            // if($store_exist && $store->id != $store_exist->id)
            //     return err('店铺编号存在');
            /*每月1、2、3号才可调整*/
            if($store->zone_code != rq('zone_code') && !in_array(date('d'), ['1', '2', '3', '01', '02', '03', '18'])){
                return err('调整区域必须在每月1、2、3号！');
        }
            $store->updated_at = date('Y-m-d H:i:s');
            // $store->code = rq('code');
        }else{
            $store = store_new();
            // if(store_new()->where('code',rq('code'))->exists())
            //     return err('店铺号已存在');
            $store->created_at = date('Y-m-d H:i:s');
            //生成店铺编号
            $store_count = store_new()->count()+1;
            $store_count_length = strlen($store_count);
            for ($i=0; $i < 3 - $store_count_length; $i++) { 
                $store_count = '0'.$store_count;
            }
            $store->code = 'hj'.$store_count;
            //新添五个职位
            
            
            $position_arr[0] = ['name'=>'店长','code'=>'dz01','level'=>'1','position_tag'=>'店长'];
            $position_arr[1] = ['name'=>'店长助理','code'=>'zl01','level'=>'1','position_tag'=>'高级置业顾问'];
            $position_arr[2] = ['name'=>'店长助理','code'=>'zl02','level'=>'2','position_tag'=>'主任置业顾问'];
            $position_arr[3] = ['name'=>'店长助理','code'=>'zl03','level'=>'3','position_tag'=>'金牌置业顾问'];
            $position_arr[4] = ['name'=>'销售','code'=>'xs01','level'=>'1','position_tag'=>'见习置业顾问'];
            $position_arr[5] = ['name'=>'销售','code'=>'xs02','level'=>'2','position_tag'=>'置业顾问'];
            $position_arr[6] = ['name'=>'销售','code'=>'xs03','level'=>'3','position_tag'=>'高级置业顾问'];
            $position_arr[7] = ['name'=>'销售','code'=>'xs04','level'=>'4','position_tag'=>'主任置业顾问'];
            $position_arr[8] = ['name'=>'销售','code'=>'xs05','level'=>'5','position_tag'=>'金牌置业顾问'];
            foreach ($position_arr as $key => $value) {
                $position = position_ins();
                $position->store_code = $store->code;
                $position->salary = '1000';
                $position->level = $value['level'];
                $position->name = $value['name'];
                $position->code = $value['code'];
                $position->position_tag = $value['position_tag'];

                if(!$position->save()){
                    return err('添加失败！');
                }
            }
        }
    	$store->name = rq('name');
    	$store->addr = rq('addr');
    	$store->type = rq('type');
        // $store->parent_code = rq('parent_code');     //二级店铺的父级
        $store->zone_code = rq('zone_code');
        $zone = store_zone_ins()->where('code', rq('zone_code'))->first();
    	$store->city_code = $zone->city_code;
    	$store->company_code = '888';
    	if($store->save())
    		return suc((rq('id'))?'修改成功':'添加成功');
    	else
    		return err((rq('id'))?'修改失败':'添加失败');


    }

    /**
     * [show 单个店铺信息]
     * @param  [type] $id [description]
     * @return [json]     [返回状态及店铺信息]
     */
    public function show($id){
    	$store = store_new()->where('code',$id)->first();
    	if($store)
    		return arrayChange(1, 'success', $store);
    	return err('查询为空');
    }

    /**
     * [edit 店铺编辑页面]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id){
    	$store = store_new()->where('id',$id)->first();
        if($store->city_zone){
            $city = city_new()->where('zone',$store->city_zone)->first();
            $store->city_name = $city->name;
        }
        if($store->company_code){
            $company = company_new()->where('code',$store->company_code)->first();
            $store->company_name = $company->name;
        }
        if($store->parent_code !=0){
            $parent = store_new()->where('code',$store->parent_code)->first();
            $store->parent_name = $parent->name;
        }
        $store->type_name = ($store->type == 1)?'总店':'分店';
        $store_list = store_new()->where('status_del',0)->where('type',1)->get();
        $company_list = company_new()->where('status', 1)->get();
        $city_list = city_new()->get();
        return view('store.store_edit',compact('store','store_list','city_list','company_list'));
    }

    public function update(){
    	//
    }

    /**
     * [destroy 删除店铺信息]
     * @param  [type] $id [description]
     * @return [json]     [返回状态]
     */
    public function destroy($id){
    	if(store_new()->where('id',$id)->update(['status_del'=>1]))
    		return suc('删除成功');
    	return err('删除失败');
    }

    /**
     * 发送post请求
     */
    public function postSend($url, $data)
    {
        //创建初始化curl
        $ch = curl_init($url);
        //设置请求头信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        //执行
        $res = curl_exec($ch); 
        curl_close($ch);
        return $res;
    }
}
