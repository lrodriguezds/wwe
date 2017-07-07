<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta_locations extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['name'];

    public function videos()
    {
        return $this->hasMany('App\Uploaded_videos');
    }
}
