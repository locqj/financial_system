<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsingWords extends Model
{
    /**
     * 关联数据表
     */
    protected $table = 'using_words';
    public $timestamps = false;
}
