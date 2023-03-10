<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'content' => $this->resource->content,
            'feature_image' => $this->resource->feature_image,
            'comment_count' => $this->resource->comment_count,
            'is_editable' => $this->resource->is_editable,
            'image_link' => $this->resource->image_link,
            'user' => $this->resource->user()->first(),
            'comments' => $this->resource?->comments()->count()>0?CommentResource::collection($this->resource->comments()->get()):[],
        ];
    }
}
