@extends('layouts.app')
@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-lg">
                <div class="card-header  text-white" style="background-color:#526cff">
                    Welcome, {{Auth::user()->name}}
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if (Auth::user()->image !="")
                        <img src="{{asset('upload/profile/'.Auth::user()->image)}}" class="img-fluid rounded-circle" alt="$user->name" >
                        @endif
                    </div>
                    <div class="h5 text-center">
                        <strong>{{Auth::user()->name}}</strong>
                        <p class="h6 mt-2 text-muted">5 Reviews</p>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-lg mt-3">
                <div class="card-header  text-white">
                    Navigation
                </div>
                <div class="card-body sidebar">
                    @include('layouts.sidebar')
                </div>
            </div>
        </div>
        <div class="col-md-9" >
            @include('layouts.message')
            <div class="card border-0 shadow">
                <div class="card-header  text-white" style="background-color:#526cff">
                    Profile
                </div>
                <div class="card-body" >
                    <form action="{{route('account.updateProfile')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{old('name',$user->name)}}" class="form-control" placeholder="name" name="name" id="" />
                        @if ($errors->has('name'))
                            <span class="text-danger">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Email</label>
                        <input type="text" value="{{old('email',$user->email)}}" class="form-control" placeholder="Email"  name="email" id="email"/>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if (Auth::user()->image !="")
                        <img src="{{asset('upload/profile/'.Auth::user()->image)}}" class="img-fluid mt-4" alt="{{$user->name}}">
                        @endif
                        @if ($errors->has('image'))
                            <span class="text-danger">{{$errors->first('image')}}</span>
                        @endif
                    </div>
                    <button class="btn btn-primary mt-2">Update</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
