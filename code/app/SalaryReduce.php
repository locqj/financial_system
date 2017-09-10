<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaryReduce extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'reduce_salary';
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
