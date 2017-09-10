<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeWage extends Model
{
    protected $table = 'grant_log';
    public $timestamps = false;

    
    public function position()
    {
        return $this->hasOne('App\StaffPosition', 'code', 'position_code');
    }
    /**
     * 关联employee
     * 一对一
     */
    public function employee()
    {
        return $this->hasOne('App\StaffEmployee', 'code', 'employee_code');
    }

    public function store()
    {
        return $this->hasOne('App\StoreStore', 'code', 'store_code');
    }
}
