<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'titulo_panel',
    ];

    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    protected $appends = [
        'created_format',
    ];

    public function manuals()
    {
        return $this->hasMany(Manual::class);
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class)->withPivot('wr', 're', 'ed', 'de', 'vermas', 'created_at')->using(PanelPermiso::class);
    }

    public function versions()
    {
        return $this->belongsToMany(Version::class)->withPivot('id', 'panel_id', 'version_id', 'created_at')->using(PanelVersion::class);
    }
}
