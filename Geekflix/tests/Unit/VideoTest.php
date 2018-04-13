<?php

namespace Tests\Unit;

use Geekflix\Series;
use Geekflix\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoTest extends TestCase
{
	use RefreshDatabase;

	public function test_can_get_next_and_previous_videos_from_a_video()
	{
		$video = factory(Video::class)->create(['episode_number' => 200]);
     	$video2 = factory(Video::class)->create(['episode_number' => 100, 'series_id' => 1]);
    	$video3 = factory(Video::class)->create(['episode_number' => 300, 'series_id' => 1]);

    	$this->assertEquals($video->getNextVideo()->id, $video3->id);
    	$this->assertEquals($video3->getPrevVideo()->id, $video->id);
    	$this->assertEquals($video2->getNextVideo()->id, $video->id);
    	$this->assertEquals($video2->getPrevVideo()->id, $video2->id);
    	$this->assertEquals($video3->getNextVideo()->id, $video3->id);
	}
}
