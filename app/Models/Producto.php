<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['name','product_photo_path','categoria_id','unidad','precio','stock'];

    public function estacions()
    {
        return $this->belongsToMany(Estacion::class)->withPivot('id', 'supervisor_id', 'stock', 'created_at', 'status', 'flag_trash')->using(EstacionProducto::class);
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function zonas()
    {
        return $this->belongsToMany(Zona::class);
    }
    public function repuestos()
    {
        return $this->hasMany(Repuesto::class);
    }
    public function solicituds()
    {
        return $this->belongsToMany(Solicitud::class)->withPivot('id', 'cantidad', 'created_at', 'total')->using(ProductoSolicitud::class);
    }
}
