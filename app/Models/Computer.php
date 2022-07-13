<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(int $id)
 */
class Computer extends Model
{
    protected $fillable = [
        'os_name',
        'os_version',
        'proc_info',
        'gpu_info',
        'disk_info',
        'system_ram',
        'model_info',
        'hash',
        'serial',
        'created_by'
    ];
}
