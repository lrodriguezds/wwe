<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Input;
use Session;
use Redirect;
use Validator;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;

use App\Uploaded_videos;
use App\Meta_locations;
use App\Meta_keywords;
use App\Keywords_by_videos;

class VideoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Uploaded_videos::all();

        return View::make('videos.index')
            ->with('videos', $videos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Meta_locations::all()->pluck('name', 'id');
        return View::make('videos.create')
            ->with('locations', $locations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        

        $rules = array(
            'title'       => 'required',
            'video-file'      => 'required|mimes:mp4',
            'location_id' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);


        if ($validator->fails()) {
            return Redirect::to('videos/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            $video = new Uploaded_videos;
            $video->title = Input::get('title');
            $video->location_id = Input::get('location_id');
            $file = Input::file('video-file');
            $keywords = Input::get('keywords');
            $metaKeywords = explode(",", $keywords);

            $filename = $file->getClientOriginalName();
            $path = public_path().'/uploads/';
            $file->move($path, $filename);

            //@TODO get video extra info            
            /*$ffprobe = FFProbe::create();
            $duration = $ffprobe
                ->format($path . $filename)
                ->get('duration');
            */

            $video->url = $filename;
            $video->duration = 0;
            $video->file_size = $file->getSize();
            $video->format = '.mp4';
            $video->bit_rate = 0;
            $video->save();

            foreach ($metaKeywords as $valor) {
                $key = Meta_Keywords::where('name', $valor)->get()->first();
                var_dump($key);
                if ($key) {
                    $keywords_by_videos = new Keywords_by_videos;
                    $keywords_by_videos->video_id = $video->id;
                    $keywords_by_videos->keyword_id = $key->id;
                    
                    $keywords_by_videos->save();
                }
            }


            // redirect
            Session::flash('message', 'Video successfully uploaded');
            return Redirect::to('videos');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Uploaded_videos::find($id);
        $video->file = 'video/'.$video->url;

        return View::make('videos.show')
            ->with('video', $video);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
