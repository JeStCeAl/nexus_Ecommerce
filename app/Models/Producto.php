<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
     use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'cantidad',
        'dimensiones',
        'peso',
        'precio',
        'destacado',
        'activo',
        'imagen',
        'material',
        'usuario_id',
    ];

    public $timestamps = false;

    // Relaciones
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'producto_id');
    }
    public function detalles()
    {
        return $this->hasMany(Detalle::class, 'producto_id');
    }
    public function usuarios()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

}
