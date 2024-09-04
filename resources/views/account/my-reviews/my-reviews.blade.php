@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            @include('layouts.message')
            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                    Các bình luận của tôi
                </div>
                <div class="card-body pb-0">  
                    <div class="d-flex justify-content-end">
                        <form action="" method="GET">
                            <div class="d-flex">
                                <input type="text" class="form-control" value="{{ Request::get('keyword') }}" name="keyword" placeholder="Nhập từ khóa">
                                <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                <a href="{{ route('account.myReviews') }}" class="btn btn-secondary ms-2"><i class="fa-solid fa-rotate-left"></i></a>
                            </div> 
                        </form>             
                </div>                
                    <table class="table  table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Phim</th>
                                <th>Bình luận</th>
                                <th>Đánh giá</th>
                                <th>Trạng thái</th>                                  
                                <th width="100">Hành động</th>
                            </tr>
                            <tbody>
                                @if ($reviews->isNotEmpty())
                                    @foreach ($reviews as $review)
                                    <tr>
                                        <td>{{ $review->film->title }}</td>
                                        <td>{{ $review->review }}</td>                                        
                                        <td>{{ $review->rating }} <i class="fa-regular fa-star"></i></td>
                                        <td>
                                            @if ($review->status ==1)
                                            <span class="text-success">Được duyệt</span>    
                                            @else
                                            <span class="text-danger">Chưa được duyệt</span>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('account.myReviews.editReview',$review->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="javascript:void(0);" onclick="deleteReview({{ $review->id }});" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                                
                                                                   
                            </tbody>
                        </thead>
                    </table>   
                   {{ $reviews->links() }}             
                </div>
                
            </div>                
        </div>
    </div>       
</div>
@endsection

@section('script')
    <script type="text/javascript">
    function deleteReview(id) {
        if(confirm("Bạn có chắc chắn muốn xoa bình luận không?")){
            $.ajax({
                url: '{{ route("account.myReviews.deleteReview") }}',
                type: 'post',
                data: {id:id},
                headers: {
                    'x-csrf-token' : '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response){
                    window.location.href = '{{ route("account.myReviews") }}'
                }
            })
        }
    }
    </script>
@endsection