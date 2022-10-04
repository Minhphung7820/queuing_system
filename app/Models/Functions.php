<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functions extends Model
{
    use HasFactory;
    protected $table = "functions";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nameFunction',
        'created_at',
        'updated_at'
    ];
    public function role()
    {
        return $this->belongsToMany(Role::class,"role_function","idFunc","idRole");
    }
}
