<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Input;
use Session;
use Redirect;
use Validator;
use Auth;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;

use App\User;
use App\Uploaded_videos;
use App\Meta_locations;
use App\Meta_keywords;
use App\Keywords_by_videos;
use App\Liked_videos;

class VideoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return Redirect::to('videos/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {            
            $keywords = $request->input('keywords');
            $metaKeywords = explode(",", $keywords);

            $file = $request->file('video-file');
            $filename = $file->getClientOriginalName();
            $path = public_path().'/uploads/';
            $file->move($path, $filename);

            //@TODO get video extra info   
            //bit_rate
            //duration
            //format         
            
            $data = $request->all();
            $data = [
                'user_id' => Auth::user()->id,
                'url' => $filename,
                'duration' => 0,
                'file_size' => $file->getSize(),
                'format' => '.mp4',
                'bit_rate' => 0
            ];

            $created_video = Uploaded_videos::create(array_merge($request->all(), $data));

            foreach ($metaKeywords as $value) {
                $key = Meta_Keywords::where('name', trim($value))->get()->first();
                if ($key) {
                    $keywords_by_videos = new Keywords_by_videos;
                    $keywords_by_videos->video_id = $created_video->id;
                    $keywords_by_videos->keyword_id = $key->id;
                    
                    $keywords_by_videos->save();
                }
            }

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

        $locations = Meta_locations::all()->pluck('name', 'id');

        $keywords = $video->keywords->implode('name', ', ');

        //$eee = User::find(Auth::user()->id);
        //->likedVideos()->find($id);
        $liked_video = Liked_Videos::where('video_id', $video->id)->where('user_id', Auth::user()->id)->first();
        
        return View::make('videos.show')
            ->with('locations', $locations)
            ->with('liked_video', $liked_video)
            ->with('selectedLocation', $video->location_id)
            ->with('keywords', $keywords)
            ->with('video', $video);
    }

    /**
     * Store the video metadata updated in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMetadata(Request $request)
    {
        $video = Uploaded_videos::find($request->id);

        $video->keywords()->detach();

        $metaKeywords = explode(",", $request->keywords);
        foreach ($metaKeywords as $value) {
            $key = Meta_Keywords::where('name', trim($value))->get()->first();
    
            $video->keywords()->attach($key);    
        }

        $video->location_id = $request->location_id;
        $video->save();

        Session::flash('message', 'Metadata updated!');
        return Redirect::to('videos/' . $video->id);
    }

    public function like($id)
    {
        $video = Uploaded_videos::find($id);
        $user = User::find(Auth::user()->id);

        $user->likedVideos()->attach($video);

        Session::flash('message', 'Video was added to your liked videos!');
        return Redirect::to('videos/' . $video->id);
    }

    public function unlike($id)
    {
        $video = Uploaded_videos::find($id);
        $user = User::find(Auth::user()->id);

        $user->likedVideos()->detach($video);

        Session::flash('message', 'Video was added to your liked videos!');
        return Redirect::to('videos/' . $video->id);
    }

    public function likedList()
    {
        $videos = User::find(Auth::user()->id)->likedVideos;
        //$videos = Uploaded_videos::all();
        //echo $videos;
        return View::make('videos.liked')
            ->with('videos', $videos);
    }

    /**
     * Streams a video file
     *
     * @param  int  $filename
     * @return \Illuminate\Http\Response
     */
    public function stream ($filename)
    {

        $videosDir = base_path('public/uploads');
        if (file_exists($filePath = $videosDir."/".$filename)) {
            $stream = new \App\Http\VideoStream($filePath);
            return response()->stream(function() use ($stream) {
                $stream->start();
            });
        }
        return response("File doesn't exists", 404);
    }

}
