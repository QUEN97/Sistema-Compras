<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'titulo_permiso', 'descripcion', 'flag_trash'
    ];

    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    protected $appends = [
        'created_format',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function panels()
    {
        return $this->belongsToMany(Panel::class)->withPivot('wr', 're', 'ed', 'de', 'vermas', 'verpap', 'restpap', 'vermaspap', 'created_at')->using(PanelPermiso::class);
    }

    public function manuals()
    {
        return $this->belongsToMany(Manual::class)->withPivot('id', 'manual_id', 'permiso_id', 'created_at')->using(ManualPermiso::class);
    }
}
