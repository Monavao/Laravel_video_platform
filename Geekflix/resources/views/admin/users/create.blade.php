@extends('layouts.app')

@section('header')
<header class="header header-inverse" style="background-color: #514e4c
;">
 <div class="container text-center">

   <div class="row">
     <div class="col-12 col-lg-8 offset-lg-2">

       <h1>Create User</h1>
       <p class="fs-20 opacity-70">New user</p>

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

         <form action="{{ route('users.store')  }}" method="POST">
           {{ csrf_field() }}
           <div class="form-group">
             <input class="form-control form-control-lg" type="text" name="name" placeholder="Your name">
           </div>

           <div class="form-group">
             <input class="form-control form-control-lg" type="email" name="email" placeholder="Your email">
           </div>

           <div class="form-group">
             <input class="form-control form-control-lg" type="password" name="password" rows="4" placeholder="Your password"></input>
           </div>


           <button class="btn btn-lg btn-primary btn-block" type="submit">Create user</button>
         </form>

       </div>
     </div>
   </div>
 </div>
@stop