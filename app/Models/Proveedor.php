<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoria_id', 'titulo_proveedor', 'rfc_proveedor', 'flag_trash',
    ];
    
    protected $appends = [
        'created_format',
    ];
    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
