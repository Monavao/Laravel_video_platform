<?php

namespace Tests\Feature;

use Geekflix\User;
use Geekflix\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WatchSeriesTest extends TestCase
{
	use RefreshDatabase;

	public function test_a_user_can_complete_a_series()
	{
		$this->flushRedis();
		$this->withoutExceptionHandling();

		$user = factory(User::class)->create();

		$this->actingAs($user);

		$video = factory(Video::class)->create();
		$video2 = factory(Video::class)->create(['series_id' => 1]);

		$response = $this->post("/series/complete-video/{$video->id}", []);
		$response->assertStatus(200);
		$response->assertJson([
			'status' => 'ok'
		]);

		$this->assertTrue(
			$user->hasCompletedVideo($video)
		);

		$this->assertFalse(
			$user->hasCompletedVideo($video2)
		);
	}

}
