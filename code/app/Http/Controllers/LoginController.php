<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

use Redirect;

class LoginController extends Controller
{   

    public function index()
    {
    	return view('login.index');
    }

    /*loginajax提交*/
    public function cIndexSub()
    {
        $username = rq('username');
        $pwd = md5(rq('pwd'));
        $dis_user = user_ins()->where('username', $username)->where('status', 1)->exists();
        if($dis_user){
            $user = user_ins()->where('username', $username)->where('pwd', $pwd)->where('status', 1)->with('employee_position')->first();
            if($user){
                $position_tag = $this->getPositionTag($user);
                Session::set('position_tag', $position_tag);
                Session::set('employee_code', $user->employee_code);
                Session::set('username', $user->username);
                Session::set('position_code', $user->employee_position->position_code);
                Session::set('store_code', $user->employee_position->store_code);
                Session::set('level_code', substr($user->employee_position->position_code, 0, 2));                
                $level_code = Session::get('level_code');
                return suc($level_code);

            }else{
                return err('密码错误');    
            }
        }else{
            return err('不存在该用户');
        }
        
    }
    /*登出*/
    public function cLogout()
    {
        Session::forget('employee_code');
        Session::forget('level_code');
        Session::forget('store_code');
        Session::forget('username');
        Session::forget('position_code');
        return Redirect::route('login'); 
    }

    /**
     * 获取职位称号
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function getPositionTag($user){
        $position_tag = $user->employee_position->position->position_tag;
        return $position_tag;
    }

}
