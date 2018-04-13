<?php

namespace Tests;

use Redis;
use Config;
use Geekflix\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loginAdmin()
    {
    	$user = factory(User::class)->create();

		Config::push('geekflix.administrators', $user->email);

		$this->actingAs($user);
    }

    public function flushRedis()
    {
    	Redis::flushall();
    }
}
