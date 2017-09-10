<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

date_default_timezone_set('Asia/Shanghai');

class StoreIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $store = store_new()->where('code',session('store_code'))->first();  //根据权限进入相应的店铺
        }else{
            $store = store_new()->orderBy('created_at')->first();
        }
        $year = date('Y');
        $month = $this->cTrimZero();
        $income = store_income_new()->where('store_code',$store->code)->where('year',$year)->with('store')->paginate(10);
        if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $income->store = store_new()->where('status_del',0)->where('code',session('store_code'))->get();
        }else{
            $income->store = store_new()->where('status_del',0)->orderBy('created_at')->get();
        }
        $years = store_income_new()->groupBy('year')->select('year')->get();
        return view('store.income',compact('income','year','years','month','store'));

    }

     /**
     * [cTimeKey 以时间、店铺为关键词查找]
     * @param  [type] $store_code [description]
     * @param  [type] $year       [description]
     * @param  [type] $month      [description]
     * @return [type]             [description]
     */
    public function cTimeKey($store_code, $year, $month){
        $store = store_new()->where('code',$store_code)->first();
        $income = store_income_new()->where('store_code',$store_code)->where('year',$year)->where('month',$month)->paginate(10);
        if(session('level_code') == 'dz' || session('level_code') == 'zl'){
            $income->store = store_new()->where('status_del',0)->where('code',session('store_code'))->get();
        }else{
            $income->store = store_new()->where('status_del',0)->orderBy('created_at')->get();
        }
        $years = store_income_new()->groupBy('year')->select('year')->get();
        return view('store.income',compact('income','year','years','month','store'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(rq('id')){
            $income = store_income_new()->where('id',rq('id'))->first();
            $income->updated_at = date('Y-m-d H:i:s');
        }else{
            $income = store_income_new();
        }
        $income->category = rq('category');
        $income->remark = rq('remark');
        $income->total = round(rq('total'), 2);
        $income->store_code = rq('owner_store_code');
        $income->year = rq('year');
        $income->month = rq('month');
        $income->created_at = date('Y-m-d H:i:s');
        if($income->save())
            return suc((rq('id'))?'修改成功':'添加成功');
        else
            return err((rq('id'))?'修改失败':'添加失败');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $income = store_income_new()->where('id',$id)->first();
        if($income){
            return arrayChange(1, 'success', $income);
        }
        return err('查询为空');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(store_income_new()->where('id',$id)->delete())
            return suc('删除成功');
        return err('删除失败');
    }
}
