<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffBonusRule extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'staff_bonus_rule';
    public $timestamps = false;
}
