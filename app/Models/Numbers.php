<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numbers extends Model
{
    use HasFactory;
    protected $table = "numbers";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'number',
        'counter',
        'user_id',
        'services_id',
        'devices_id',
        'date_started',
        'date_end',
        'status',
        'format_date',
        'created_at',
        'updated_at'
    ];
    public function services()
    {
        return $this->belongsTo(Services::class,"services_id","id");
    }
    public function device()
    {
        return $this->belongsTo(Devices::class,"devices_id","id");
    }
    
    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");
    }
}
