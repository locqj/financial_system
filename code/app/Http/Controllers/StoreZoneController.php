<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

date_default_timezone_set('Asia/Shanghai');
class StoreZoneController extends Controller
{   

    /**
     * [index 内容展示]
     * @return [type] [description]
     */
    public function index($city_code)
    {
        $store = store_zone_ins()->where('city_code', $city_code)->where('status', 1)->paginate(10);
        $cityCode = $city_code;
        return view('store.zone',compact('store', 'cityCode'));
    }



    /**
     * [cAddSub 添加提交]
     * @return [type] [description]
     */
    public function cAddSub()
    {
        $zone = store_zone_ins();
        $zone->name = rq('name');
        $zone->code = $this->cAutoZoneCode();
        $zone->status = 1;
        $zone->created_at = date('Y-m-d H:i:s');
        $zone->remark = rq('remark');
        $zone->addr = rq('addr');
        $zone->city_code = rq('city_code');
        $code = $zone->code;
        if($zone->save()){
            $this->addQyPosition($code); //添加区域职位
            return succ('ok');
        }
    }
    /**
     * [cUpdateSub 更新提交]
     * @return [type] [description]
     */
    public function cUpdateSub($id)
    {
        $zone = store_zone_ins()->find($id);
        $zone->name = rq('name');
        $zone->addr = rq('addr');
        $zone->remark = rq('remark');
        if($zone->save()){
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
        $zone = store_zone_ins()->find($id);
        $zone->status = 0;
        if($zone->save()){
            return succ('ok');
        }
    }
    /**
     * [cFindZone 找zone信息]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function cFindZone($id)
    {
        $zone = store_zone_ins()->find($id);
        return suc($zone);
    }
    /**
     * [cAutoZoneCode 自动生成code]
     * @return [type] [description]
     */
    protected function cAutoZoneCode()
    {
        $get_count = store_zone_ins()->count();
        $get_count = $get_count + 1;
        return 'qy00T'.$get_count;
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
