<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'estacion_id', 'producto_id', 'cantidad', 'descripcion', 'flag_trash', 'status',
    ];

    /**
     * Get the format to the time created.
     *
     */
    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'created_format',
    ];

    public function estacion()
    {
        return $this->belongsTo(Estacion::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }

    public function observarepuestos()
    {
        return $this->hasMany(Observarepuesto::class);
    }
}
