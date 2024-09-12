<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index( Request $request){
        $books=Book::withCount('reviews')->withSum('reviews','rate')->orderBy('created_at','Desc');

        if(!empty($request->keyword)){
            $books->where('title','like','%'.$request->keyword.'%');
        }
        $books= $books->where('status',1)->paginate(8);
        return view('home',[
            'books'=>$books
        ]);
    }

    //to show book details
    public function details($id){
        $book = Book::with(['reviews.user','reviews'])->withCount('reviews')->withSum('reviews','rate')->findOrFail($id);
        if($book->status == 0){
            abort(404);
        }
        $relatedBooks = Book::where('status',1)->withCount('reviews')->withSum('reviews','rate')->take(3)->where('id','!=',$id)->inRandomOrder()->get();
        return view('BookDetails',['book'=>$book,'relatedBooks'=>$relatedBooks]);
    }
    //to save review in db
    public function saveReview(Request $request) {
        $validator = Validator::make($request->all(), [
            'review' => 'required|min:5',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $countReview = Review::where('users_id', Auth::user()->id)->where('books_id', $request->book_id)->count();
        if ($countReview > 0) {
            session()->flash('error', 'You have already submitted a review');
            return response()->json([
                'status' => true,
            ]);
        }
        $review = new Review();
        $review->review = $request->review;
        $review->rate = $request->rating;
        $review->users_id = Auth::user()->id;
        $review->books_id = $request->book_id;
        $review->save();

        session()->flash('success', 'Review submitted successfully');
        return response()->json([
            'status' => true,
        ]);
    }

}
