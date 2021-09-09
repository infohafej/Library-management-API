<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;

use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
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
                'name'=>'required'
            ]);
            
            $category=Category::create($request->all());

            $response = [
                'message' => 'Category created successfully',
                'category' => $category,
                ];

            return response($response, 201);
        }catch (Exception $ex) {

			return [
				'message' => "The exception Message is: " . $ex->getMessage(),
				'code' => "The exception code is: " . $ex->getCode()
			];
			 
		}

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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
        $category = Category::find($id);
        $category = $category->update($request->all());

        $response = [
            'message' => 'Category Update successfully',
            'category' => $category
            ];

        return response($response);
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          Category::destroy($id);

        $response = [
            'message' => 'Category Delete successfully',
            ];

        return response($response);
    }
}
