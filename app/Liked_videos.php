<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liked_videos extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['video_id', 'user_id'];
}
