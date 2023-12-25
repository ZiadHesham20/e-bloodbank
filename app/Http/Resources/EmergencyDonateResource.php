<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmergencyDonateResource extends JsonResource
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
            // 'emergency' => new EmergencyRequestResource($this->emergency),
            'emergency' => $this->emergency_id,
            'user' => new UserResource($this->user),
        ];
    }
}
