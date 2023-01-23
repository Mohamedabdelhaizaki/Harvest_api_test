<?php

namespace App\Http\Resources\Api;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? '',
            'email' => $this->email,
            'token' => $this->when($this->token, $this->token),
        ];
    }
}
