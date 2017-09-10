<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreIncome extends Model
{
    /**
     * 关联数据表
     */
    protected $table = 'store_income';
    public $timestamps = false;

    /**
     * [store 关联店铺表]
     * @return [type] [description]
     */
    public function store(){
        return $this->hasOne('App\StoreStore','code','store_code');
    }
}
