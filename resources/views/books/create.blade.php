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
            <div class="col-md-9">
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Add Book
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('books.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" placeholder="Title" name="title" id="title" value="{{old('title')}}"/>
                                @if ($errors->has('title'))
                                <span class="text-danger">{{$errors->first('title')}}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control" placeholder="Author"  name="author" id="author" value="{{old('author')}}"/>
                                @if($errors->has('author'))
                                <span class="text-danger">{{$errors->first('author')}}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="author" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Description" cols="30" rows="5" >{{old('description')}}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="Image" class="form-label">Image</label>
                                <input type="file" class="form-control"  name="image" id="image"/>
                                @if($errors->has('image'))
                                <span class="text-danger">{{$errors->first('image')}}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="author" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                            </div>
                            <button class="btn btn-primary mt-2">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
