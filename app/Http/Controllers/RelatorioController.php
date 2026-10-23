<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Destino;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function clientes()
    {
        $clientes = Cliente::with(['reserva.destino.atracoes', 'passaporte'])->get();

        $pdf = Pdf::loadView('pdf.clientes', compact('clientes'));

        return $pdf->stream('relatorio_clientes.pdf');
    }

    public function destinos()
    {
        $destinos = Destino::with(['reservas.cliente', 'atracoes'])->get();

        $pdf = Pdf::loadView('pdf.destinos', compact('destinos'));

        return $pdf->stream('relatorio_destinos.pdf');
    }
}
