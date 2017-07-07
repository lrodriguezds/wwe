<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keywords_by_videos extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['video_id', 'keyword_id'];
}
