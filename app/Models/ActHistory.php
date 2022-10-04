<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActHistory extends Model
{
    use HasFactory;
    protected $table = "activity_history";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nameLogin',
        'Time',
        'ipAddress',
        'action',
        'format_date',
        'created_at',
        'updated_at'
    ];
}
