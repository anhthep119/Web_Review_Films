<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    //Show trang chủ
    public function index(Request $request){

        $films = Film::orderBy('created_at','DESC');
        
        if(!empty($request->keyword)){
            $films->where('title','like','%'.$request->keyword.'%');      
        }

        
       $films = $films->where('status',1)->paginate(8);

        
        return view('home',[
            'films' => $films
        ]);
    }


    //SHow trang xem chi tiêt phim
    public function detail($id){
        
        $film = Film::with(['reviews.user','reviews' => function($query){
            $query->where('status',1);
        }])->findOrFail($id);
        
        if($film->status == 0){
            abort(404);
        }

        $relatedFilms = Film::where('status',1)->take(3)->where('id','!=',$id)->inRandomOrder()->get();

        return view('film-detail',[
            'film' => $film,
            'relatedFilms' => $relatedFilms
        ]);
    }

    //Lưu lại bình luận
    public function saveReview(Request $request){
        $validator = Validator::make($request->all(),[
            'review' => 'required|min:10',
            'rating' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' =>$validator->errors()
            ]);
        }

        $countReview = Review::where('user_id',Auth::user()->id)->where('film_id',$request->film_id)->count();
        
        if($countReview > 0 ){
            session()->flash('error','Bạn đã bình luận về bộ phim này rồi!.');
            return response()->json([
                'status' => true,
                
            ]);
        }

        $review = new Review();
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->user_id = Auth::user()->id;
        $review->film_id = $request->film_id;
        $review->save();

        session()->flash('success','Thêm bình luận thành công.');
        
        return response()->json([
            'status' => true,
            
        ]);
        
    }
}