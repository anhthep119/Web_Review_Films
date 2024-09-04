<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class FilmController extends Controller
{
    //Show trang danh sách các bộ phim
    public function index(Request $request){

        $films = Film::orderBy('created_at','DESC');

        if(!empty($request->keyword)){
            $films->where('title','like','%'.$request->keyword.'%');
        }
       
        $films = $films->paginate(5);

        return view('films.list',[
            'films' => $films
        ]);
    }
    
    //Show trang thêm mới bộ phim
    public function create(){
        return view('films.create');
    }
    
    //Lưu trữ phim được thêm vào database
    public function store(Request $request){

        $rules = [
            'title' => 'required|min:5',
            'author' => 'required|min:3',
            'year' => 'required|digits:4',
            'genre' => 'required',
            'country' => 'required',
            'status' => 'required',
        ];

        if(!empty($request->image)){
            $rules['image'] = 'image';
        }
        
        $validator = Validator::make($request->all(),$rules);
        
        if($validator->fails()){
            return redirect()->route('films.create')->withInput()->withErrors($validator);
        }

        //Lưu phim trong Database
        $film = new Film();
        $film->title = $request->title;
        $film->description = $request->description;
        $film->author = $request->author;
        $film->year = $request->year;
        $film->genre = $request->genre;
        $film->country = $request->country;
        $film->status = $request->status;
        $film->save();
        
        //Upload ảnh phim
        if(!empty($request->image)){
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move(public_path('uploads/films'),$imageName);
            
            $film->image = $imageName;
            $film->save();

            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/films/'.$imageName));

            $img->resize(990);
            $img->save(public_path('uploads/films/thumb/'.$imageName));
        }

        return redirect()->route('films.index')->with('success','Bạn đã thêm mới phim thành công!');

    }

    //Show trang edit phim
    public function edit($id){
        
        $film = Film::findOrFail($id);
        return view('films.edit',[
            'film' => $film,
        ]);
    }
    
    //Update phim
    public function update($id, Request $request){
        
        $film = Film::findOrFail($id);

        $rules = [
            'title' => 'required|min:5',
            'author' => 'required|min:3',
            'year' => 'required|digits:4',
            'genre' => 'required',
            'country' => 'required',
            'status' => 'required',
        ];

        if(!empty($request->image)){
            $rules['image'] = 'image';
        }
        
        $validator = Validator::make($request->all(),$rules);
        
        if($validator->fails()){
            return redirect()->route('films.edit',$film->id)->withInput()->withErrors($validator);
        }

        //cập nhật phim trong Database
        
        $film->title = $request->title;
        $film->description = $request->description;
        $film->author = $request->author;
        $film->year = $request->year;
        $film->genre = $request->genre;
        $film->country = $request->country;
        $film->status = $request->status;
        $film->save();
        
        //Upload ảnh phim
        if (!empty($request->image)) {

            //Method xóa ảnh cũ khỏi thư viện ảnh khi cập nhật ảnh mới
            File::delete(public_path('uploads/films/'.$film->image));
            File::delete(public_path('uploads/films/thumb/'.$film->image));
            
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move(public_path('uploads/films'),$imageName);
            
            $film->image = $imageName;
            $film->save();


            //chuyển ảnh thu nhỏ
            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/films/'.$imageName));
            $img->resize(990);
            $img->save(public_path('uploads/films/thumb/'.$imageName));
        }

        return redirect()->route('films.index')->with('success','Bạn đã cập nhật phim thành công!');
    }
    
    //Xóa phim khỏi database
    public function destroy(Request $request){
        // $film = Film::find($request->id);

        // if($film == null){

        //     session()->flash('error','Không tìm thấy phim bạn chọn!');
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Không tìm thấy phim bạn yêu cầu!'
        //     ]);
        // } else {
            
        //     File::delete(public_path('uploads/films/'.$film->image));
        //     File::delete(public_path('uploads/films/thumb/'.$film->image));
        //     $film->delete();

        //     session()->flash('success','Bạn đã xóa thành công!');
        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Bạn đã xóa thành công!'
        //     ]);
        // }
        $id = $request->id;
        $film = Film::find($id);
        
        if($film == null){

            session()->flash('error','Không tìm thấy phim bạn chọn!');
            return response()->json([
                'status' => false,
            ]);
        } else{
            File::delete(public_path('uploads/films/'.$film->image));
            File::delete(public_path('uploads/films/thumb/'.$film->image));
            $film->delete();
            

            session()->flash('success','Xóa thành công!');
            return response()->json([
                'status' => false,
            ]);
        }
        
    }
}