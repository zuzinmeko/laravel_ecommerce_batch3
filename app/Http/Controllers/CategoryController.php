<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CagtegoryResource;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all();
        //return $items;
        return response()->json([
            'status'=>'ok! success customer',
            'totalResults'=>count($categories),
            'categories'=>CagtegoryResource::collection($categories)
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
            "photo" => "required", // a.jpg
        
       
        ]);

        // if include file, upload
        if($request->file()) {
            // 624872374523_a.jpg
            $fileName = time().'_'.$request->photo->getClientOriginalName();
            // itemimg/624872374523_a.jpg
            $filePath = $request->file('photo')->storeAs('categoryimg', $fileName, 'public');
            
            $path = '/storage/'.$filePath;
        }

        // data insert
        $category = new Category;
        $category->name = $request->name;
        $category->photo = $path;
        $category->save();

        // return
        return new CagtegoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
         return new CagtegoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
         $request->validate([
            "name" => "required|min:5",
           
            "photo" => "sometimes|required", // a.jpg
       
            
        ]);

        // if include file, upload
        if($request->file()) {
            // 624872374523_a.jpg
            $fileName = time().'_'.$request->photo->getClientOriginalName();
            // itemimg/624872374523_a.jpg
            $filePath = $request->file('photo')->storeAs('categoryimg', $fileName, 'public');
            
            $path = '/storage/'.$filePath;
        }else{
            $path = $request->oldphoto;
        }

        // data insert
        
        $category->name = $request->name;
        $category->photo = $path;
        $category->save();

        // return
        return new CagtegoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
       $category->delete();
       return new CagtegoryResource($category);
   }
}
