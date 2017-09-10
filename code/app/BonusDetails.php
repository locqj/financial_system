<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonusDetails extends Model
{
    /**
     * 关联数据表
     */
    protected $table = 'bonus_details';
    public $timestamps = false;

    /**
     * 关联店铺
     */
    public function store(){
    	return $this->hasOne('App\StoreStore','code','store_code');
    }

    /**
     * 关联员工
     */
    public function employee(){
    	return $this->hasOne('App\StaffEmployee','code','employee_code');
    }

    /**
     * 关联二级店铺或者店铺来源
     */
    public function cstore(){
        return $this->hasOne('App\StoreStore','code','cstore_code');
    }

    public function employee_position()
    {
        return $this->hasOne('App\EmployeePosition', 'employee_code', 'employee_code');
    }
}
