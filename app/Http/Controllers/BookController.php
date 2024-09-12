<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class BookController extends Controller
{
    //to show books listing page
    public function index(Request $request){
        $books= Book::orderBy('created_at','DESC');
        if(!empty($request->keyword)){
            $books->where('title','like','%'.$request->keyword.'%');
        }
        $books=$books->withCount('reviews')->withSum('reviews','rate')->paginate(3);
        return view('books.list',[
            'books'=>$books
        ]);
    }

    //to create new book
    public function create(){
        return view('books.create');
    }

    //to store book in database
    public function store(Request $request){
        $ruls=[
            'title'=>'required|min:5',
            'author'=>'required|min:3',
            'status'=>'required'
        ];
        if(!empty($request->image)){
            $ruls['image']='image';
        }
        $validator=Validator::make($request->all(), $ruls);
        if ($validator->fails()) {
            return redirect()->route('books.create')->withInput()->withErrors($validator);
        }
        //to save book in db
        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();
        //upload image
        if ($request->hasFile('image')){
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('upload/books'), $imageName);
            $book->image = $imageName;
            $book->save();
        }
        return redirect()->route('books.index')->with('success','book added successfuly');
    }

    //to show edit book page
    public function edit($id){
        $book=Book::findOrFail($id);
        return view('books.edit',['book'=>$book]);

    }

    //to update book
    public function update($id,Request $request){
        $book=Book::findOrFail($id);
        $ruls=[
            'title'=>'required|min:5',
            'author'=>'required|min:3',
            'status'=>'required'
        ];
        if(!empty($request->image)){
            $ruls['image']='image';
        }
        $validator=Validator::make($request->all(), $ruls);
        if ($validator->fails()) {
            return redirect()->route('books.edit',$book->id)->withInput()->withErrors($validator);
        }

        // to update book in db
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();
        if ($request->hasFile('image')){
            //to delet old image
            File::delete(public_path('upload/books'.$book->image));

            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('upload/books'), $imageName);
            $book->image = $imageName;
            $book->save();
        }
        return redirect()->route('books.index')->with('success','book updated successfuly');

    }

    //to delete book
    public function destroy(Request $request){
        $book=Book::find($request->id);
        if($book==null){
            session()->flash('error','book not found');
            return response()->json([
                'status'=>false,
                'message'=>'book not found'
            ]);
        }else{
            File::delete(public_path('upload/books/'.$book->image));
            $book->delete();
            session()->flash('success','book deleted successfully');
            return response()->json([
                'status'=>true,
                'message'=>'book deleted successfully'
            ]);
        }
    }

}
