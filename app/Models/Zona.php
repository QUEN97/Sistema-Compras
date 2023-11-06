<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zona extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_zona');
    }

    public function estacions()
    {
        return $this->hasMany(Estacion::class);
    }
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

}
