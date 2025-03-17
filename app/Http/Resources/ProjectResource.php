<?php

namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'privkey' => substr($this->privkey.'********',0,8).'*******',
            'pubkey' => substr($this->pubkey.'********',0,8).'*******',
            'token' => substr($this->token.'********',0,8).'*******',
            'fields' => $this->fields,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }

}
