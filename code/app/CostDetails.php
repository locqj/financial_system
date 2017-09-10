<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostDetails extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'cost_details';
    public $timestamps = false;
    /**
     * [store 店铺关系]
     * @return [type] [description]
     */
    public function store()
    {
        return $this->hasOne('App\StoreStore', 'code', 'store_code');
    }
}
