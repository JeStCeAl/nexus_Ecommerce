<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'cantidad',
        'nombre',
        'precioUnitario',
        'total',
        'pedido_id',
        'producto_id'
    ];

    public $timestamps = false;
    //Relaciones
    public function productos()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    //Relaciones
    public function pedidos()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }
}
