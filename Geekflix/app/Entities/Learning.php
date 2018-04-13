<?php

namespace Geekflix\Entities;

use Geekflix\Series;
use Redis;
use Geekflix\Video;

trait Learning
{
	public function completeVideo($video)
    {
        //dd("user:{$this->id}:series:{$video->series->id}");
        Redis::sadd("user:{$this->id}:series:{$video->series->id}", $video->id);
    }

    public function percentageCompletedForSeries($series)
    {
        $numberOfVideosInSeries = $series->videos->count();
        $numberOfCompletedVideos = $this->getNumberOfCompletedVideosForASeries($series);

        return ($numberOfCompletedVideos/ $numberOfVideosInSeries) * 100;
    }

    public function getNumberOfCompletedVideosForASeries($series)
    {
        return count($this->getCompletedVideosForASeries($series));
    }

    public function getCompletedVideosForASeries($series)
    {
        return Redis::smembers("user:{$this->id}:series:{$series->id}");
    }

    public function hasStartedSeries($series)
    {
    	return $this->getNumberOfCompletedVideosForASeries($series) > 0;
    }

    /**
     * Get all completed videos for a series
     * @param [Geekflix\Series] $series
     * @return \Illuminate\Support\Collection(Geekflix\Video)
     */
    public function getCompletedVideos($series)
    {
        /*$completedVideos = $this->getCompletedVideosForASeries($series);
        return collect($completedVideos)->map(function($videoId){
           return Video::find($videoId);
        });*/

        return Video::whereIn('id', $this->getCompletedVideosForASeries($series))->get();
    }

    public function hasCompletedVideo($video)
    {
        return in_array(
            $video->id,
            $this->getCompletedVideosForASeries($video->series)
        );
    }

    public function seriesBeingWatchedIds()
    {
        $keys = Redis::keys("user:{$this->id}:series:*");

        $seriesIds = [];

        foreach($keys as $key):
            $seriedId = explode(':', $key)[3];
            array_push($seriesIds, $seriedId);
        endforeach;

        return $seriesIds;
    }

    public function seriesBeingWatched()
    {
        return collect($this->seriesBeingWatchedIds())
        ->map(function($id){
            return Series::find($id);
        })->filter();
    }

    public function getTotalNumberOfCompletedVideos()
    {
        $keys = Redis::keys("user:{$this->id}:series:*");
        $result = 0;

        foreach($keys as $key):
            $result = $result + count(Redis::smembers($key));
        endforeach;

        return $result;
    }

    public function getNextVideoToWatch($series)
    {
        $videoIds = $this->getCompletedVideosForASeries($series);

        $videoId = end($videoIds);

        return Video::find($videoId)->getNextVideo();
    }
}
