<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Session;
class StoreCostDetailsController extends Controller
{   
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $employee_code = Session::get('employee_code');
        $year = date('Y');
        $month = date('m');
        // 店长或助理限制只能看自己本店信息
        if(Session::get('level_code') == 'dz' || Session::get('level_code') == 'zl' || Session::get('level_code') == 'xs'){
            $store = store_new()->where('status_del', 0)->where('code', $store_code)->get(); 
            
        }else{
            $store = store_new()->where('status_del', 0)->where('code', '<>', 'hj001')->get(); 
        }
        $store_code = store_new()->where('status_del', 0)->where('code', '<>', 'hj001')->orderBy('id', 'desc')->select('code')->first();
        if($store_code == null){
            $store_code = null;
        }else{
            $store_code = $store_code->code;
        }
        $get_update_code = $this->cGetUpdateCodeBySearch($year, $month);
        if(!$get_update_code){
            $cost_details = array();
        }else{
            $cost_details = cost_details_ins()->where('update_code', $get_update_code)->where('store_code', $store_code)->with('store')->paginate(10);
        }
        $years = cost_details_ins()->groupBy('year')->select('year')->get();
       
        return view('store.store_cost_detail', compact('store', 'cost_details', 'years', 'year', 'month', 'store_code'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
