<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'user_id' => $this->user_id,
            'label_id' => $this->label_id,

            'title' => $this->title,
            'content' => $this->content,

            'color' => $this->color,

            'is_pinned' => $this->is_pinned,
            'is_archived' => $this->is_archived,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
