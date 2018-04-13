@extends('layouts.app')

@section('header')
<header class="header header-inverse" style="background-color: #514e4c
;">
 <div class="container text-center">

   <div class="row">
     <div class="col-12 col-lg-8 offset-lg-2">

       <h1>{{ $series->title }}</h1>
       <p class="fs-20 opacity-70">Customize your series videos</p>

     </div>
   </div>

 </div>
</header>
@stop

@section('content')
 <div class="section section-inverse">
   <div class="container">

     <div class="row gap-y">
       <div class="col-12">
        
        <vue-videos default_videos="{{ $series->videos }}" series_id="{{ $series->id }}"></vue-videos>
       </div>
     </div>
   </div>
 </div>
@stop