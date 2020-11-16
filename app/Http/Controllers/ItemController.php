<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Item::all();
        //return $items;
        return response()->json([
            'status'=>'ok! success customer',
            'totalResults'=>count($items),
            'items'=>ItemResource::collection($items)
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
            "price" => "required",
            "discount" => "required",
            "description" => "required|min:10",
            "brand" => "required|exists:brands,id",
            "subcategory" => "required",
            "photo" => "required|mimes:jpeg,bmp,png", // a.jpg
        ],
        [
            'brand.exists' => 'Not existing ID',
        ]);

        // if include file, upload
        if($request->file()) {
            // 624872374523_a.jpg
            $fileName = time().'_'.$request->photo->getClientOriginalName();
            // itemimg/624872374523_a.jpg
            $filePath = $request->file('photo')->storeAs('itemimg', $fileName, 'public');
            
            $path = '/storage/'.$filePath;
        }

        // data insert
        $item = new Item;
        $item->codeno = uniqid();
        $item->name = $request->name;
        $item->photo = $path;
        $item->price = $request->price;
        $item->discount = $request->discount;
        $item->description = $request->description;
        $item->brand_id = $request->brand;
        $item->subcategory_id = $request->subcategory;
        $item->save();

        // return
        return new ItemResource($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return new ItemResource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            "name" => "required|min:5",
            "price" => "required",
            "discount" => "required",
            "description" => "required|min:10",
            "brand" => "required|exists:brands,id",
            "subcategory" => "required",
            "photo" => "sometimes|required", // a.jpg
        ],
        [
            'brand.exists' => 'Not existing ID',
        ]);

        // if include file, upload
        if($request->file()) {
            // 624872374523_a.jpg
            $fileName = time().'_'.$request->photo->getClientOriginalName();
            // itemimg/624872374523_a.jpg
            $filePath = $request->file('photo')->storeAs('itemimg', $fileName, 'public');
            
            $path = '/storage/'.$filePath;
        }else{
            $path = $request->oldphoto;
        }

        // data insert
        $item->codeno = uniqid();
        $item->name = $request->name;
        $item->photo = $path;
        $item->price = $request->price;
        $item->discount = $request->discount;
        $item->description = $request->description;
        $item->brand_id = $request->brand;
        $item->subcategory_id = $request->subcategory;
        $item->save();

        // return
        return new ItemResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
      $item->delete();
      return new ItemResource($item);
    }
}
