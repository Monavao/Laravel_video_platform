<?php

namespace Geekflix\Http\Controllers;

use Geekflix\Series;
use Geekflix\Video;
use Illuminate\Http\Request;

class WatchSeriesController extends Controller
{
    public function index(Series $series)
    {
        $user = auth()->user();

        if($user->hasStartedSeries($series))
        {
            return redirect()->route('series.watch', [
                'series' => $series->slug, 
                'video' => $user->getNextVideoToWatch($series)
            ]);
        }

    	return redirect()->route('series.watch', [
    			'series' =>$series->slug, 
    			'video' => $series->videos->first()->id
    		]);
    }

    public function showVideo(Series $series, Video $video)
    {
        /*if(!auth()->user()->subscribedToPlan(['monthly', 'yearly']))
        {
            return redirect('subscribe');
        }*/

    	return view('watch', [
    		'series' => $series,
    		'video' => $video
    	]);
    }

    public function completeVideo(Video $video)
    {
        auth()->user()->completeVideo($video);
        return response()->json([
            'status' => 'ok'
        ]);
    }
}
