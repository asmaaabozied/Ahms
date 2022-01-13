<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LawercaseResource extends JsonResource
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

            'icons' => asset('uploads/'. $this->icons),

            'name'=>$this->name,

            'number'=>$this->number,

            'status'=>$this->status,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at



        ];
    }
}
