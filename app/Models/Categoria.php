<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function solicituds()
    {
        return $this->hasMany(Solicitud::class);
    }
}
