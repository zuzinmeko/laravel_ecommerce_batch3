<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CagtegoryResource;

class SubcategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
     public static $wrap='subcategory';

    public function toArray($request)
    {
        //return parent::toArray($request);
        return[
            'id'=>$this->id,
            'name'=>$this->name,
            'category'=>new CagtegoryResource($this->category),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
