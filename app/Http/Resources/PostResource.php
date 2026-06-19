<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
  public function toArray($request): array
{
    return [
        'id' => $this->id,
        'title' => $this->title,
        'content' => $this->content,
        'short_content' => substr($this->content, 0, 100),
        'author_name' => $this->user?->name,
        'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
    ];
}
}
