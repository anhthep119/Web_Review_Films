<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

    //Show bình luận ở trong backend
    public function index(Request $request){
        $reviews = Review::with('film','user')->orderBy('created_at','DESC');
        
        if(!empty($request->keyword)){
            $reviews = $reviews->where('review','like','%'.$request->keyword.'%');
        }
        
        $reviews = $reviews->paginate(10);

        return view('account.reviews.list',[
            'reviews' => $reviews
        ]);
    }

    public function edit($id){
        $review = Review::findOrFail($id);
        
        
        return view('account.reviews.edit',[
            'review' => $review
        ]);

    }
    public function updateReview($id, Request $request){
        
        $review = Review::findOrFail($id);

        
        $validator = Validator::make($request->all(),[
            'review' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->route('account.reviews.edit',$id)->withInput()->withErrors($validator);
        }

        $review->review = $request->review;
        $review->status = $request->status;
        $review->save();

        session()->flash('success','Cập nhật bình luận thành công.');
        return redirect()->route('account.reviews');
    }

    public function deleteReview(Request $request){
        
        $id = $request->id;
        $review = Review::find($id);
        
        if($review == null){

            session()->flash('error','Không tìm thấy bình luận!');
            return response()->json([
                'status' => false,
            ]);
        } else{
            $review->delete();

            session()->flash('success','Xóa thành công!');
            return response()->json([
                'status' => false,
            ]);
        }
    }
}