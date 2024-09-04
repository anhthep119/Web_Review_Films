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
                    Danh sách Phim
                </div>
                <div class="card-body pb-0">
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('films.create') }}" class="btn btn-primary">+ Thêm mới</a>                
                            <form action="" method="GET">
                                <div class="d-flex">
                                    <input type="text" class="form-control" value="{{ Request::get('keyword') }}" name="keyword" placeholder="Nhập tên phim">
                                    <button type="submit" class="btn btn-primary ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    <a href="{{ route('films.index') }}" class="btn btn-secondary ms-2"><i class="fa-solid fa-rotate-left"></i></a>
                                </div> 
                            </form>             
                    </div>
                    
                    <table class="table  table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Tên phim</th>
                                <th>Hãng sản xuất</th>
                                <th>Đánh giá</th>
                                <th>Trạng thái</th>
                                <th width="150">Hành động</th>
                            </tr>
                            <tbody>
                                @if ($films->isNotEmpty())
                                    @foreach ($films as $film)
                                    <tr>
                                        <td>{{ $film->title }}</td>
                                        <td>{{ $film->author }}</td>
                                        <td>3.0 (3 Reviews)</td>
                                        <td>
                                            @if ($film->status == 1)
                                                <span class="text-success">Được duyệt</span>
                                            @else
                                                <span class="text-danger">Chưa duyệt</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-success btn-sm"><i class="fa-regular fa-star"></i></a>
                                            <a href="{{ route('films.edit',$film->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="" onclick="deleteFilm({{ $film->id }});" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5">
                                            Không tìm thấy danh sách phim
                                        </td>
                                    </tr>
                                @endif
                                
                                
                            </tbody>
                        </thead>
                    </table> 
                    @if ($films->isNotEmpty())
                        {{ $films->links() }}
                    @endif  
                    
                </div>
                
            </div>                
        </div>
    </div>       
        </div>
    </div>       
</div>
@endsection

@section('script')

<script>
    function deleteFilm(id){
        if(confirm("Bạn có chắc chắn muốn xóa bộ phim này không?")){
            $.ajax({
                url: '{{ route("films.destroy") }}',
                data: {id:id},
                type: 'post',
                headers:{
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },
                success: function(response){
                    window.location.href = '{{ route("films.index") }}';
                }

            });
        }
    }
</script>

@endsection