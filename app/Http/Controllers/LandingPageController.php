<?php

namespace ICTDUInventory\Http\Controllers;

use Illuminate\Http\Request;
use ICTDUInventory\Book;
use ICTDUInventory\Course;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;

class LandingPageController extends Controller
{
    public function home() {
    	$sort = 0;
    	$books = Book::orderBy('year_published', 'desc')->paginate(8);
    	return view ('welcome')
    			->withBooks($books)
    			->withSort($sort);
    }

    public function search(){
    	$q = Input::get ( 'q' );
	    if($q != ""){
	    $book = Book::where ( 'title', 'LIKE', '%' . $q . '%' )->orWhere ( 'year_published', 'LIKE', '%' . $q . '%' )->paginate (8)->setPath ( '' );
	    $pagination = $book->appends ( array (
	                'q' => Input::get ( 'q' ) 
	        ) );
	    if (count ( $book ) > 0)
	        return view ( 'welcome' )->withBooks ( $book )->withQuery ( $q );
	    }
	        return view ( 'welcome' )->with( 'searchMessage', 'No Details found. Try to search again !' )->withQuery ( $q );
    }

    public function sortByYear() {
    	if(Input::get('sort_i') == ""){
	    	$books = Book::orderBy('year_published', 'desc')->paginate(8);
	    	$pagination = $books->appends( array (
	    		'sort_i' => Input::get ( 'sort_i' )
	    	));
	    	return view('welcome')
    			->withBooks($books)
    			->withSort('asc');
	    } 

    	$sort_i = Input::get('sort_i');

    	$books = Book::orderBy('year_published', $sort_i)->paginate(8);
    	$pagination = $books->appends ( array (
	                'sort_i' => Input::get ( 'sort_i' ) 
	        ) );

    	return view('welcome')
    			->withBooks($books);

	    /*$sort = 0;
	    $sort_i = Input::get('sort_i');
	    if($sort_i == 0){
	    	$books = Book::orderBy('year_published', 'asc')->paginate(8);
	    	$pagination = $books->appends( array (
	    		'sort_i' => 'asc'
	    	));
	    	$sort = 0;
	    } 

    	return view ( 'welcome' )
    			->withBooks($books)
    			->withSort($sort);*/
    }

    public function newlyAdded(Request $request) {
    	$bookArr = [];
    	$x = 1;
    	$books = Book::orderBy('year_published', 'desc')->get();

    	foreach ($books as $row) {
    		if ($x == 41) {
    			break;
    		}
    		$bookArr[$x++] = [
    			'id' => $row->id,
    			'title' => $row->title,
    			'author' => $row->author,
    			'year_published' => $row->year_published,
    			'course' => $row->course['name'],
    			'availability' => $row->availability,
    			'with_cd' => $row->with_cd,
    			'created_at' => $row->created_at,
    			'updated_at' => $row->updated_at
    		];
    	}

    	$bookArr = json_decode(json_encode($bookArr));

    	// Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
 
        // Create a new Laravel collection from the array data
        $itemCollection = collect($bookArr);
 
        // Define how many items we want to be visible in each page
        $perPage = 8;
 
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath($request->url());
 
        return view('newly-added', ['books' => $paginatedItems]);
    }

    public function azList() {
    	$books = Book::orderBy('title', 'asc')->paginate(8);
    	return view('a-z-list')
    			->with('books', $books);
    }

    public function course($id) {
    	$books = Book::where('course_id', $id)->paginate(8);
    	$course = Course::find($id);
    	$courseName = $course->name;

    	return view('course')
    			->with('books', $books)
    			->with('courseName', $courseName);
    }
}
