<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffPosition extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'staff_position';
    public $timestamps = false;

    /**
     * 职位和员工关系，一对以
     * @return [type] [description]
     */
    public function employees()
    {
        return $this->hasOne('App\EmployeePosition', 'position_code', 'code');
    }

    /**
     * 店铺对应关系
     * @return [type] [description]
     */
    public function store()
    {
        return $this->hasOne('App\StoreStore', 'code', 'store_code');
    }

    public function positionLevel()
    {
        return $this->hasOne('App\StaffPositionLevel', 'position_code', 'code');
    }
    /**
     * [zone 区域关系]
     * @return [type] [description]
     */
    public function zone()
    {
        return $this->hasOne('App\StoreZone', 'code', 'store_code');
    }
    
}
