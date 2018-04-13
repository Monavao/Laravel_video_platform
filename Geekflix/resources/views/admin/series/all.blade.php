@extends('layouts.app')

@section('header')
<header class="header header-inverse" style="background-color: #514e4c
;">
 <div class="container text-center">

   <div class="row">
     <div class="col-12 col-lg-8 offset-lg-2">

       <h1>All series</h1>
       <p class="fs-20 opacity-70">Let's make the world a better place for Geeks</p>

     </div>
   </div>

 </div>
</header>
@stop

@section('content')
 <div class="section bg-grey">
   <div class="container">

     <div class="row gap-y">
       <div class="col-12">

        <table class="table">
          
            <thead>
                <th>Title</th>
                <th>Edit</th>
            </thead>
            <tbody>
                @forelse($series as $s)
                    <tr>
                      <td>
                        <a href="{{ route('series.show', $s->slug) }}">{{ $s->title }}</a>
                      </td>
                      <td>
                          <a href="{{ route('series.edit', $s->slug) }}" class="btn btn-info">Edit</a>
                      </td>
                    </tr>
                @empty
                    <p class="text-center">No series found</p>
                @endforelse
            </tbody>
        </table>

       </div>
     </div>
   </div>
 </div>
@stop