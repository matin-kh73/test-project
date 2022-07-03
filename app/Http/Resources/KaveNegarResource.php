<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class KaveNegarResource extends JsonResource
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
            'sender' => $this['sender'],
            'receptor' => $this['receptor'],
            'cost' => $this['cost'],
            'status' => $this['status'],
            'message' => $this['message'],
            'publish_time' => Carbon::createFromTimestamp($this['date']),
            'message_id' => $this['messageid']
        ];
    }
}
