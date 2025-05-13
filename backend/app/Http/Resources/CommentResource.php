<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'post_id' => $this->post_id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'email' => $this->when($request->user()?->exists, $this->email),
            'content' => $this->content,
            'status' => $this->when($request->user()?->exists, $this->status),
            'is_admin_reply' => $this->is_admin_reply,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'replies' => CommentResource::collection($this->whenLoaded('replies')),
        ];
    }
}
