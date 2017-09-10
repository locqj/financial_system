<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalculateStore extends Model
{
    /**
     * 关联数据表
     */
    protected $table = 'calculate_store';
    public $timestamps = false;


    /**
     * 关联店铺
     */
    public function store(){
    	return $this->hasOne('App\StoreStore','code','store_code');
    }
}
