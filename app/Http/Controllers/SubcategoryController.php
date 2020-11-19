<?php

namespace App\Http\Controllers;

use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Resources\SubcategoryResource;


class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
               $subcategories=Subcategory::all();
               return response()->json([
                'status'=>'ok! success customer',
                'totalResults'=>count($subcategories),
                'subcategories'=>SubcategoryResource::collection($subcategories)
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         $request->validate([
            "name" => "required|min:5",
            "category" => "required", // a.jpg
        
       
        ]);

        // if include file, upload
      

        // data insert
        $subcategory = new Subcategory;
        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category;
        $subcategory->save();

        // return
        return new SubcategoryResource($subcategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        return new SubcategoryResource($subcategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
         
         $request->validate([
            "name" => "required|min:5",
            "category" => "required", // a.jpg
        
       
        ]);

       
        // data insert
       
        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category;
        $subcategory->save();

        // return
        return new SubcategoryResource($subcategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
      return new SubcategoryResource($subcategory);
    }
}
