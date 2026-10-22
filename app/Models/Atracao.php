<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Atracao extends Model
{
    use HasFactory;

    protected $table = 'atracoes';

    protected $fillable = [
        'nome',
        'descricao',
        'imagem',
        'destino_id',
    ];

    public function destino()
    {
        return $this->belongsTo(Destino::class, 'destino_id');
    }
}
