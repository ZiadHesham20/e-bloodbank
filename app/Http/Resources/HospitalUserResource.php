<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalUserResource extends JsonResource
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
            'type' => $this->type,
            'count' => $this->count,
            'done' => $this->done,
            'hospital' => new HospitalResource($this->hospital),
            'user' => new UserResource($this->user),
            'blood' => new BloodResource($this->blood),
        ];
    }
}
