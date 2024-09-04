<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    //Show trang đăng ký
    public function register(){
        return view('account.register');
    }

    //Đăng ký cho user
    public function progessRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('account.login')->with('success','Đăng ký thành công');
    }

    
    public function login(){
        return view('account.login');
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('account.profile');
        } else{
            return redirect()->route('account.login')->with('error','Sai Email hoặc mật khẩu!');

        }
    }

    //Show trang cá nhân user
    public function profile(){ 
        $user = User::find(Auth::user()->id);
        //dd($user);
        return view('account.profile',[
            'user' => $user
        ]);
    }

    //Update user
    public function updateProfile(Request $request){

        $rules = [
            'name' => 'required|min:3',
            
        ];
        
        if(!empty($request->image)){
            $rules['image'] = 'image';
        }
        
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->route('account.profile')->withInput()->withErrors($validator);
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->save();

        //Update ảnh
        if(!empty($request->image)){

            //Xóa ảnh cũ
            File::delete(public_path('uploads/profile/'.$user->image));
            File::delete(public_path('uploads/profile/thumb/'.$user->image));

            $image = $request->image;
            $ext=$image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move(public_path('uploads/profile'),$imageName);

            $user->image = $imageName;
            $user->save();

            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/profile/'.$imageName));

            $img->cover(150, 150);
            $img->save(public_path('uploads/profile/thumb/'.$imageName));
        }
        
        return redirect()->route('account.profile')->with('success','Cập nhật thành công!');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function myReviews(Request $request){

        $reviews = Review::with('film')->where('user_id',Auth::user()->id)->orderBy('created_at','DESC');
          
        if(!empty($request->keyword)){
            $reviews = $reviews->where('review','like','%'.$request->keyword.'%');
        }
        
        $reviews = $reviews->paginate(5);
            
        return view('account.my-reviews.my-reviews',[
            'reviews' => $reviews
        ]);
    }


    //SHow trang edit review
    public function editReview($id){
        $review = Review::where([
           'id' => $id,
           'user_id' => Auth::user()->id
        ])->with('film')->first();
        
        return view('account.my-reviews.edit-review',[
            'review' => $review
        ]);
    }

    //Update bình luận
    public function updateReview($id, Request $request){
        
        $review = Review::findOrFail($id);

        
        $validator = Validator::make($request->all(),[
            'review' => 'required',
            'rating' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->route('account.myReviews.editReview',$id)->withInput()->withErrors($validator);
        }

        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->save();

        session()->flash('success','Cập nhật bình luận thành công.');
        return redirect()->route('account.myReviews');
    }

    public function deleteReview(Request $request){
        
        $id = $request->id;
        
        $review = Review::find($id);

        if($review == null){
            return response()->json([
               'status' => false 
            ]);
        }

        $review->delete();

        session()->flash('success','Xóa bình luận thành công.');
        
        return response()->json([
            'status' => true,
            'message' => 'Xóa bình luận thành công.'
         ]);

    }


}