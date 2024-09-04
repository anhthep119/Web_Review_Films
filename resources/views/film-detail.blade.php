@extends('layouts.app')

@section('main')
<div class="container mt-3 ">
    <div class="row justify-content-center d-flex mt-5">
        <div class="col-md-12">
            <a href="{{ route('home') }}" class="text-decoration-none text-dark ">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp; <strong>Trang chủ</strong>
            </a>
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($film->image != '')
                        <img src="{{ asset('uploads/films/thumb/'.$film->image) }}" alt="" class="card-img-top">
                    @else
                        <img src="https://placehold.co/990x1400?text=Không có ảnh" alt="" class="card-img-top">
                    @endif
                </div>
                <div class="col-md-8">
                    @include('layouts.message')
                    <h3 class="h2 mb-3">{{ $film->title }}</h3>
                    <div class="h4 text-muted">{{ $film->author }}</div>
                    <div class="content mt-3">Năm sản xuất: 
                        {{ $film->year }}
                    </div>
                    <div class="content mt-3">
                        Thể loại: 
                        {{ $film->genre }}
                    </div>
                    <div class="content mt-3">
                        Quốc gia: 
                        {{ $film->country }}
                    </div>
                    <div class="star-rating d-inline-flex ml-2" title="">
                        <span class="rating-text theme-font theme-yellow">5.0</span>
                        <div class="star-rating d-inline-flex mx-2" title="">
                            <div class="back-stars ">
                                <i class="fa fa-star " aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>

                                <div class="front-stars" style="width: 100%">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <span class="theme-font text-muted">(0 Review)</span>
                    </div>

                
                    <div class="content mt-3">
                        {{ $film->description }}
                    </div>

                    <div class="col-md-12 pt-2">
                        <hr>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h2 class="h3 mb-4">Người đánh giá cũng đã thích</h2>
                        </div>

                        @if ($relatedFilms->isNotEmpty())
                        @foreach ($relatedFilms as $relatedFilm)
                        <div class="col-md-4 col-lg-4 mb-4">
                            <div class="card border-0 shadow-lg">

                                <a href="{{ route('film.detail',$relatedFilm->id) }}">
                                @if ($relatedFilm->image != '')
                                    <img src="{{ asset('uploads/films/thumb/'.$relatedFilm->image) }}" alt="" class="card-img-top">
                                @else
                                    <img src="https://placehold.co/990x1400?text=Không có ảnh" alt="" class="card-img-top">
                                @endif
                                </a>
                                <div class="card-body">
                                    <h3 class="h4 heading"><a href="{{ route('film.detail',$relatedFilm->id) }}">{{ $relatedFilm->title }}</a></h3>
                                    <p>{{ $relatedFilm->title }}</p>
                                    <div class="star-rating d-inline-flex ml-2" title="">
                                        <span class="rating-text theme-font theme-yellow">0.0</span>
                                        <div class="star-rating d-inline-flex mx-2" title="">
                                            <div class="back-stars ">
                                                <i class="fa fa-star " aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
            
                                                <div class="front-stars" style="width: 70%">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="theme-font text-muted">(0)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        @endif

                        
                                
                    </div>
                    <div class="col-md-12 pt-2">
                        <hr>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-12  mt-4">
                            <div class="d-flex justify-content-between">
                                <h3>Bình luận</h3>
                                <div>
                                    @if (Auth::check())
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        Thêm bình luận
                                      </button>
                                      @else
                                      <a href="{{ route('account.login') }}" class="btn btn-primary">Thêm bình luận</a>
                                    @endif
                                    
                                      
                                </div>
                            </div>                        

                            @if ($film->reviews->isNotEmpty())
                                @foreach ($film->reviews as $review)
                                <div class="card border-0 shadow-lg my-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="mb-3">{{ $review->user->name}}</h4>
                                            <span class="text-muted">
                                                {{ \Carbon\Carbon::parse($review->created_at)->format('d M, Y') }}
                                            </span>          
                                        </div>
                                        @php
                                            $ratingPer = ($review->rating/5)*100;
                                        @endphp
                                       
                                        <div class="mb-3">
                                            <div class="star-rating d-inline-flex" title="">
                                                <div class="star-rating d-inline-flex " title="">
                                                    <div class="back-stars ">
                                                        <i class="fa fa-star " aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                    
                                                        <div class="front-stars" style="width: {{ $ratingPer }}">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                                               
                                        </div>
                                        <div class="content">
                                            <p>{{ $review->review }}</p>
                                        </div>
                                    </div>
                                </div> 
                                @endforeach    
                                @else
                                <div>
                                    Không tìm thấy bình luận
                                </div>
                             
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>   

<!-- Modal -->
<div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm bình luận cho phim <strong></strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="filmReviewForm" name="filmReviewForm">
                <input type="hidden" name="film_id" value="{{ $film->id }}">
                <div class="modal-body">
               
                    <div class="mb-3">
                        <label for="" class="form-label">Bình luận</label>
                        <textarea name="review" id="review" class="form-control @error('review') is-invalid @enderror" cols="5" rows="5" placeholder="Nhập bình luận trên 10 ký tự"></textarea>
                        <p class="invalid-feedback" id="review-error"></p>
                    </div>
                    <div class="mb-3">
                        <label for=""  class="form-label">Đánh giá</label>
                        <select name="rating" id="rating" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
               
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Bình luận</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
    $("#filmReviewForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: '{{ route("film.saveReview") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: $("#filmReviewForm").serializeArray(),
            success:function(respone){
                if(respone.status == false){
                    var errors = respone.errors;
                    if(errors.review){
                        $("review").addClass(is-invalid);
                        $("#review-error").html(errors.review);
                    } else{
                        $("review").removeClass(is-invalid);
                        $("#review-error").html('');
                    }
                } else{
                    window.location.href='{{ route("film.detail",$film->id) }}'
                }
            }
        })
    })
</script>

@endsection