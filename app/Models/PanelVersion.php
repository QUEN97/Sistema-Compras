<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PanelVersion extends Pivot
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'panel_id', 'version_id',
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

    public function version()
    {
        return $this->belongsTo(Version::class);
    }

    public function subdescripcionversions()
    {
        return $this->hasMany(SubDescripcionVersion::class, 'panel_version_id');
    }
}
