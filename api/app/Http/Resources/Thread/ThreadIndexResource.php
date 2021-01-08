<?php

namespace App\Http\Resources\Thread;

use Illuminate\Http\Resources\Json\JsonResource;

class ThreadIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        parent::toArray($request);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'scores' => (int)$this->scores,
            'upVotedBy' => $this->upVotedBy(),
            'downVotedBy' => $this->downVotedBy(),
            'slug' => $this->slug,
            'is_link' => $this->is_link,
            'link' => $this->link,
            'body' => $this->body,
            'user' => $this->user,
            'comments_count' => $this->comments_count,
            'thumbnail' => $this->thumbnail,
            'time' => $this->created_at->diffForHumans()
        ];
    }
}
