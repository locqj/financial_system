<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreZone extends Model
{
    /**
     * 关联数据表
     */
    protected $table = 'store_zone';
    public $timestamps = false;
      //关联store_store
    public function store(){
        return $this->hasMany('App\StoreStore','zone_code','code');
    }
}
