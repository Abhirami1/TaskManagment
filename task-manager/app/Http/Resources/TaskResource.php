<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
{
    return [
        'id'          => $this->id,
        'title'       => $this->title,
        'description' => $this->description,
        'status'      => $this->status,
        'assigned_to' => $this->assigned_to,
        'assignee'    => $this->whenLoaded('assignee', fn () => [
            'id' => $this->assignee->id, 'name' => $this->assignee->name, 'email' => $this->assignee->email,
        ]),
        'creator'     => $this->whenLoaded('creator', fn () => [
            'id' => $this->creator->id, 'name' => $this->creator->name,
        ]),
        'created_at'  => $this->created_at?->toDateTimeString(),
        'updated_at'  => $this->updated_at?->toDateTimeString(),
    ];
}
}
