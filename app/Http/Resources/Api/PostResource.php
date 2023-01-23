<?php

namespace App\Http\Resources\Api;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'image' => $this->image ? asset('storage/images/' . $this->image) : null,
            'is_published' => (bool)$this->is_published,
            'user' => UserResource::make($this->whenloaded('user')),
        ];
    }
}
