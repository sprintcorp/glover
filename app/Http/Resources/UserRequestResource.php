<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_by' => $this->createdBy->fullname,
            'action' => $this->action,
            'new_data' => $this->data,
            'current_data' => $this->user,
            'model' => $this->model_type,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
