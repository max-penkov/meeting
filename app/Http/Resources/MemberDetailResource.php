<?php

namespace App\Http\Resources;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int   id
 * @property Event event
 * @property mixed fullName
 */
class MemberDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'name'  => $this->fullName,
            'email' => $this->email,
            'event' => [
                'id'   => $this->event->id,
                'name' => $this->event->name,
            ],
        ];
    }
}
