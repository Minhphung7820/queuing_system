<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    protected $table = "services";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'code_services',
        'device_id',
        'der',
        'number_rule',
        'format_date',
        'status_active',
        'number_current',
        'timeoutRule',
        'created_at',
        'updated_at'
    ];
    public function numerical()
    {
        return $this->hasMany(Numbers::class,"services_id","id");
    }
    public function device()
    {
        return $this->belongsTo(Devices::class,"device_id","id");
    }

}
