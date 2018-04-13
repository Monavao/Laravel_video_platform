<?php

namespace Tests\Feature;

use Mail;
use Geekflix\User;
use Tests\TestCase;
use Geekflix\Mail\ConfirmYourEmail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Registration extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_has_adefault_username_after_registration()
    {
        Mail::fake();

        $this->withoutExceptionHandling();

        $this->post('/register', [

        	'name' => 'Alice',
        	'email' => 'alice@mail.fr',
        	'password' => 'secret'

        ])->assertRedirect();

        $this->assertDataBaseHas('users', [

        	'username' => str_slug('Alice')

        ]);
    }

    public function test_a_user_has_a_token_after_registration()
    {
        Mail::fake();
        
        $this->withoutExceptionHandling();

        $this->post('/register', [

            'name' => 'Alice',
            'email' => 'alice@mail.fr',
            'password' => 'secret'

        ])->assertRedirect();

        $user = User::find(1);

        $this->assertNotNull($user->confirm_token);

        $this->assertFalse($user->isConfirmed());
    }

    public function test_an_email_is_sent_to_newly_register_users()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $this->post('/register', [
            'name' => 'Omid',
            'email' => 'omid@mail.fr',
            'password' => 'omid2017'
        ])->assertRedirect();

        Mail::assertQueued(ConfirmYourEmail::class);
    }
}
