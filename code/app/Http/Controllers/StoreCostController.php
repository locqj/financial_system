<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

date_default_timezone_set('Asia/Shanghai');

use DB;

class StoreCostController extends Controller
{   
    /**
	 * [index 成本首页]
	 * @return [type] [description]
	 */
    public function index(){
        if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $store = store_new()->where('code',session('store_code'))->first();  //根据权限进入相应的店铺
        }else{
            $store = store_new()->orderBy('created_at')->first();
        }
        $year = date('Y');
        $month = $this->cTrimZero();
    	$cost = cost_new()->where('owner_store_code', $store_code)->where('start_year_month', '<=', $year.$month)->where('end_year_month', '>=', $year.$month)->paginate(10);
        $cost = $this->cCostTrans($cost, $year, $month);
        if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $cost->store = store_new()->where('status_del',0)->where('code',session('store_code'))->get();
        }else{
            $cost->store = store_new()->where('status_del',0)->orderBy('created_at')->get();
        }
        $pay_year_start = cost_new()->where('owner_store_code', $store->code)->min('year');
        $pay_year_end = cost_new()->where('owner_store_code', $store->code)->max('end_year_month');
        $pay_year_end = substr($pay_year_end, 0, 4);
    	return view('store.cost',compact('cost','year','pay_year_start','pay_year_end','month','store'));
    }   


    /**
     * [cCostTrans 给成本赋予中文属性]
     * @param  [type] $cost [description]
     * @return [type]       [description]
     */
    private function cCostTrans($cost, $year, $month){
        foreach ($cost as $key => $value) {
            $pay_month_arr = json_decode($value->pay_month);
            $is_include = 0;
            foreach ($pay_month_arr as $key_include => $value_include) {
                if($value_include->year == $year && $value_include->month == $month)
                    $is_include++;
            }
            if($is_include == 0){
                unset($cost[$key]);
                continue;
            }else{
                if(substr($value->owner_store_code, 0, 2) == 'qy'){
                    $owner_store = store_zone_ins()->where('code',$value->owner_store_code)->first();
                }
                else{
                    $owner_store = store_new()->where('code',$value->owner_store_code)->first();
                }
                $cost[$key]->owner_store_name = $owner_store->name;
                $pay_month = '<tr class="detailTr">';
                $pay_stores = '<tr class="detailTr">';
                $pay_stores_arr = json_decode($value->pay_stores);

                foreach ($pay_month_arr as $key1 => $value1) {
                    if($key1 % 4 == 0 && $key1 != 0)
                        $pay_month .= '</tr><tr class="detailTr">';
                    $pay_month .='<td>'.$value1->year.'年'.$value1->month.'月</td>';
                }
                $pay_month .= '</tr>';
                foreach ($pay_stores_arr as $key2 => $value2) {
                    $pay_store = store_new()->where('code',$value2)->first();
                    if($key1 % 4 == 0 && $key1 != 0)
                        $pay_month .= '</tr><tr class="detailTr">';
                    $pay_stores .='<td>'.$pay_store->name.'</td>';
                }
                $cost[$key]->pay_month = $pay_month;
                $cost[$key]->pay_stores = $pay_stores;
            }   
        }
        return $cost;
    }

    // public function cStoreKey($store_code){
    //     $year = date('Y');
    //     $month = '';
    //     $store = store_new()->where('code',$store_code)->first();
    //     $cost = cost_new()->where('owner_store_code',$store_code)->where('year',$year)->paginate(10);
    //     $cost->store = store_new()->where('status_del',0)->get();
    //     return view('store.cost',compact('cost','year','month','store'));
    // }

    /**
     * [cTimeKey 以时间、店铺为关键词查找]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    public function cTimeKey($store_code, $year, $month){
        if(substr($store_code, 0, 2) == 'qy'){
            $store = store_zone_ins()->where('code',$store_code)->first();
        }else{
            $store = store_new()->where('code',$store_code)->first();
        }
        $cost = cost_new()->where('owner_store_code', $store_code)->where('start_year_month', '<=', $year.$month)->where('end_year_month', '>=', $year.$month)->paginate(10);
        $cost = $this->cCostTrans($cost, $year, $month);
        if(substr($store_code, 0, 2) == 'qy'){
            $cost->store = store_zone_ins()->where('status', 1)->where('code', $store_code)->get();
        }else{
            $cost->store = store_new()->where('status_del',0)->where('code', $store_code)->get();
        }
        $pay_year_start = cost_new()->where('owner_store_code', $store_code)->min('year');
        $pay_year_end = cost_new()->where('owner_store_code', $store_code)->max('end_year_month');
        $pay_year_end = substr($pay_year_end, 0, 4);
        $categoryList = using_words_new()->where('status_del', 0)->where('type', 1)->get();
        return view('store.cost',compact('cost','year','pay_year_start','pay_year_end','month','store', 'categoryList'));
    }

    public function create(){
        $store = store_new()->where('status_del',0)->orderBy('created_at')->get();
        return view('store.cost_create',compact('store'));
    }

    /**
     * [cost 录入成本]
     * @param  Request $Request [description]
     * @return [json]           [返回状态]
     */
    public function store(){
        if(rq('id')){
            $cost = cost_new()->where('id',rq('id'))->first();
        }else{
    	   $cost = cost_new();
           if(rq('payType') == '1'){         //自付
                $pay_stores['0'] = rq('owner_store_code');
            }else {                     //分摊
                if(substr(rq('owner_store_code'), 0, 2) == 'qy'){
                    $pay_stores_arr = store_new()->where('status_del','0')->where('zone_code', rq('owner_store_code'))->get();
                }else{
                    $pay_stores_arr = store_new()->where('status_del','0')->where('type',2)->get();
                }
                $pay_stores = array();
                foreach ($pay_stores_arr as $key => $value) {
                    $pay_stores[$key] = $value->code;
                }
                if(!$pay_stores)
                    return err((rq('id'))?'修改失败':'添加失败');
            }
            $cost->pay_stores = json_encode($pay_stores);
        }
        $cost->length = rq('length');
    	$cost->total = round(rq('total'), 2);
    	$cost->category = rq('category');
        $cost->details = rq('details');
                                          //计算还款月份
        $start_month = rq('start_month');
        $start_year = rq('start_year');
        $length = rq('length');
                                          //超过所在年份
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
            $cost->end_year_month = ($start_year + $count_year - 1).$end_month;
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
            $cost->end_year_month = ($start_year).$end_month;
        }
    	$cost->pay_month = json_encode($pay_month);
        $cost->owner_store_code = rq('owner_store_code');
    	$cost->unit = round(rq('total') / rq('length'), 2);
    	$cost->year = rq('start_year');
    	$cost->month = rq('start_month');
        if(rq('start_month')<10)
            $cost->start_year_month = rq('start_year').'0'.rq('start_month');
        else
            $cost->start_year_month = rq('start_year').rq('start_month');
    	$cost->created_at = date('Y-m-d H:i:s');
    	if($cost->save())
    		return suc($cost->id);
    	else
    		return err((rq('id'))?'修改失败':'添加失败');


    }
    
    /**
     * [show 单个成本api]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id){
    	$cost = cost_new()->where('id',$id)->first();
    	if($cost){
            $cost->images = DB::table('contract_images')->where('cost_id', $id)->where('status_del', 0)->get();
            $pay_month = json_decode($cost->pay_month);
            $cost->length = count($pay_month);
            $cost->start_month = $pay_month[0]->month;
            $cost->start_year = $pay_month[0]->year;
            $pay_stores = json_decode($cost->pay_stores,true);
            if($cost->owner_store_code == $pay_stores[0])
                $cost->payType = '1';
            else
                $cost->payType = '2';
    		return arrayChange(1, 'success', $cost);
        }
    	return err('查询为空');
    }

    /**
     * [cGetStoreType 获取店铺类型]
     * @return [type] [description]
     */
    public function cGetStoreType(){
        $store = store_new()->where('code',rq('store_code'))->first();
        if(substr(rq('store_code'), 0, 2) == 'qy')
            echo '1';
        else
            echo $store->type;        
    }

    /**
     * [edit 编辑成本api]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id){
        $cost = cost_new()->where('id',$id)->first();
        $owner_store = store_new()->where('status_del',0)->where('code',$cost->owner_store_code)->first();
        $cost->owner_store_name = $owner_store->name;
        $cost->store = store_new()->where('status_del',0)->get();
        $pay_month = json_decode($cost->pay_month);
        $cost->length = count($pay_month);
        $cost->pay_month = $pay_month;
        $cost->pay_stores = json_decode($cost->pay_stores);
        return view('store.cost_edit',compact('cost'));
    }

    public function update(){
    	//
    }

    /**
     * [destroy 删除成功api 暂不用]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id){
    	if(cost_new()->where('id',$id)->delete())
    		return suc('删除成功');
    	return err('删除失败');
        // return err('需要权限');
    }

    /**
     * 存储图片
     */
    public function cStoreImages(Request $request, $id){
        $file = $request->file();
        if(count($file) > 0){
            $count = 0;
            foreach ($file as $key => $value) {
                $tmpName    = $value->getFileName(); //文件临时名称
                $entension  = $value->getClientOriginalExtension();//文件后缀
                $name = date('YmdHi').$tmpName.'.'.$entension;
                $path = $value->move(public_path().'/static/files/images', $name);//移动文件到指定目录
                if(DB::table('contract_images')->insert(['url' => '/static/files/images/'.$name, 'cost_id' => $id]))
                    $count++;

            }
            return suc('共计'.$count.'张图片！');
        }else{
            return suc('无图片！');
        }
    }

    /**
     * 删除图片
     */
    public function cDelImage($id){
        if(DB::table('contract_images')->where('id', $id)->update(['status_del' => 1])){
            return suc('删除成功！');
        }else{
            return err('删除失败');
        }
    }

}
