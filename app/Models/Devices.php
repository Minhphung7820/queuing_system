<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory;
    protected $table = "devices";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'code_devices',
        'type_device',
        'name',
        'slug',
        'ip_address',
        'status_active',
        'status_connect',
        'services',
        'nameLogin',
        'password',
        'created_at',
        'updated_at'
    ];
    public function type()
    {
        return $this->belongsTo(TypeDevices::class,"type_device","id");
    }
    public function services()
    {
        return $this->hasMany(Services::class,"device_id","id");
    }
    public function numbers()
    {
        return $this->hasMany(Numbers::class,"devices_id","id");
    }
}
