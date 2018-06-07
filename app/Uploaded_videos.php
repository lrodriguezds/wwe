<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uploaded_videos extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['title', 'url', 'user_id', 'location_id', 'duration', 'file_size', 'format', 'bit_rate'];

    public function uploadedBy()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function location()
    {
        return $this->belongsTo('App\Meta_locations');
    }

    public function keywords()
    {
        return $this->belongsToMany('App\Meta_keywords', 'keywords_by_videos', 'video_id', 'keyword_id');
    }

}
