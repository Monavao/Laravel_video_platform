<?php

namespace Tests\Feature;

use Geekflix\User;
use Tests\TestCase;
use Geekflix\Video;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionsTest extends TestCase
{
	use RefreshDatabase;

	public function test_a_user_without_a_plan_cannot_watch_premium_videos() 
	{
	   $user = factory(User::class)->create();
	   $video = factory(Video::class)->create([  'premium' => 1 ]);
	   $video2 = factory(Video::class)->create([  'premium' => 0 ]);
	   $this->actingAs($user);
	   $this->get("/series/{$video->series->slug}/video/{$video->id}")
	       ->assertRedirect('/subscribe');
	   $this->get("/series/{$video2->series->slug}/video/{$video2->id}")
	       ->assertViewIs('watch');
	}

	public function test_a_user_on_any_plan_can_watch_all_videos() 
	{
	   $user = factory(User::class)->create();
	   $video = factory(Video::class)->create([  'premium' => 1 ]);
	   $video2 = factory(Video::class)->create([  'premium' => 0 ]);

	   $this->actingAs($user);

	   $this->fakeSubscribe($user);

	   $this->get("/series/{$video->series->slug}/video/{$video->id}")
	   ->assertViewIs('watch');
	   $this->get("/series/{$video2->series->slug}/video/{$video2->id}")
	   ->assertViewIs('watch');
	}

	public function fakeSubscribe($user) 
	{
	   // subscriptions
	   $user->subscriptions()->create([
	       'name' => 'yearly',
	       'stripe_id' => 'FAKE_STRIPE_ID',
	       'stripe_plan' => 'yearly',
	       'quantity' => 1
	   ]);
	}

	public function test_a_user_without_a_plan_can_watch_free_videos()
	{
		$user = factory(User::class)->create();

		$this->fakeSubscribe($user);

		dd($user->subscribed('yearly'));
	}
}
