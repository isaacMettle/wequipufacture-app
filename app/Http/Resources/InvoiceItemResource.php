<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'invoice_id'=>$this->invoice_id, 
            'description'=>$this->description,
            'prix_unitaire'=>$this->prix_unitaire,
            'tva'=>$this->tva,
            'product_id'=>$this->product_id,
            'quantity'=>$this->quantity,
            'total'=>$this->total,
        ];
    }
}
