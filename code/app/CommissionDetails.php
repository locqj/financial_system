<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissionDetails extends Model
{
    /**
     * 关联数据表
     */
    protected $table = 'commission_details';
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
}
