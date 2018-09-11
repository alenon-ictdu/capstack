<?php

namespace ICTDUInventory\Http\Controllers;

use Illuminate\Http\Request;
use ICTDUInventory\Book;
use Session;
use Image;
use Storage;
use Hash;
use ICTDUInventory\Borrower;
use ICTDUInventory\Course;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard() {
        $latestBooks = Book::orderBY('year_published', 'desc')->paginate('3');
        $books = Book::all();
        $courses = COurse::all();
        $borrowers = Borrower::all();
        $borrowedBooks = 0;
        foreach($books as $row){
            if($row->availability == 0){
                $borrowedBooks = $borrowedBooks + 1;
            }
        }
        return view('dashboard')
            ->with('books', $books)
            ->with('courses', $courses)
            ->with('borrowers', $borrowers)
            ->with('borrowedBooks', $borrowedBooks)
            ->with('latestBooks', $latestBooks);
    }

    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();
        return view('books.create')
            ->with('courses', $courses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $yearNow = date("Y");
        $this->validate($request, [
            'title'                   =>               'required',
            'author'                  =>               'required',
            'year_published'          =>               'required|integer|between:1900,'.$yearNow,
            'bookpic'                 =>               'sometimes|image',
            'course'                  =>               'required'                                   
        ]);

        $book = New Book;

        $book->title = $request->title;
        $book->author = $request->author;
        $book->year_published = $request->year_published;
        $book->course_id = $request->course;
        // $book->availability = $request->has('available');
        $book->quantity = $request->quantity;
        $book->with_cd = $request->has('cd');
        if($request->hasFile('bookpic')){
                $image = $request->file('bookpic');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/' . $filename);
                Image::make($image)->save($location);
                $oldImage = $book->image; //old imagename

                $book->image = $filename; 
             
        }

        $book->save();

        Session::flash('success', 'Book successfully added.');
        return redirect()->route('home');
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);
        $courses = Course::all();
        return view('books.edit')
                ->with('book', $book)
                ->with('courses', $courses);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $yearNow = date("Y");
        $this->validate($request, [
            'title'                   =>               'required',
            'author'                  =>               'required',
            'year_published'          =>               'required|integer|between:1900,'.$yearNow,
            'bookpic'                 =>               'sometimes|image',
            'course'                  =>               'required'       
        ]);

        $book = Book::find($id);

        $book->title = $request->title;
        $book->author = $request->author;
        $book->year_published = $request->year_published;
        $book->course_id = $request->course;
        // $book->availability = $request->has('available');
        $book->quantity = $request->quantity;
        $book->with_cd = $request->has('cd');
        if($request->hasFile('bookpic')){
                $image = $request->file('bookpic');
                $filename = $id . '.' . time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/' . $filename);
                Image::make($image)->save($location);
                $oldImage = $book->image; //old imagename

                $book->image = $filename; 

                Storage::delete($oldImage); //delete old image
             
        }
        $book->save();

        Session::flash('success', 'Book successfully changed.');
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();

        Session::flash('success', 'Book has been deleted.');
        return redirect()->back();
    }

    public function storeAndNew(Request $request) 
    {
       $yearNow = date("Y");
        $this->validate($request, [
            'title'                   =>               'required',
            'author'                  =>               'required',
            'year_published'          =>               'required|integer|between:1900,'.$yearNow,
            'bookpic'                 =>               'sometimes|image',
            'course'                  =>               'required' 
        ]);

        $book = New Book;

        $book->title = $request->title;
        $book->author = $request->author;
        $book->year_published = $request->year_published;
        $book->course_id = $request->course;
        // $book->availability = $request->has('available');
        $book->quantity = $request->quantity;
        $book->with_cd = $request->has('cd');


        if($request->hasFile('bookpic')){
                $image = $request->file('bookpic');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/' . $filename);
                Image::make($image)->save($location);
                $oldImage = $book->image; //old imagename

                $book->image = $filename; 
             
            }

        $book->save();

        Session::flash('success', 'Book successfully added.');
        return redirect()->route('book.create');
    }

    public function updateAndView(Request $request, $id)
    {
        $yearNow = date("Y");
        $this->validate($request, [
            'title'                   =>               'required',
            'author'                  =>               'required',
            'year_published'          =>               'required|integer|between:1900,'.$yearNow,
            'bookpic'                 =>               'sometimes|image',
            'course'                  =>               'required'       
        ]);

        $book = Book::find($id);

        $book->title = $request->title;
        $book->author = $request->author;
        $book->year_published = $request->year_published;
        $book->course_id = $request->course;
        // $book->availability = $request->has('available');
        $book->quantity = $request->quantity;
        $book->with_cd = $request->has('cd');
        if($request->hasFile('bookpic')){
                $image = $request->file('bookpic');
                $filename = $id . '.' . time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/' . $filename);
                Image::make($image)->save($location);
                $oldImage = $book->image; //old imagename

                $book->image = $filename; 

                Storage::delete($oldImage); //delete old image
             
        }
        $book->save();

        Session::flash('success', 'Book successfully changed.');
        return redirect()->route('book.show', $book->id);
    }

    public function printBooks() {
      $books = Book::all();
        return view('books.printall')
                ->with('books', $books);
    }

    public function printSelectedBooks(Request $request) {
        $books = Book::all();
        $booksArr = array();
        $qrSelectedArray = array();   
        $x = 0;      

        array_shift($_POST);
        foreach ($_POST as $key => $value) {
            $book = Book::find($value);
            $booksArr[$x++] = [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'year_published' => $book->year_published,
                'course' => $book->course->name
            ];
        }

        $book_encoded = json_encode($booksArr);
        $book_decoded = json_decode($book_encoded);
        /*foreach ($_POST as $value) {
          

          $qrSelectedArray[] = $value;

        } */

        if (empty($booksArr)) {
             Session::flash('info', 'Please select a book to print.');
             return redirect()->back();
        }


        return view('books.printselectedqr')
                    ->with('selectedBooks',$book_decoded);
    }

    public function viewBorrowBook($id){
        $courses = Course::all();
        $book = Book::find($id);

        if ($book->quantity == 0) {
          Session::flash('borrow_warning', $book->id);
          return redirect()->route('home');
        }
        return view('books.borrow')
            ->with('book', $book)
            ->with('courses', $courses);
    }

    public function borrowBook(Request $request){

        $this->validate($request, [
            'book_id'                   =>               'required|numeric',
            'name'                 =>               'required|min:3',
            'deadline'                  =>               'required|date|after:yesterday'
        ]);

        $borrower = New Borrower;
        $book = Book::find($request->book_id);

        $borrower->book_id = $request->book_id;
        $borrower->name = $request->name;
        $borrower->address = $request->address;
        $borrower->contact = $request->contact;
        $borrower->deadline = $request->deadline;

        $borrower->save();

        // $book->availability = 0;
        $book->quantity = $book->quantity - 1;

        $book->save();

        Session::flash('isNew', $borrower->id);
        Session::flash('success', 'Book successfully borrowed.');
        return redirect()->route('view.borrowers');
    }

    public function viewBorrowers(){
      $borrowers = Borrower::all();
      return view('books.borrowers')
          ->with('borrowers', $borrowers);
    }

    public function destroyBorrowBook($id) {
        
        $borrower = Borrower::find($id);
        $book_id = $borrower->book_id;
        $book = Book::find($book_id);

        $borrower->delete();
        $book->quantity = $book->quantity + 1;
        $book->save();

        return redirect()->back();

    }

    public function editBorrowBook($id) {
        $borrower = Borrower::find($id);
        $book = Book::find($borrower->book_id);
        $courses = Course::all();

        return view('books.edit_borrow')
            ->with('borrower', $borrower)
            ->with('book', $book)
            ->with('courses', $courses);
    }

    public function updateBorrowBook(Request $request, $id) {
        $this->validate($request, [
            'book_id'                   =>               'required|numeric',
            'name'                 =>               'required|min:3',
            'deadline'                  =>               'required|date|after:yesterday'
        ]);

        $borrower = Borrower::find($id);
        $book = Book::find($request->book_id);

        $borrower->book_id = $request->book_id;
        $borrower->name = $request->name;
        $borrower->address = $request->address;
        $borrower->contact = $request->contact;
        $borrower->deadline = $request->deadline;

        $borrower->save();

        Session::flash('isNew', $borrower->id);
        Session::flash('success', 'Changes successfully saved.');
        return redirect()->route('view.borrowers');
    }

    /*public function bookBorrowed(){
        $books = Book::where('availability', '=', 0)
            ->orderBy('id', 'desc')->paginate(10);

        return view('books.borrowed')
            ->with('books', $books);

    }*/



    public function penalty() {
        $borrowers = Borrower::whereDate('deadline', '<', date("Y-m-d") )->orderBy('created_at', 'desc')->paginate(10);
        return view('books.penalty')
            ->with('borrowers', $borrowers);
    }

    public function backupBooks() {
        return view('books.backup');
    }

    public function exportBooks() {
        $books = Book::all();
        $dataToDownload = [];
        $csvName = 'Books.'.date("m.d.y.g:i");
        $x = 0;

        // output headers so that the file is downloaded rather than displayed
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename='.$csvName.'.csv');
         
        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');
         
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');

        // send the column headers
        fputcsv($file, array('ID', 'Title', 'Authors', 'Year Published', 'Course', 'CD'));

        foreach($books as $row) {
            $dataToDownload[$x++] = [
                'id' => $row->id,
                'title' => $row->title,
                'author' => $row->author,
                'year_published' => $row->year_published,
                'course' => $row->course['name'],
                'CD' => ($row->with_cd == 1 ? 'Yes' : 'No')
            ];
        }

        // print_r($dataToDownload);
        // output each row of the data

        foreach ($dataToDownload as $row)
        {
        fputcsv($file, $row);
        }
         
        exit();

        return redirect()->back();

    }

    public function selectBooks() {
        $books = Book::all();
        return view('books.select_book')
            ->with('books', $books);
    }

    public function printSelectedBookss(Request $request) {
        $html = '';
        $selectedData = [];
        $x = 0;
        if ($request->ajax()) {
            // print_r($_POST['selectedData'][0]);
            $dataLength = count($_POST['selectedData']);
            for ($i=0; $i < $dataLength; $i++) { 
                // echo('id = '. $_POST['selectedData'][$i]['id'] . 'quantity = '. $_POST['selectedData'][$i]['quantity']);
                /*$html .= "<div style='display: inline-block;font-family: 'Roboto', sans-serif;;padding: 5px;'><img src=".{{ asset('images/spcf-property.png') }}." width='300' style='border-bottom: 1px solid black; padding-bottom: 5px;'></div>";*/

                    /*<div style="display: inline-block;font-family: 'Roboto', sans-serif;;padding: 5px;">
                        <img src="{{ asset('images/spcf-property.png') }}" width="300" style="border-bottom: 1px solid black; padding-bottom: 5px;">
                        
                        <ul class="list-inline" >
                            <div style="float:left;"><img src="data:image/png;base64, {{base64_encode(QrCode::format('png')->size(100)->generate(url('book/').'/'.$book->id))}} "></div>
                            <div style="display: inline-block; margin-top: 28px;">
                                {{-- <h1 style="font-size: 12px;">ID: {{ $book }}</h1> --}}
                                <strong>ID No: </strong>{{$book->id}}<br>
                                <strong>Course: </strong>{{$book->course['name']}}<br>
                                <strong>Year Published: </strong>{{$book->year_published}}
                            </div>
                        </ul> 
                    </div>*/
                $book = Book::find($_POST['selectedData'][$i]['id']);
                $selectedData[$x++] = [
                    'id' => $_POST['selectedData'][$i]['id'],
                    'quantity' => $_POST['selectedData'][$i]['quantity'],
                    'course' => $book->course['name'],
                    'year_published' => $book->year_published
                ];
            }

            return json_decode(json_encode($selectedData));
        }
    }


}
