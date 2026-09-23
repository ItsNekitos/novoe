<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInforResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
    public function toArray(Request $request): array
    {
        //   return parent::toArray($request);
        return [
            'fullname' => User::find($this->user_id)->last_name,
            'email' => User::find($this->user_id)->email,
            'type' => "co-author",
        ];
    }
}
