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
                    Thêm mới phim
                </div>
                <div class="card-body">
                    <form action="{{ route('films.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Tên phim</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Nhập tên phim" name="title" id="title" value="{{ old('title') }}" />
                            @error('title')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Nhà sản xuất</label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" placeholder="Nhập nhà sản xuất hoặc đạo diễn"  name="author" id="author" value="{{ old('author') }}"/>
                            @error('author')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Năm sản xuất</label>
                            <input type="text" class="form-control @error('year') is-invalid @enderror" placeholder="Nhập năm sản xuất"  name="year" id="year" value="{{ old('year') }}"/>
                            @error('year')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="genre" class="form-label">Thể loại</label>
                            <input type="text" class="form-control @error('genre') is-invalid @enderror" placeholder="Nhập thể loại phim"  name="genre" id="genre" value="{{ old('genre') }}"/>
                            @error('genre')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Quốc gia</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" placeholder="Nhập quốc gia"  name="country" id="country" value="{{ old('country') }}"/>
                            @error('country')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Mô tả nội dung</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Nhập mô tả" cols="30" rows="5">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="Image" class="form-label">Ảnh</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"  name="image" id="image"/>
                            @error('image')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Trạng thái</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">Được duyệt</option>
                                <option value="0">Chưa duyệt</option>
                            </select>
                        </div>


                        <button class="btn btn-primary mt-2">+ Thêm mới</button> 
                    </form>                    
                </div>
            </div>                
        </div>
    </div>                       
    </div>              
</div>
@endsection