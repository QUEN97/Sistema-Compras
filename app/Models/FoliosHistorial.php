<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoliosHistorial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'estacion_producto_id', 'estacion_destino_id', 'folio_id', 'pdf', 'motivo', 'cantidad', 'folio', 'isentrada_issalida', 'status', 'observacion',
    ];

    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    protected $appends = [
        'created_format',
    ];

    public function folio()
    {
        return $this->belongsTo(Folio::class);
    }

    public function estacionproducto()
    {
        return $this->belongsTo(EstacionProducto::class, 'estacion_producto_id');
    }

    public function archivosfohisto()
    {
        return $this->hasOne(ArchivosFoHisto::class);
    }
}
