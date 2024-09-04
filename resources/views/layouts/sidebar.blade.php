<div class="card border-0 shadow-lg">
    <div class="card-header  text-white">
        Chào mừng, {{ Auth::user()->name }}                        
    </div>
    <div class="card-body">
        <div class="text-center mb-3">
            @if (Auth::user()->image != "")
            <img src="{{ asset('uploads/profile/thumb/'.Auth::user()->image) }}" class="img-fluid rounded-circle" alt="">                        
            @endif
        </div>
        <div class="h5 text-center">
            <strong>{{ Auth::user()->name }}</strong>
            <p class="h6 mt-2 text-muted">5 Reviews</p>
        </div>
    </div>
</div>
<div class="card border-0 shadow-lg mt-3">
    <div class="card-header  text-white">
        Menu
    </div>
    <div class="card-body sidebar">
        <ul class="nav flex-column">
            @if (Auth::user()->role == 'admin')
            <li class="nav-item">
                <a href="{{ route('films.index') }}">Quản lý phim</a>                               
            </li>
            <li class="nav-item">
                <a href="{{ route('account.reviews') }}">Quản lý bình luận</a>                               
            </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('account.profile') }}">Trang cá nhân</a>                               
            </li>
            <li class="nav-item">
                <a href="{{ route('account.myReviews') }}">Các đánh giá của tôi</a>
            </li>
            <li class="nav-item">
                <a href="change-password.html">Đổi mật khẩu</a>
            </li> 
            <li class="nav-item">
                <a href="{{ route('account.logout') }}">Đăng xuất</a>
            </li>                           
        </ul>
    </div>
</div>