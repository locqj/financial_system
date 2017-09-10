<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffEmployee extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'staff_employee';
    public $timestamps = false;
    /**
     * 和position关系一个position对应多个employee
     * @return [type] [description]
     */
    public function employee_position()
    {
        return $this->hasOne('App\EmployeePosition', 'employee_code', 'code');
    }

}
