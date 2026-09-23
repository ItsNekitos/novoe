<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ViewFilesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $res = UserInforResource::collection($this->accesses)->collection;
        $res[] = [
            'fullname' => User::find($this->user_id)->last_name,
            'email' => User::find($this->user_id)->email,
            'type' => "author"
        ];
        return [
            'file_id' => $this->file_id,
            'name' => $this->name,
            'url' => $this->url,
            'accesses' => $res


        ];
    }
}
