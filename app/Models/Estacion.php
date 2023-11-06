<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estacion extends Model
{
    use SoftDeletes;

    use HasFactory;
    protected $fillable = [
        'name', 'user_id', 'zona_id', 'supervisor_id'
    ];

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
    public function productos()
    {
        return $this->belongsToMany(Producto::class)->withPivot('id', 'supervisor_id', 'stock', 'created_at', 'status', 'flag_trash')->using(EstacionProducto::class);
    }
    public function repuestos()
    {
        return $this->hasMany(Repuesto::class);
    }
    public function solicituds()
    {
        return $this->hasMany(Solicitud::class);
    }
}
