<?php

namespace Geekflix\Http\Controllers;

use Geekflix\User;
use Geekflix\Series;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
    	return view('profile')
    		->withUser($user)
    		->withSeries($user->seriesBeingWatched());
    }
}
