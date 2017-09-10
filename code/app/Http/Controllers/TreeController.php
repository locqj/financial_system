<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TreeController extends Controller
{   

    /**
     * [cTreeData 树形遍历的结构 （暂时不考虑发展下线的问题）]
     * @return [type] [description]
     */
    public function cTreeData(){
        // $tree = store_zone_ins()->where('status', 1)->with('store')->get();
        // $store_zong = store_new()->where('status_del', 0)->where('code', 'hj001')->get();
        // foreach ($store_zong as $k => $v) {
        //     $data[$k]['name'] = $v->name;
        //     $data[$k]['value'] = $v->code;
        //     foreach ($tree as $key => $value) {
        //         $data[$k]['children'][$key]['name'] = $value->name;
        //         $data[$k]['children'][$key]['value'] = $value->code;
        //         $store_fen = store_new()->where('status_del', 0)->where('zone_code', $value->code)->get(); //剔除不存在的店铺
        //         foreach ($store_fen as $key_1 => $value_1) {
        //             if($value_1->status_del == 0){
        //                 $data[$k]['children'][$key]['children'][$key_1]['name'] = $value_1->name;
        //                 $data[$k]['children'][$key]['children'][$key_1]['value'] = $value_1->code;

        //             }
        //         }
        //     }
        // }
        $city = city_new()->where('status_del', 0)->with('zone')->get();
        $store_zong = store_new()->where('status_del', 0)->where('code', 'hj001')->get();
        foreach ($store_zong as $k => $v) {     //第一级总店
            $data[$k]['name'] = $v->name;
            $data[$k]['value'] = $v->code;
            foreach ($city as $key_city => $value_city) {      //第二级城市
                $data[$k]['children'][$key_city]['name'] = $value_city->name;
                $data[$k]['children'][$key_city]['value'] = $value_city->code;
                $store_zone = $value_city->zone()->where('status', 1)->with('store')->get(); //剔除不存在的店铺
                foreach ($store_zone as $key_zone => $value_zone) {     //第三级区域
                        $data[$k]['children'][$key_city]['children'][$key_zone]['name'] = $value_zone->name;
                        $data[$k]['children'][$key_city]['children'][$key_zone]['value'] = $value_zone->code;
                        $store_store = $value_zone->store;
                        foreach ($store_store as $key_store => $value_store) {     //第四级店铺
                            if($value_store->status_del == 0){
                                $data[$k]['children'][$key_city]['children'][$key_zone]['children'][$key_store]['name'] = $value_store->name;
                                $data[$k]['children'][$key_city]['children'][$key_zone]['children'][$key_store]['value'] = $value_store->code;
                                $data[$k]['children'][$key_city]['children'][$key_zone]['children'][$key_store]['zone'] = $value_store->zone_code;
                            }
                        }
                }
            }
        }
        $year = date('Y');
        $month = date('m');
        return view('tree.tree', compact('data', 'year', 'month'));
    }
}
