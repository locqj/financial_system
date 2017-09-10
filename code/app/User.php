<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    public $timestamps = false;

    public function employee()
    {
        return $this->hasOne('App\StaffEmployee', 'code', 'employee_code');
    }
    public function employee_position()
    {
        return $this->hasOne('App\EmployeePosition', 'employee_code', 'employee_code');
    }
}
