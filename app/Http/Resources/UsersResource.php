<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
    //    return [
    //     'id'=> $this->id,
    //     'name'=> $this->name,
    //     'email'=> $this->email,
    //     'password'=>$this->password,
    //     'age'=>$this->age,
    //     'phone'=>$this->phone,
    //     'gender'=>$this->gender,
    //     'blood_type'=>$this->blood_type,
    //     'location'=>$this->location,
    //     'date_and_time'=>$this->date_and_time,
    //     'request_id'=>$this->request_id
    //    ];
    }
}
