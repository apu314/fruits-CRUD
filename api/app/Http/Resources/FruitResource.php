<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FruitResource extends JsonResource {

    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) {
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'fruitDetails' => FruitDetailsResource::collection($this->whenLoaded('fruitDetails')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
