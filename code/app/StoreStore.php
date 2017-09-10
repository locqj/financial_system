<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreStore extends Model
{
    /**
     * 关联数据表
     */
    protected $table = 'store_store';
    public $timestamps = false;

    //关联签单
    public function contract(){
        return $this->hasMany('App\StaffContract','store_code','code');
    }

    //关联店铺支出
    public function cost_details(){
    	return $this->hasMany('App\CostDetails','store_code','code');
    }

    //关联基本工资
    public function salary(){
    	return $this->hasMany('App\SalaryDetails','store_code','code');
    }

    //关联员工提成
    public function bonus(){
    	return $this->hasMany('App\BonusDetails','store_code','code');
    }

    //关联收入表
    public function income(){
        return $this->hasMany('App\StoreIncome', 'store_code', 'code');
    }

    //关联员工
    public function employee(){
        return $this->hasMany('App\EmployeePosition', 'store_code', 'code');
    }

    //关联父级店铺
    public function parent_store(){
        return $this->hasOne('App\StoreStore','code','parent_code');
    }

    //关联提供源签单
    public function contract_source(){
        return $this->hasMany('App\StaffContract','source_store','code');
    }

    //关联端口
    public function port(){
        return $this->hasMany('App\StaffPort', 'store_code', 'code');
    }


}
