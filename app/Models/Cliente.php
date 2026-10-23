<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'email',
    ];

    public function reserva()
    {
        return $this->hasOne(Reserva::class, 'cliente_id');
    }

    public function passaporte()
    {
        return $this->hasOne(Passaporte::class, 'cliente_id');
    }
}
