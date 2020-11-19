<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use App\Http\Resources\BrandResource;


class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $brands=Brand::all();
        // return $brands;
        $brands=Brand::all();
        return response()->json([
            'status'=>'ok! success customer',
            'totalResults'=>count($brands),
            'brands'=>BrandResource::collection($brands)
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
            $filePath = $request->file('photo')->storeAs('brandimg', $fileName, 'public');
            
            $path = '/storage/'.$filePath;
        }

        // data insert
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->photo = $path;
        $brand->save();

        // return
        return new BrandResource($brand);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
          return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
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
            $filePath = $request->file('photo')->storeAs('brandimg', $fileName, 'public');
            
            $path = '/storage/'.$filePath;
        }else{
            $path = $request->oldphoto;
        }

        // data insert
        
        $brand->name = $request->name;
        $brand->photo = $path;
        $brand->save();

        // return
        return new BrandResource($brand);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
       $brand->delete();
       return new BrandResource($brand);
    }
}
