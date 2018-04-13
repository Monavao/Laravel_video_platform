<?php

namespace Geekflix;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
   /**
    * All database columns to be guarded from mass assignment
    *
    * @var array
    */
   protected $guarded = [];

   /**
    * Eager load relationships
    *
    * @var array
    */
   protected $with = ['videos'];

   /**
    * A series has many lessons
    *
    * @return void
    */
   public function videos()
   {
       return $this->hasMany(Video::class);
   }

   /**
    * Get the route key for the model.
    *
    * @return string
    */
   public function getRouteKeyName()
   {
       return 'slug';
   }

   /**
    * Return the public path for series image
    *
    * @return string
    */
   public function getImagePathAttribute() {
       return asset('storage/' . $this->image_url);
   }

   /**
    * Get a list of lessons for series in watching order
    *
    * @return void
    */
   public function getOrderedVideos() {
       return $this->videos()->orderBy('episode_number', 'asc')->get();
   }
}