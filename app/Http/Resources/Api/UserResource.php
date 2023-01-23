<?php

namespace App\Http\Resources\Api;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? '',
            'email' => $this->email,
            'is_active' => (bool)$this->is_active,
            'created_at' => $this->created_at
        ];
    }
}
