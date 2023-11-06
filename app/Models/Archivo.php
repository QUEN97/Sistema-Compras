<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'repuesto_id', 'nombre_archivo', 'mime_type', 'size', 'archivo_path', 'flag_trash',
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

    public function repuesto()
    {
        return $this->belongsTo(Repuesto::class);
    }
}
