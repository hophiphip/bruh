<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Offer;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'case_id' => $this->case_id,
            'company_id' => $this->company_id,
            'description' => $this->description,
            'date' => $this->created_at->diffForHumans(),
        ];
    }
}
