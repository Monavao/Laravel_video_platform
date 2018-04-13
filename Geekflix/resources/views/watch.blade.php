@extends('layouts.app')

@section('header')
<header class="header header-inverse" style="background-color: #514e4c">
 <div class="container text-center">

   <div class="row">
     <div class="col-12 col-lg-8 offset-lg-2">

       <h1>{{ $video->title }}</h1>
       <p class="fs-20 opacity-70">{{  $series->title }}</p>

     </div>
   </div>

 </div>
</header>
@stop

@section('content')
<div class="section bg-grey">
  <div class="container">

    @php

      $nextVideo = $video->getNextVideo();
      $prevVideo = $video->getPrevVideo();

    @endphp
     
    <div class="row gap-y text-center">
      <div class="col-12">
        <vue-player default_video="{{ $video }}"

        @if($nextVideo->id !== $video->id)
          next_video_url="{{ route('series.watch', [ 'series' => $series->slug, 'video' => $nextVideo->id ]) }}"
        @endif>

        </vue-player>

        @if($prevVideo->id !== $video->id)
          <a href="{{ route('series.watch', [ 'series' => $series->slug, 'video' => $prevVideo->id ]) }}" class="btn btn-info btn-lg pull-left">Prev Video</a>
        @endif

        @if($nextVideo->id !== $video->id)
          <a href="{{ route('series.watch', [ 'series' => $series->slug, 'video' => $nextVideo->id ]) }}" class="btn btn-info btn-lg pull-right">Next Video</a>
        @endif

      </div>
      <div class="col-12">
        <ul class="list-group">

          @foreach($series->getOrderedVideos() as $v)
            <li class="list-group-item

            @if($v->id == $video->id)
              active
            @endif
            ">

            @if(auth()->user()->hasCompletedVideo($v))
              <b><small>COMPLETED! - </small></b>
            @endif
              <a href="{{ route('series.watch', ['series' => $series->slug, 'video' => $v->id]) }}"> {{ $v->title }}</a>
            </li>
          @endforeach
           
        </ul>
       </div>
     </div>
   </div>
 </div>
@stop