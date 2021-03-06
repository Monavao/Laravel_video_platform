<?php

namespace Geekflix;

use Redis;
use Laravel\Cashier\Billable;
use Geekflix\Entities\Learning;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Learning, Billable;

    /**
    * All database columns to be guarded from mass assignment
    *
    * @var array
    */
    protected $guarded = [];

    //protected $with = ['subscriptions'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'confirm_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isConfirmed()
    {
        return $this->confirm_token == null;
    }

    public function confirm()
    {
        $this->confirm_token = null;
        $this->save();
    }

    public function isAdmin()
    {
        return in_array($this->email, config('geekflix.administrators'));
    }

    public function getRouteKeyName()
    {
        return 'username';
    }
}
