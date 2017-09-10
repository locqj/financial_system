<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalculateLog extends Model
{
    /**
     * 关联数据表
     */
    protected $table = 'calculate_log';
    public $timestamps = false;
}
