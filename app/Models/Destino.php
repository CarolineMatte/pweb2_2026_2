<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Destino extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'localizacao',
        'preco',
        'descricao',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'destino_id');
    }
}
