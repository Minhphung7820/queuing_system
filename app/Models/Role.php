<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = "role";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nameRole',
        'der',
        'created_at',
        'updated_at'
    ];
    public function func()
    {
        return $this->belongsToMany(Functions::class,"role_function","idRole","idFunc");
    }
    public function users()
    {
        return $this->hasMany(User::class,"role","id");
    }
}
