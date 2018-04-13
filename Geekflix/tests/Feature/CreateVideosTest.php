<?php

namespace Tests\Feature;

use Geekflix\Series;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateVideosTest extends TestCase
{
	use RefreshDatabase;

	public function test_a_user_can_create_videos()
	{
		$this->loginAdmin();

		$this->withoutExceptionHandling();

		$series = factory(Series::class)->create();

		$video = [
			'title' => 'new video',
			'description' => 'new video description',
			'episode_number' => 42,
			'video_id' => 2222564
		];

		$this->postJson("/admin/{$series->id}/videos", $video)
			->assertStatus(200)
			->assertJson($video);

		$this->assertDatabaseHas('videos', [
			'title' => $video['title']
		]);
	}

	public function test_a_title_is_required_to_create_a_video()
	{
		$this->loginAdmin();

		$series = factory(Series::class)->create();

		$video = [
			'description' => 'new video description',
			'episode_number' => 42,
			'video_id' => 2222564
		];

		$this->post("/admin/{$series->id}/videos", $video)
			->assertSessionHasErrors('title');
	}

	public function test_an_episode_number_is_required_to_create_a_video()
	{
		$this->loginAdmin();

		$series = factory(Series::class)->create();

		$video = [
			'title' => 'new video',
			'description' => 'new video description',
			'video_id' => 2222564
		];

		$this->post("/admin/{$series->id}/videos", $video)
			->assertSessionHasErrors('episode_number');
	}

	public function test_a_video_id_is_required_to_create_a_video()
	{
		$this->loginAdmin();

		$series = factory(Series::class)->create();

		$video = [
			'title' => 'new video',
			'description' => 'new video description',
			'episode_number' => 42
		];

		$this->post("/admin/{$series->id}/videos", $video)
			->assertSessionHasErrors('video_id');
	}
}
