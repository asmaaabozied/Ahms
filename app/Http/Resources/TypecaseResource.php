<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TypecaseResource extends JsonResource
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

             'id'=>$this->id,


//            'file' =>asset('uploads/'. $this->file),

            'files'=>ImageResource::collection($this->images),

            'name'=>$this->name,

            'description'=>$this->description,

            'status'=>$this->status,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at

        ];
    }
}
