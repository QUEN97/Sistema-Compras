<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PanelPermiso extends Pivot
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'permiso_id', 'panel_id', 'wr', 're', 'ed', 'de', 'vermas', 'verpap', 'restpap', 'vermaspap',
    ];

    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    protected $appends = [
        'created_format',
    ];

    public function permiso()
    {
         return $this->belongsTo(Permiso::class);
     }

     public function panel()
     {
        return $this->belongsTo(Panel::class);
     }

}
