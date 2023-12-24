<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'blood_id' => $this->blood_id,
            'hospital_id' => $this->hospital_id,
            'age' => $this->age,
            'number' => $this->phone,
            'gender' => $this->gender,
            'location' => $this->location,
            'donation_date' => $this->donation_date,
            'donatable' => $this->donatable,
            'role' => $this->role,
            'points' => $this->points,
            'block' => $this->block,
            'profile_photo_path' => $this->profile_photo_path
        ];
    }
}
