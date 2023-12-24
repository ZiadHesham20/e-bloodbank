<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmergencyRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->phone,
            'count' => $this->quantity,
            'dateTime' => $this->dateTime,
            'city' => $this->city,
            'location' => $this->location,
            'done' => $this->done,
            'user' => new UserResource($this->user),
            'blood' => new BloodResource($this->blood),
        ];
    }
}
