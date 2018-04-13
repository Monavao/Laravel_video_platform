<?php

namespace Geekflix\Http\Controllers\Admin;

use Geekflix\Series;
use Geekflix\Video;
use Illuminate\Http\Request;
use Geekflix\Http\Controllers\Controller;
use Geekflix\Http\Requests\UpdateVideoRequest;
use Geekflix\Http\Requests\CreateVideoRequest;

class VideosController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       //
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Series $series, CreateVideoRequest $request)
   {
       return $series->videos()->create($request->all());
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Series $series, Video $video, UpdateVideoRequest $request)
   {
       $video->update($request->all());

       return $video->fresh();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(Series $series, Video $video)
   {
       $video->delete();

       return response()->json(['status' => 'ok'], 200);
   }
}