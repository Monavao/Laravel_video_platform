<?php

namespace Tests\Unit;

use Tests\TestCase;
use Geekflix\Video;
use Geekflix\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesTest extends TestCase
{
   use RefreshDatabase;
   
   public function test_series_can_get_image_path()
   {
      $series = factory(Series::class)->create([
         'image_url' => 'series/series-slug.png'
      ]);

      $imagePath = $series->image_path;
      $this->assertEquals(asset('storage/series/series-slug.png'), $imagePath);
   }

   public function test_can_get_ordered_videos_for_a_series()
   {
      // series , video
      $video = factory(Video::class)->create(['episode_number' => 200]);
      $video2 = factory(Video::class)->create(['episode_number' => 100, 'series_id' => 1]);
      $video3 = factory(Video::class)->create(['episode_number' => 300, 'series_id' => 1]);        
      // call the getOrderedVideos
      $videos = $video->series->getOrderedVideos();
      //make sure that the videos are in the correct order
      $this->assertInstanceOf(Video::class, $videos->random());
      $this->assertEquals($videos->first()->id, $video2->id);
      $this->assertEquals($videos->last()->id, $video3->id);
   }
}