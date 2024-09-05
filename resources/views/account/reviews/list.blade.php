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

            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                    My Reviews
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-end">
                        <form action="" method="get">
                            <div class="d-flex">
                                <input type="text" class="form-control" name="keyword" placeholder="keyword" value="{{Request::get('keyword')}}">
                                <button type="submit" class="btn btn-primary ms-2">search</button>
                                <a href="{{route('account.reviews')}}" class="btn btn-secondary ms-2">clear</a>
                            </div>
                        </form>
                    </div>
                    <table class="table  table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Review</th>
                                <th>Book</th>
                                <th>Rating</th>
                                <th>created_at</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                            <tbody>
                                @if (!empty($reviews))
                                    @foreach ( $reviews as $review )
                                        <tr>
                                            <td>{{$review->review}}<br><strong>{{$review->user->name}}</strong></td>
                                            <td>{{$review->book->title}}</td>
                                            <td>{{$review->rate}}</td>
                                            <td>{{\Carbon\Carbon::parse($review->created_at)->format('d M,Y')}}</td>
                                            <td>
                                                @if ($review->status==1)
                                                    <span class="text-success">Active</span>
                                                @else
                                                <span class="text-danger">Block</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('account.reviews.edit', $review->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <a href="#" onclick="deleteReview({{ $review->id }})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </thead>
                    </table>
                        {{$reviews->links()}}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@section('script')
<script>
    function deleteReview(id) {
        if (confirm("Are you sure you want to delete this review?")) {
            $.ajax({
                url: '{{ route("account.reviews.deleteReview") }}',
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status) {
                        window.location.href = '{{ route("account.reviews") }}';
                    } else {
                        alert('Failed to delete review.');
                    }
                },
                error: function(xhr) {
                    alert('An error occurred while deleting the review.');
                }
            });
        }
    }
</script>
@endsection
