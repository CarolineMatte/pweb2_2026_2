<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Passaporte extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_documento',
        'pais_emissor',
        'data_validade',
        'cliente_id',
    ];

    // Relacionamento 1:1 — Um Passaporte pertence a um Cliente.
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
