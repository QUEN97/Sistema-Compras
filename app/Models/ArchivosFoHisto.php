<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivosFoHisto extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'folios_historial_id', 'nombre_remision', 'mime_type_remision', 'size_remision', 'path_remision', 
        'nombre_condiciones', 'mime_type_condiciones', 'size_condiciones', 'path_condiciones', 'flag_trash',
    ];

    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    protected $appends = [
        'created_format',
    ];

    public function folioshistorial()
    {
        return $this->belongsTo(FoliosHistorial::class);
    }
}
