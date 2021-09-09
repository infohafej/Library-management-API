<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookImage;
use Illuminate\Http\Request;

use Exception;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title'=>['required'],
                'author'=>['required'],
                'publisher'=>['required'],
                'description'=>['required'],
                'category_id'=>['required'],
                'book_image.*' => ['required','mimes:jpeg,jpg,png','max:2048']

            ]);
           // dd($request->all());

            $book = Book::create($request->all());
            //dd($book);

            $this->fileUpload($request,$book->id);

            $response = [
                'message' => 'Book created successfully',
                'book' => $book,
                ];

            return response($response, 201);
        }catch (Exception $ex) {

			return [
				'message' => "The exception Message is: " . $ex->getMessage(),
				'code' => "The exception code is: " . $ex->getCode()
			];
			 
		}
    }

    public function fileUpload($req, $book_id){

          if($req->hasfile('book_image')) {
            
            foreach($req->file('book_image') as $file)
            {
                //$name = $file->getClientOriginalName();
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path().'/uploads/', $name);  

                $data = null;
                $data['book_image'] = $name;
                $data['book_id'] = $book_id;
                $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
                $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
                $imageData[] = $data;

            }
    
            // $fileModal = new BookImage();
            // $fileModal->book_image = json_encode($imgData);
            // $fileModal->book_id = $book_id;
           
            // $fileModal->save();

            BookImage::insert($imageData);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title'=>['required'],
            'author'=>['required'],
            'publisher'=>['required'],
            'description'=>['required'],
            'category_id'=>['required'],
            'book_image.*' => ['mimes:jpeg,jpg,png','max:2048']

        ]);
        $updateBook = $book->update($request->all());
        
        $this->fileUpload($request, $book->id);

        $response = [
            'message' => 'Book Update successfully',
            'book' => $updateBook
            ];

        return response($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        Book::destroy($book);

        $response = [
            'message' => 'Book Delete successfully',
            ];

        return response($response);
    }
}
