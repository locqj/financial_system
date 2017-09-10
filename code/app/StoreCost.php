<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreCost extends Model
{
	/**
     * 关联数据表
     */
    protected $table = 'store_cost';
    public $timestamps = false;

    public function images(){
        return $this->hasMany('App\ContractImages', 'cost_id', 'id');
    }
}
