<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;

class SalaryDetailsController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store_code = Session::get('store_code');

        $year = date('Y');
        $month = date('m');
        // 店长或助理限制只能看自己本店信息
        $get_update_code = $this->cGetUpdateCodeBySearch($year, $month);
    
        /*dz,zl,xs只能看自己的信息*/
        if(Session::get('level_code') == 'dz' || Session::get('level_code') == 'zl' || Session::get('level_code') == 'xs'){
            $store = store_new()->where('status_del', 0)->where('code', $store_code)->get();
            $salary_details = salary_details_ins()
                ->where('store_code', $store_code)->where('employee_code', Session::get('employee_code'))
                ->where('update_code', $get_update_code)->with('employee')->with('store')->paginate(10);
        }else{
            $salary_details = salary_details_ins()
                ->where('store_code', $store_code)
                ->where('update_code', $get_update_code)->with('employee')->with('store')->paginate(10);
            $store = store_new()->where('status_del', 0)->get();
        }
        
        $salary_details = $this->cGetSalaryDetailPosition($salary_details);
        $years = salary_details_ins()->groupBy('year')->select('year')->get();
        
        return view('job.salary_details', compact('store', 'salary_details', 'years', 'year', 'month', 'store_code'));
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
