<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class VideomediaResource extends JsonResource
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

            'id' => $this->id,

            'title'=>$this->title,


            'content'=>$this->content,



            'video_link'=>$this->video_link,

            'source_url'=>$this->source_url,


            'main_image'=>asset('uploads/'.$this->main_image),


            'images_slider'=>ImageResource::collection($this->images),

//            'created_at' => $this->created_at->diffForHumans(Carbon::now()),
//
//            'updated_at' => $this->updated_at->diffForHumans(Carbon::now())

            'created_at' => $this->created_at->diffForHumans(Carbon::now()),
            'updated_at' => $this->updated_at->diffForHumans(Carbon::now())

        ];
    }
}
