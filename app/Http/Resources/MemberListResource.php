<?php

namespace App\Http\Resources;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed fullName
 * @property Event event
 */
class MemberListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->fullName,
            'event' => $this->event ? [
                'id' => $this->event->id,
                'name' => $this->event->name,
            ] : [],
        ];
    }
}
