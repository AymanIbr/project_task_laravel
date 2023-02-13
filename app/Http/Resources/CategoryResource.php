<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id_pk' => $this->id,
            'english_name' => $this->name,
            // لو اردت ان تظهر شيء ولكن بشرط
            'custome' => $this->when($request->user('api ')->hasPermissionTo('Read-categories'), 'scss'),
            // 'test' => $this->mergeWhen($this->id > 5, [
            //     'custom_2' => '123',
            //     'custom_3' => '456'
            // ]),
            // بنفع هيك كمان
             $this->mergeWhen($this->id > 5, [
                'custom_2' => '123',
                'custom_3' => '456'
            ]),
        ];
    }
}
