<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoGroupResource extends JsonResource
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
            'user_id' => $this->user_id,
            'label_id' => $this->label_id,

            'title' => $this->title,
            'color' => $this->color,

            'is_pinned' => $this->is_pinned,
            'is_archived' => $this->is_archived,
            'is_empty' => $this->is_empty,

            'todo_items' => TodoItemResource::collection($this->whenLoaded('todoItems')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}