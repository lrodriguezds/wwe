<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;

use App\Uploaded_videos;

class CheckVideo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $video = Uploaded_videos::find($request->id);
        if (!$video) {
            return Redirect::to('videos');
        }

        return $next($request);
    }
}
