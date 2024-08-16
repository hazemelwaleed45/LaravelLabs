<?php

namespace App\Http\Resources;

use App\Http\Controllers\Api\TrackController;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id ,
            'name'=> $this->name ,
            'Location'=> $this->location ,
            'Course Number'=> $this->coursenumber ,
            'Type'=> $this->type ,
            'phone'=> $this->phone ,
        ];
    }
}
