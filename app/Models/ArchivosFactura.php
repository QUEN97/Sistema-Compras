<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivosFactura extends Model
{
    protected $fillable=[ 'id_factura','nombre_archivo', 'mime_type', 'size', 'archivo_path'];
    use HasFactory;
}
