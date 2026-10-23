<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_reserva',
        'data_volta',
        'status',
        'observacao',
        'cliente_id',
        'destino_id',
        'atracao_id',
    ];

    protected $cast = [
        'cliente_id' => 'integer',
        'destino_id' => 'integer',
        'atracao_id' => 'integer',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function destino()
    {
        return $this->belongsTo(Destino::class, 'destino_id');
    }

    public function atracao()
    {
        return $this->belongsTo(Atracao::class, 'atracao_id');
    }
}
