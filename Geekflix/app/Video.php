<?php

namespace Geekflix;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
   /**
    * Fields for mass assignment
    *
    * @var array
    */
   protected $guarded = [];

   protected $with = [];

   /**
    * A video belongs to a series
    *
    * @return void
    */
   public function series() {
       return $this->belongsTo(Series::class);
   }

   /**
    * Get next video after $this
    *
    * @return \Geekflix\Video
    */
   public function getNextVideo() {
       $nextVideo = $this->series->videos()->where('episode_number', '>', $this->episode_number)
                   ->orderBy('episode_number', 'asc')
                   ->first();
       
       if($nextVideo) {
           return $nextVideo;
       }

       return $this;
   }

   /**
    * Get previous video for $this
    *
    * @return \Geekflix\Video
    */
   public function getPrevVideo() {
       $prevVideo = $this->series->videos()->where('episode_number', '<', $this->episode_number)
                   ->orderBy('episode_number', 'desc')
                   ->first();
       
       if($prevVideo) {
           return $prevVideo;
       }

       return $this;
   }
}