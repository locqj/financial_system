<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
class StaffBonusRuleController extends Controller
{   
   
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*根据rule_key来show*/
        $show = bonus_rule_ins()->where('status_del', 0)->where('rule_key',1)->orderBy('bottom')->get();
        foreach ($show as $key => $value) {
            $show[$key]->percentage = $value->percentage*100;
        }
        $port = bonus_rule_ins()->where('status_del', 0)->where('rule_key',13)->orderBy('bottom')->get();
        foreach ($port as $key => $value) {
            $port[$key]->percentage = $value->percentage*100;
        }
        $bonus = bonus_rule_ins()->where('status_del', 0)->whereBetween('rule_key',[2, 9])->orderBy('rule_key')->get();
        foreach ($bonus as $key => $value) {
            if($value->rule_key == 6){
                $bonusRule[$value->rule_key]['percentage'] = $value->percentage*100;
                $bonusRule[$value->rule_key]['parent_store_limit'] = $value->top;
            }
            else
                $bonusRule[$value->rule_key] = $value->percentage*100;
        }
        $treat_db = bonus_rule_ins()->where('status_del', 0)->where('rule_key',10)->orderBy('bottom')->get();
        $treat_arr = array();
        foreach ($treat_db as $key => $value) {
            $treat_arr[$key] = $value->bottom;
        }

        $treat = json_encode($treat_arr);
        $firstAndRent = bonus_rule_ins()->where('status_del', 0)->whereIn('rule_key',[11, 12])->orderBy('rule_key')->get();
        foreach ($firstAndRent as $key => $value) {
            $firstAndRentRule[$value->rule_key] = $value->percentage*100;
        }
        return view('job.job_bonusrule',compact('show','bonusRule','treat','firstAndRentRule','port'));
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
        if(rq('rule_key') == 1){
            $bonus_rule_old = bonus_rule_ins()->where('rule_key','1')->select('id')->get();
            foreach ($bonus_rule_old as $key => $value) {
                bonus_rule_ins()->where('id',$value->id)->update(['status_del'=>1]);
            }
            $ruleLimit = rq('ruleLimit');
            foreach ($ruleLimit as $key => $value) {
                $bonus_rule = array(
                    "rule_key" => rq('rule_key'),
                    "top" => $value[1],
                    "bottom" => $value[0],
                    "percentage" => $value[2]/100,
                    "is_cost" => 1
                    );
                bonus_rule_ins()->insert($bonus_rule);
            }
           return succ('保存成功！');
        }else if(rq('rule_key') == 13){
            $bonus_rule_old = bonus_rule_ins()->where('rule_key','13')->select('id')->get();
            foreach ($bonus_rule_old as $key => $value) {
                bonus_rule_ins()->where('id',$value->id)->update(['status_del'=>1]);
            }
            $ruleLimit = rq('ruleLimit');
            foreach ($ruleLimit as $key => $value) {
                $bonus_rule = array(
                    "rule_key" => rq('rule_key'),
                    "bottom" => $value[0],
                    "percentage" => $value[1]/100,
                    "is_cost" => 0
                    );
                bonus_rule_ins()->insert($bonus_rule);
            }
           return succ('保存成功！');
        }else if(rq('rule_key') == 10){
            $bonus_rule_old = bonus_rule_ins()->where('rule_key','10')->select('id')->get();
            foreach ($bonus_rule_old as $key => $value) {
                bonus_rule_ins()->where('id',$value->id)->update(['status_del'=>1]);
            }
            $treatRule = rq('treatRule');
            foreach ($treatRule as $key => $value) {
                $bonus_rule = array(
                    "rule_key" => rq('rule_key'),
                    "bottom" => $value,
                    "is_cost" => 0,
                    "position_code"=>"xs0".($key+1)
                    );
                bonus_rule_ins()->insert($bonus_rule);
            }
           return succ('保存成功！');
        }else{
                if(bonus_rule_ins()->where('rule_key',rq('rule_key'))->exists())
                    bonus_rule_ins()->where('rule_key',rq('rule_key'))->update(['status_del'=>1]);
                    $add = array(
                            "rule_key" => rq('rule_key'),
                            "percentage" => rq("percentage")/100,
                            "is_cost" => 0
                            );
                    if(rq('rule_key') == 6)
                        $add['top'] = rq('parent_store_limit');
                    if(bonus_rule_ins()->insert($add))
                            return succ('保存成功！');
                        else
                            return err('保存失败！');
            }
        }

    /**
     * [cRuleConfirm description]
     * @param  [type] $position_code [员工标识]
     * @param  [type] $rule_key      [1:提成规则；2:分红规则]
     * @param  [type] $top           [上限]
     * @param  [type] $bottom        [下限]
     * @return [type]                [description]
     */
    public function cRuleConfirm($ruleId,$store_position_code, $rule_key, $top, $bottom){
        $rule = bonus_rule_ins()->where('store_position_code', $store_position_code)->where('rule_key', $rule_key)->where('status_del','0')->get();
        foreach ($rule as $key => $value) {
            if(!$ruleId || $ruleId != $value->id){
                if(
                       ($top <= $value->top && $top >= $value->bottom) 
                    || ($bottom >= $value->bottom && $bottom <= $value->top)
                    || ($value->top <= $top && $value->top >= $bottom) 
                    || ($value->bottom >=$bottom &&$value->bottom <=$top)
                  )
                    return 0;
            }
        }
        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        /*根据rule_key来show*/
        // $show = bonus_rule_ins()->where('status_del', 0)->where('store_position_code',$id)->where('rule_key',1)->orderBy('bottom')->get();
        // foreach ($show as $key => $value) {
        //     $show[$key]->percentage = $value->percentage*100;
        // }
        // $bonus = bonus_rule_ins()->where('status_del', 0)->where('store_position_code',$id)->where('rule_key',2)->first();
        // if($bonus)
        //     $bonus->percentage = $bonus->percentage*100;
        // $storePositionCode = $id;
        // $positionFlag = substr($id, 8, 2); //职位
        // return view('job.job_bonusrule',compact('show','bonus','storePositionCode','positionFlag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*$bonus_rule = bonus_rule_ins()->where('status_del', 0)->where('id', $id)->first();
        $bonus_rule->position_code = rq('position_code');
        $bonus_rule->rule_key = rq('rule_key');
        $bonus_rule->top = rq('top');
        $bonus_rule->buttom = rq('buttom');
        $bonus_rule->percentage = rq('percentage');
        $bonus_rule->is_cost = rq('is_cost');
        if($bonus_rule->save())
            return suc('修改成功');*/
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
        /*根据rule_key来删除整个规则*/
        $rule = bonus_rule_ins()->where('id',$id)->first();
        if($rule->bottom == 0)
            return err('不可删除！');
        $rule_up = bonus_rule_ins()->where('store_position_code',$rule->store_position_code)->where('top',$rule->bottom - 1)->update(['top' => $rule->top]);
        if(bonus_rule_ins()->where('id',$id)->update(['status_del' => 1]))
            return suc("删除成功");
        else
            return err("删除失败");
    }
}
