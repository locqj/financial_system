<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffPort extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'staff_port';
    public $timestamps = false;

    public function employee()
    {
        return $this->hasOne('App\StaffEmployee', 'code', 'employee_code');
    }

    public function store()
    {
        return $this->hasOne('App\StoreStore', 'code', 'store_code');
    }
}
