<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    use HasFactory;

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'panel_id', 'titulo_manual', 'manual_path', 'size', 'flag_trash',
    ];

    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    protected $appends = [
        'created_format',
    ];

    public function panel()
    {
        return $this->belongsTo(Panel::class);
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class)->withPivot('id', 'manual_id', 'permiso_id', 'created_at')->using(ManualPermiso::class);
    }
}
