<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

date_default_timezone_set('Asia/Shanghai');
class StoreCityController extends Controller
{   

    /**
     * [index 内容展示]
     * @return [type] [description]
     */
    public function index()
    {
        $store = city_new()->where('status_del', 0)->paginate(10);
        $companyName =['name'=>'','code'=>''];
        $cityName = ['name'=>'','code'=>''];
        $parentStore = store_new()->where('status_del',0)->where('type',1)->get();
        return view('store.store_city',compact('store','companyName','cityName','parentStore'));
    }



    /**
     * [cAddSub 添加提交]
     * @return [type] [description]
     */
    public function cAddSub()
    {
        $city = city_new();
        $city->name = rq('name');
        $city->code = $this->cAutoCityCode();
        $city->created_at = date('Y-m-d H:i:s');
        $city->remark = rq('remark');
        if($city->save()){
            return succ('ok');
        }
    }
    /**
     * [cUpdateSub 更新提交]
     * @return [type] [description]
     */
    public function cUpdateSub($id)
    {
        $city = city_new()->find($id);
        $city->name = rq('name');
        $city->remark = rq('remark');
        if($city->save()){
            return succ('ok');
        }
    }
    /**
     * [cDel 删除]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function cDel($id)
    {
        $city = city_new()->find($id);
        $city->status_del = 1;
        if($city->save()){
            return succ('ok');
        }
    }
    /**
     * [cFindcity 找city信息]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function cFindCity($id)
    {
        $city = city_new()->find($id);
        return suc($city);
    }
    /**
     * [cAutocityCode 自动生成code]
     * @return [type] [description]
     */
    protected function cAutoCityCode()
    {
        $get_count = city_new()->count();
        $get_count = $get_count + 1;
        return 'cs00T'.$get_count;
    }
    /**
     * [addQyPosition 添加相应的职位（区域经理）]
     * @param [type] $code [description]
     */
    protected function addQyPosition($code)
    {
        $add_position = position_ins();
        $add_position->store_code = $code;
        $add_position->name = '区域经理';
        $add_position->level = 1;
        $add_position->salary = 1000;
        $add_position->status_del = 0;
        $add_position->code = 'qy01';
        $add_position->position_tag = '区域经理';
        $add_position->save();
    }
}
