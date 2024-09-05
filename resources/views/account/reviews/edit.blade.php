@extends('layouts.app')
@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-lg">
                <div class="card-header  text-white">
                    Welcome, {{Auth::user()->name}}
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if (Auth::user()->image !="")
                        <div style="width: 200px; height: 200px; margin: auto;">
                            <img src="{{asset('upload/profile/'.Auth::user()->image)}}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;" class="img-fluid rounded-circle" alt="{{ Auth::user()->name }}">
                        </div>
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
        <div class="col-md-9">
            @include('layouts.message')
            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                    Edit Review
                </div>
                <div class="card-body pb-3">
                    <form action="{{ route('account.reviews.updateReview', $review->id) }}" method="POST" >
                            @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Review</label>
                            <textarea name="review" id="review" class="form-control">{{old('review',$review->review)}}</textarea>
                            @if ($errors->has('review'))
                                <span class="text-danger">{{$errors->first('review')}}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{($review->status==1)? 'selected':''}}>Active</option>
                                <option value="0" {{($review->status==0)? 'selected':''}}>Block</option>
                            </select>
                            @if ($errors->has('status'))
                                <span class="text-danger">{{$errors->first('status')}}</span>
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
