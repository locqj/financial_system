<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffContract extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'staff_contract';
    public $timestamps = false;
    
    /*外联employee*/
    public function employee()
    {
        return $this->hasOne('App\StaffEmployee', 'code', 'employee_code');
    }

    /*外联employee*/
    public function source_employee()
    {
        return $this->hasOne('App\StaffEmployee', 'code', 'source_employee');
    }

    /**
     * 店铺对应关系
     * @return [type] [description]
     */
    public function store()
    {
        return $this->hasOne('App\StoreStore', 'code', 'store_code');
    }
    public function images(){
        return $this->hasMany('App\ContractImages', 'contract_id', 'id');
    }
}
