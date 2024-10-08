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
                    Trang cá nhân
                </div>
                <div class="card-body">
                    <form action="{{ route('account.updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên người dùng</label>
                            <input type="text" value="{{ old('name',$user->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" id="" />
                            @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Email</label>
                            <input type="text" value="{{ $user->email }}" class="form-control" placeholder="Email"  name="email" id="email" readonly/>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Ảnh</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                            @if (Auth::user()->image != "")
                            <img src="{{ asset('uploads/profile/thumb/'.Auth::user()->image) }}" class="img-fluid mt-4" alt="">                        
                            @endif
                        </div>   
                        <button class="btn btn-primary mt-2">Cập nhật</button> 
                    </form>                    
                </div>
            </div>                
        </div>
    </div>       
</div>
@endsection