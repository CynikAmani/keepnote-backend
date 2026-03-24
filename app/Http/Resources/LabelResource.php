<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LabelResource extends JsonResource
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
            'name' => $this->name,
            'notes_count' => $this->whenCounted('notes'),
            'todo_groups_count' => $this->whenCounted('todoGroups'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Include relationships if requested
            'notes' => NoteResource::collection($this->whenLoaded('notes')),
            'todo_groups' => TodoGroupResource::collection($this->whenLoaded('todoGroups')),
        ];
    }
}