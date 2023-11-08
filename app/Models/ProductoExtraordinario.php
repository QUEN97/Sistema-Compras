<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductoExtraordinario extends Pivot
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'solicitud_id','tipo', 'producto_extraordinario', 'cantidad', 'total', 'flag_trash','proveedor_id','razon_social'
    ];

    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    protected $appends = [
        'created_format',
    ];
	public function proveedor():BelongsTo{
        return $this->belongsTo(Proveedor::class);
    }
}