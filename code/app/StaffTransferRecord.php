<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffTransferRecord extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'staff_transfer_record';
    public $timestamps = false;
    /*店铺关系*/
    public function store()
    {
        return $this->hasOne('App\StoreStore', 'code', 'store_code');
    }
    /**
     * 关联employee
     * 一对一
     */
    public function employee()
    {
        return $this->hasOne('App\StaffEmployee', 'code', 'employee_code');
    }
    /**
     * 关联contract
     * 一对一
     */
    public function contract()
    {
        return $this->hasOne('App\StaffContract', 'number', 'contract_number');
    }
}
