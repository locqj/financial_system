<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class StaffEmployeeWageController extends Controller
{   
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {   
        $store_code = store_new()->where('status_del', 0)->orderBy('id', 'desc')->select('code')->first();
        $store_code = $store_code->code;
        $year = date('Y');
        $month = date('m');
        $store = store_new()->where('status_del', 0)->get();
        $get_update_code = $this->cGetUpdateCodeBySearch($year, $month);
        if(!$get_update_code){
            $grant_log = array();
        }else{
            $grant_log = grant_log_ins()->where('update_code', $get_update_code)->where('store_code', $store_code)->with('employee', 'store', 'position')->paginate(10);
            foreach ($grant_log as $key => $value) {
                $grant_log[$key]['amount'] = $value->salary + $value->bonus + $value->dividend + $value->other;
            }
        }
        $years = salary_details_ins()->groupBy('year')->select('year')->get();
        

        $level_code = session('level_code');
        return view('employee.employee_wage', compact('level_code','store_code', 'store', 'years', 'year', 'month', 'salary_details', 'grant_log'));
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
