<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosFactura extends Model
{
    protected $fillable=['id_factura','id_producto'];
    use HasFactory;
}
