<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
{

    public static $wrap = 'prescription';
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
            'title' => $this->title,
            'description' => $this->description,
            'use_case' => $this->use_case,
            'notes' => $this->notes,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'drugs' => $this->drugs
        ];
    }
}
