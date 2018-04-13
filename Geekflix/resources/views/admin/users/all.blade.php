@extends('layouts.app')

@section('header')
<header class="header header-inverse" style="background-color: #514e4c
;">
 <div class="container text-center">

   <div class="row">
     <div class="col-12 col-lg-8 offset-lg-2">

       <h1>All series</h1>
       <p class="fs-20 opacity-70">Manage your users</p>

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
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
            </thead>
            <tbody>
                @forelse($user as $u)
                    <tr>
                      <td>
                        <a href="{{ route('users.show', $u->slug) }}">{{ $u->name}}</a>
                      </td>
                      <td>
                          {{ $u->username}}
                      </td>
                      <td>
                          {{ $u->email}}
                      </td>
                      <td>
                          <a href="{{ route('users.edit', $u->slug) }}" class="btn btn-info">Edit</a>
                      </td>
                      <td>
                        <form action="{{ route('users.destroy', $u->slug) }}">
                          <button class="btn btn-danger" type="submit">Delete
                          </button>
                        </form>

                          
                      </td>
                    </tr>
                @empty
                    <p class="text-center">No users found</p>
                @endforelse
            </tbody>
        </table>

       </div>
     </div>
   </div>
 </div>
@stop