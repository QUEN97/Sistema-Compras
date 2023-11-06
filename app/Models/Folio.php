<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folio extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'folio', 'motivo', 'pdf', 'isentrada_issalida',
    ];

    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    protected $appends = [
        'created_format',
    ];

    public function folioshistorials()
    {
        return $this->hasMany(FoliosHistorial::class);
    }
}
