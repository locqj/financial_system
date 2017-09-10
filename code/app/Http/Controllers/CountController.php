<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
class CountController extends Controller
{   
   
    /**
     * [index 财务核算页面]
     * @return [type] [description]
     */
    public function index()
    {   
        $years = cost_details_ins()->groupBy('year')->select('year')->get();
        $year = date('Y');
        $month = date('m');
        $update_code = DB::table('calculate_log')->where('year', $year)->where('month', $month)->orderBy('id', 'desc')->paginate(10);
        return view('count.count', compact('years', 'year', 'month', 'update_code'));
    }
}
