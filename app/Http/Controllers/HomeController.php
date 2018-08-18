<?php

namespace ICTDUInventory\Http\Controllers;

use Illuminate\Http\Request;
use ICTDUInventory\Book;
use ICTDUInventory\Course;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*
        $allBooks = Book::all();
        $books = Book::paginate(1);
        return view('home')->withBooks($books)->with('allBooks', $allBooks);
        http://localhost:8000/home?page=2
        */
        $day7 = \Carbon\Carbon::today()->subDays(30);

        $isActive = $request->get('page', 1);
        $page = 1;
        $allBooks = Book::all();
        $items = $request->items ?? 10;
        $books = Book::all();
        $courses = Course::all();
        //$books = Book::paginate($items);
        //$books->withPath('custom/url');

        return view('home')
              ->with('books', $books)
              ->with('items', $items)
              ->with('allBooks', $allBooks)
              ->with('page', $page)
              ->with('isActive', $isActive)
              ->with('day7', $day7)
              ->with('courses', $courses);
    }
    
}
