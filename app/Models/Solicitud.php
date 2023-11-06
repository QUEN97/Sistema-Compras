<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitud extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    
    protected $fillable = [
        'estacion_id', 'categoria_id', 'observacion', 'pdf', 'status', 'tipo_compra','motivo','total'
    ];

    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    protected $appends = [
        'created_format',
    ];

    public function estacion()
    {
        return $this->belongsTo(Estacion::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class)->withPivot('id', 'cantidad', 'created_at', 'total', 'flag_trash')->using(ProductoSolicitud::class);
    }

    public function observacions()
    {
        return $this->hasMany(Observacion::class);
    }

    public function extraordinarios(){
        return $this->hasMany(ProductoExtraordinario::class);
    }
	public function evidencias():HasMany{
        return $this->hasMany(ArchivosSolicitud::class);
    }
}
