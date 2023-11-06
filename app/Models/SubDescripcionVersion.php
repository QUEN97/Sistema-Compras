<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDescripcionVersion extends Model
{
    use HasFactory;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'panel_version_id', 'categoria', 'descripcion',
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

    public function panelversion()
    {
        return $this->belongsTo(PanelVersion::class);
    }
}
