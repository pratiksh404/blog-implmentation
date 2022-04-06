<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'posts',
            'id' => (string) $this->id,
            'attributes' => parent::toArray($request),
            'links' => [
                'self' => adminShowRoute('post', $this->id)
            ]
        ];
    }
}
