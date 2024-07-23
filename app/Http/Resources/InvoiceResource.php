<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'Client_id ' => $this->client_id,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'total'=> $this->total,
            'status' => $this->status,
            'approbation' => $this->approbation
        ];
    }
}
