@extends('layouts.app')

@section('header')
<header class="header header-inverse" style="background-color: #514e4c">
 <div class="container text-center">

   <div class="row">
     <div class="col-12 col-lg-8 offset-lg-2">

       <h1>{{ auth()->user()->name }}</h1>
       <p class="fs-20 opacity-70">{{ auth()->user()->name }}</p>
       <br>
       <h1>{{ $user->getTotalNumberOfCompletedVideos() }}</h1>
       <p class="fs-20 opacity-70">Videos completed</p>
     </div>
   </div>

 </div>
</header>
@stop
@section('content')
<section class="section" id="section-vtab">
   <div class="container">
       <header class="section-header">
       <h2>Series being watched ...</h2>
       <hr>
       </header>


        <div class="row gap-5">

            @forelse($series as $s)

           <div class="card mb-30">
                <div class="row">
                    <div class="col-12 col-md-4 align-self-center">
                        <a href=""><img src="{{ $s->image_path }}" alt="..."></a>
                    </div>

                    <div class="col-12 col-md-8">
                        <div class="card-block">
                            <h4 class="card-title">{{ $s->title }}</h4>                
                            <p class="card-text">{{ $s->description }}</p>
                            <a class="fw-600 fs-12" href="{{ route('series', $s->slug) }}">Read more <i class="fa fa-chevron-right fs-9 pl-8"></i></a>
                        </div>
                    </div>
                </div>
            </div>

           @empty

           @endforelse
        </div>
   </div>
</section>



<section class="section bg-gray" id="section-vtab">
   <div class="container">
       <header class="section-header">
       <h2>Edit your profile</h2>
       <hr>
       </header>


       <div class="row gap-5">
       

       <div class="col-12 col-md-4">
           <ul class="nav nav-vertical">
           <li class="nav-item">
               <a class="nav-link active" data-toggle="tab" href="#home-2">
               <h6>Personal details</h6>
               </a>
           </li>
           <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#messages-2">
               <h6>Payments & Subscriptions</h6>
               </a>
           </li>
           
           <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#settings-2">
               <h6>Card details</h6>
               </a>
           </li>
           
           </ul>
       </div>
<div class="col-12 col-md-8 align-self-center">
           <div class="tab-content">
           
           <div class="tab-pane fade show active" id="home-2">
               <form action="{{ route('series.store') }}" method="POST" enctype="multipart/form-data">
                       {{csrf_field()}}
                       <div class="form-group">
                           <input class="form-control form-control-lg" type="text" name="name" placeholder="Your name">
                       </div>
                       <div class="form-group">
                           <input class="form-control form-control-lg" type="text" name="email" placeholder="Your email">
                       </div>

                       <button class="btn btn-lg btn-primary btn-block" type="submit">Save changes</button>
                   </form>
           </div>

           <div class="tab-pane fade text-center" id="profile-2">
               
           </div>

           <div class="tab-pane fade" id="messages-2">
               <form action="" method="post">
                   {{csrf_field()}}
                   <h5 class="text-center">
                       Your current plan:
                       
                       <span class="badge badge-success"></span>
                       
                       <span class="badge badge-danger">NO PLAN</span>
                       
                   </h5>
                   <br>
                  
                   <select name="plan" class="form-control">
                       <option value="monthly">Monthly</option>
                       <option value="yearly">Yearly</option>
                   </select>
                   <br>
                   <p class="text-center">
                       <button class="btn btn-primary" type="submit">Change plan</button>
                   </p>
                  
                   
               </form>
           </div>

          
           <div class="tab-pane fade" id="settings-2">
               <div class="row">
                   <h2 class="text-center">
                       Your current card: <span class="badge badge-sm badge-primary"></span>
                   </h2>
                   <p class="ml-5 mt-5 text-center">
                       <vue-update-card email="#"></vue-update-card>
                   </p>
               </div>
           </div>
       

           </div>
       </div>


       </div>


   </div>
</section>


@endsection

@section('scripts')
   <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection