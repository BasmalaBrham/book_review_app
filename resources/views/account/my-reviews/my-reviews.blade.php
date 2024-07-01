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
                    My Reviews
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-end">
                        <form action="" method="get">
                            <div class="d-flex">
                                <input type="text" class="form-control" name="keyword" placeholder="keyword" value="{{Request::get('keyword')}}">
                                <button type="submit" class="btn btn-primary ms-2">search</button>
                                <a href="{{route('account.myReviews')}}" class="btn btn-secondary ms-2">clear</a>
                            </div>
                        </form>
                    </div>
                    <table class="table  table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Book</th>
                                <th>Review</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                            <tbody>
                                @if (!empty($reviews))
                                @foreach ( $reviews as $review )
                                    <tr>
                                        <td>{{$review->book->title}}</td>
                                        <td>{{$review->review}}</td>
                                        <td>{{$review->rate}}</td>
                                        <td>
                                            @if ($review->status==1)
                                            <span class="text-success">Active</span>
                                            @else
                                            <span class="text-danger">Block</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('account.myReviews.editReview',$review->id)}}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            {{-- <a href="javascript:void();" onclick="deleteReview({{$review->id}})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
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
<script type="text/javascript">
    function deleteReview(id){
        if(confirm('Are You Sure You Want To Delete')){
            $.ajax({
                url:'{{route("account.myReviews.deleteReview")}}',
                type:'',
                data:(id:id),
                headers:{
                    'X-SCRF-TOKEN':'{{scrf_token()}}'
                },
                dataType: 'jason',
                success: function(response){
                    window.location.href='{{route("account.myReviews")}}'
                }
            })
        }
    }
</script>
@endsection --}}
<a href="javascript:void(0);" onclick="deleteReview({{$review->id}})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
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
<script type="text/javascript">
    function deleteReview(id){
        if(confirm('Are You Sure You Want To Delete')){
            $.ajax({
                url: '{{ url("account/delete-my-reviews") }}/' + id,
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response){
                    if(response.status){
                        window.location.href = '{{ route("account.myReviews") }}';
                    } else {
                        alert('Failed to delete the review.');
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
