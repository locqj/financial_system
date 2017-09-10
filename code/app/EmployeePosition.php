<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeePosition extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'employee_position';
    public $timestamps = false;

    /**
     * 关联position
     * 一对一
     */
    
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

    public function zone()
    {
        return $this->hasOne('App\StoreZone', 'code', 'store_code');
    }

    /*一对多的关系*/
    //签单表
    public function contract(){
        return $this->hasMany('App\StaffContract','employee_code','employee_code');
    }

    //作为源的签单表
    public function source_contract(){
        return $this->hasMany('App\StaffContract','source_employee','employee_code');
    }

    public function positionLevel(){
        return $this->hasOne('App\StaffPositionLevel','position_code','position_code');
    }

    /**
     * 关联职位调整记录表
     */
    public function positionAdjustment(){
        return $this->hasMany('App\PositionAdjustmentLog','employee_code','employee_code');
    }

    /**
     * 关联提成表
     */
    public function bonus_details(){
        return $this->hasMany('App\BonusDetails','employee_code','employee_code');
    }


}
