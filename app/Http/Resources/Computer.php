<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Computer extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'os_name' => $this->os_name,
            'os_version' => $this->os_version,
            'proc_info' => $this->proc_info,
            'gpu_info' => $this->gpu_info,
            'disk_info' => $this->disk_info,
            'system_ram' => $this->system_ram,
            'model_info' => $this->model_info,
            'hash' => $this->hash,
            'serial' => $this->serial,
            'added_by' => $this->created_by,
            'created_at' => $this->created_at->format('Y-m-d h:i'),
            'updated_at' => $this->updated_at->format('Y-m-d h:i'),
        ];
    }
}
