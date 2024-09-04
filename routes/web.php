<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/film/{id}',[HomeController::class,'detail'])->name('film.detail');
Route::post('/save-film-review',[HomeController::class,'saveReview'])->name('film.saveReview');


Route::group(['prefix' => 'account'], function(){
    Route::group(['middleware' => 'guest'],function(){
        Route::get('register',[AccountController::class,'register'])->name('account.register');
        Route::post('register',[AccountController::class,'progessRegister'])->name('account.progessRegister');
        Route::get('login',[AccountController::class,'login'])->name('account.login');
        Route::post('login',[AccountController::class,'authenticate'])->name('account.authenticate');
    });
    Route::group(['middleware' => 'auth'],function(){
        Route::get('profile',[AccountController::class,'profile'])->name('account.profile');
        Route::get('logout',[AccountController::class,'logout'])->name('account.logout');
        Route::post('update-profile',[AccountController::class,'updateProfile'])->name('account.updateProfile');
  
        
        Route::group(['middleware' => 'check-admin'],function(){
             //Route Show phim
            Route::get('films',[FilmController::class,'index'])->name('films.index');
            
            //Route Thêm mới phim
            Route::get('films/create',[FilmController::class,'create'])->name('films.create');
            Route::post('films',[FilmController::class,'store'])->name('films.store');
            
            //Route Chỉnh sửa bộ phim
            Route::get('films/edit/{id}',[FilmController::class,'edit'])->name('films.edit');
            Route::post('films/edit/{id}',[FilmController::class,'update'])->name('films.update');
            
            //Route xóa bộ phim
            Route::post('delete-films',[FilmController::class,'destroy'])->name('films.destroy');
        
            //Route phần bình luận admin
            Route::get('reviews',[ReviewController::class,'index'])->name('account.reviews');
            Route::get('reviews/{id}',[ReviewController::class,'edit'])->name('account.reviews.edit');
            Route::post('reviews/{id}',[ReviewController::class,'updateReview'])->name('account.reviews.updateReview');
            Route::post('delete-review',[ReviewController::class,'deleteReview'])->name('account.reviews.deleteReview');
        
        });
       

        
        Route::get('my-reviews',[AccountController::class,'myReviews'])->name('account.myReviews');
        
        Route::get('my-reviews/{id}',[AccountController::class,'editReview'])->name('account.myReviews.editReview');
        Route::post('my-reviews/{id}',[AccountController::class,'updateReview'])->name('account.myReviews.updateReview');
        Route::post('delete-my-review',[AccountController::class,'deleteReview'])->name('account.myReviews.deleteReview');


    });
});