<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDevices extends Model
{
    use HasFactory;
    protected $table = "type_devices";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'slug',
        'describe',
        'created_at',
        'updated_at'
    ];

    public function device()
    {
        return $this->hasMany(Devices::class,"type_device","id");
    }
}
