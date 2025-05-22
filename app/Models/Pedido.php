<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado',
        'fechaPedido',
        'numero',
        'total',
        'usuario_id'
    ];

    public $timestamps = false;

     //Relaciones
    public function usuarios()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
