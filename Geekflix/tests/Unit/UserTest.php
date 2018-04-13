<?php

namespace Tests\Unit;

use Redis;
use Geekflix\User;
use Geekflix\Series;
use Geekflix\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	use RefreshDatabase;

	public function test_a_user_can_complete_a_lesson()
	{
		$this->flushRedis();

		$user = factory(User::class)->create();

		$video = factory(Video::class)->create();

		$video2 = factory(Video::class)->create([
			'series_id' => 1
		]);

		$user->completeVideo($video);

		$user->completeVideo($video2);

		$this->assertEquals(
			Redis::smembers('user:1:series:1'),
			[1, 2]
		);

		$this->assertEquals(
			$user->getNumberOfCompletedVideosForASeries($video->series),2
		);
	}

	public function test_can_get_percentage_completed_for_series_for_a_user()
	{
		$this->flushRedis();

		$user = factory(User::class)->create();

		$video = factory(Video::class)->create();

		factory(Video::class)->create(['series_id' => 1]);

		factory(Video::class)->create(['series_id' => 1]);

		$video2 = factory(Video::class)->create([
			'series_id' => 1
		]);

		$user->completeVideo($video);

		$user->completeVideo($video2);

		$this->assertEquals(
			$user->percentageCompletedForSeries($video->series),
			50
		);
	}

	public function test_can_know_if_a_user_has_started_a_series()
	{
		$this->flushRedis();

		$user = factory(User::class)->create();

		$video = factory(Video::class)->create();

		$video2 = factory(Video::class)->create([
			'series_id' => 1
		]);

		$video3 = factory(Video::class)->create();

		$user->completeVideo($video2);

		$this->assertTrue($user->hasStartedSeries($video->series));

		$this->assertFalse($user->hasStartedSeries($video3->series));
	}

	public function test_can_get_completed_videos_for_a_series()
	{
		$this->flushRedis();

		$user = factory(User::class)->create();

		$video = factory(Video::class)->create();

		$video2 = factory(Video::class)->create([
			'series_id' => 1
		]);

		$video3 = factory(Video::class)->create(['series_id' => 1]);

		$user->completeVideo($video);
		$user->completeVideo($video2);

		$completedVideos = $user->getCompletedVideos($video->series);

		$this->assertInstanceOf(\Illuminate\Support\Collection::class, $completedVideos);
		$this->assertInstanceOf(Video::class, $completedVideos->random());

		$completedVideosIds = $completedVideos->pluck('id')->all();

		$this->assertTrue(in_array($video->id, $completedVideosIds));
		$this->assertTrue(in_array($video2->id, $completedVideosIds));
		$this->assertFalse(in_array($video3->id, $completedVideosIds));
	}

	public function test_can_check_if_user_has_completed_video()
	{
		$this->flushRedis();

		$user = factory(User::class)->create();

		$video = factory(Video::class)->create();

		$video2 = factory(Video::class)->create([
			'series_id' => 1
		]);

		$user->completeVideo($video);

		$this->assertTrue($user->hasCompletedVideo($video));

		$this->assertFalse($user->hasCompletedVideo($video2));
	}

	public function test_can_get_all_series_being_watched_by_user() {
       $this->flushRedis();
       $user = factory(User::class)->create();
       $video = factory(Video::class)->create();
       $video2 = factory(Video::class)->create([ 'series_id' => 1 ]);
       $video3 = factory(Video::class)->create();
       $video4 = factory(Video::class)->create([ 'series_id' => 2 ]);
       $video5 = factory(Video::class)->create();
       $video6 = factory(Video::class)->create([ 'series_id' => 3 ]);
       // complete video 1 , 2
       $user->completeVideo($video);
       $user->completeVideo($video3);

       $startedSeries = $user->seriesBeingWatched();
       // collection of series
       $this->assertInstanceOf(\Illuminate\Support\Collection::class, $startedSeries);
       $this->assertInstanceOf(\Geekflix\Series::class, $startedSeries->random());
       $idsOfStartedSeries = $startedSeries->pluck('id')->all();

       $this->assertTrue(
           in_array($video->series->id, $idsOfStartedSeries)
       );
       $this->assertTrue(
           in_array($video3->series->id, $idsOfStartedSeries)
       );
       $this->assertFalse(
           in_array($video6->series->id, $idsOfStartedSeries)
       );
       //assert 1 , 2
       // assert 3
   }

   public function test_can_get_number_of_completed_videos_for_a_user()
   {
       //user
       $this->flushRedis();
       $user = factory(User::class)->create();
       $video = factory(Video::class)->create();
       $video2 = factory(Video::class)->create([ 'series_id' => 1 ]);
       $video3 = factory(Video::class)->create();
       $video4 = factory(Video::class)->create([ 'series_id' => 2 ]);
       $video5 = factory(Video::class)->create([ 'series_id' => 2 ]);

       $user->completeVideo($video);
       $user->completeVideo($video3);
       $user->completeVideo($video5);

       $this->assertEquals(3, $user->getTotalNumberOfCompletedVideos());
   }
   
   public function test_can_get_next_video_to_be_watched_by_user()
   {
       $this->flushRedis();
       $user = factory(User::class)->create();
       $video = factory(Video::class)->create([ 'episode_number' => 100 ]);
       $video2 = factory(Video::class)->create([ 'series_id' => 1, 'episode_number' => 200 ]);
       $video3 = factory(Video::class)->create([ 'series_id' => 1, 'episode_number' => 300 ]);
       $video4 = factory(Video::class)->create([ 'series_id' => 1, 'episode_number' => 400 ]);
       $user->completeVideo($video);
       $user->completeVideo($video2);

       $nextVideo = $user->getNextVideoToWatch($video->series);
       $this->assertEquals($video3->id, $nextVideo->id);
       $user->completeVideo($video3);
       $this->assertEquals($video4->id, $user->getNextVideoToWatch($video->series)->id);
   }
}
