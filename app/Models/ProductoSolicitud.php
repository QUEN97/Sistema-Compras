<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductoSolicitud extends Pivot
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'solicitud_id', 'producto_id','proveedor_id', 'cantidad', 'total', 'flag_trash',
    ];

    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    protected $appends = [
        'created_format',
    ];
    public function proveedor():BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }
}
