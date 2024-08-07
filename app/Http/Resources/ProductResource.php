<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id, 
            'item_code'=>$this->item_code,
            'name'=>$this->name,
            'quantity'=>$this->quantity,
            'total'=>$this->total,
            'description'=>$this->description,
            'price'=>$this->price,
            'category_id'=>$this->category_id,
        ];
    }
}
