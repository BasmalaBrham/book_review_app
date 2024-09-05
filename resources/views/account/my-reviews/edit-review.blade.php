@extends('layouts.app')
@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-lg">
                <div class="card-header text-white">
                    Welcome, {{ Auth::user()->name }}
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if (Auth::user()->image != "")
                        <div style="width: 200px; height: 200px; margin: auto;">
                            <img src="{{ asset('upload/profile/' . Auth::user()->image) }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;" class="img-fluid rounded-circle" alt="{{ Auth::user()->name }}">
                        </div>
                        @endif
                    </div>
                    <div class="h5 text-center">
                        <strong>{{ Auth::user()->name }}</strong>
                        <p class="h6 mt-2 text-muted">5 Reviews</p>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-lg mt-3">
                <div class="card-header text-white">
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
                <div class="card-header text-white">
                    Edit Review
                </div>
                <div class="card-body pb-3">
                    <form action="{{ route('account.myReviews.updateReview', $review->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Book</label>
                            <div>
                                <strong>{{ $review->book->title }}</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="review" class="form-label">Review</label>
                            <textarea name="review" id="review" class="form-control">{{ old('review', $review->review) }}</textarea>
                            @if ($errors->has('review'))
                                <span class="text-danger">{{ $errors->first('review') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="rate" class="form-label">Rating</label>
                            <select name="rate" id="rate" class="form-control">
                                <option value="1" {{ ($review->rate == 1) ? 'selected' : '' }}>1</option>
                                <option value="2" {{ ($review->rate == 2) ? 'selected' : '' }}>2</option>
                                <option value="3" {{ ($review->rate == 3) ? 'selected' : '' }}>3</option>
                                <option value="4" {{ ($review->rate == 4) ? 'selected' : '' }}>4</option>
                                <option value="5" {{ ($review->rate == 5) ? 'selected' : '' }}>5</option>
                            </select>
                            @if ($errors->has('rate'))
                                <span class="text-danger">{{ $errors->first('rate') }}</span>
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

