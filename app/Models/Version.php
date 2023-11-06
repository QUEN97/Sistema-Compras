<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'titulo_version', 'version', 'status', 'flag_trash',
    ];

    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    protected $appends = [
        'created_format',
    ];

    public function panels()
    {
        return $this->belongsToMany(Panel::class)->withPivot('id', 'panel_id', 'version_id', 'created_at')->using(PanelVersion::class);
    }
}
