<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreCity extends Model
{
	/**
     * 关联数据表
     */
    protected $table = 'store_city';
    public $timestamps = false;

    /*关联区域表*/
    public function zone(){
        return $this->hasMany('App\StoreZone','city_code','code');
    }
}
