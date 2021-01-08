<?php

namespace App\Http\Resources\Thread;

use Illuminate\Http\Resources\Json\JsonResource;

class ThreadSingleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'user' => $this->user,
            'thumbnail' => $this->thumbnail,
            'scores' => (int)$this->scores,
            'upVotedBy' => $this->upVotedBy(),
            'downVotedBy' => $this->downVotedBy(),
            'comments' => ThreadSingleResource::collection($this->comments),
            'time' => $this->created_at->diffForHumans()
        ]);
    }
}
