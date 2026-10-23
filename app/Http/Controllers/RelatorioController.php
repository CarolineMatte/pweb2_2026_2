<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Destino;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    // Relatório 1: Clientes com Reservas (data_reserva, data_volta), Destino e Atrações do Destino
    public function clientes()
    {
        $clientes = Cliente::with(['reserva.destino.atracoes', 'passaporte'])->get();

        $pdf = Pdf::loadView('pdf.clientes', compact('clientes'));

        return $pdf->stream('relatorio_clientes.pdf');
    }

    // Relatório 2: Destinos com Clientes que reservaram para lá
    public function destinos()
    {
        $destinos = Destino::with(['reservas.cliente', 'atracoes'])->get();

        $pdf = Pdf::loadView('pdf.destinos', compact('destinos'));

        return $pdf->stream('relatorio_destinos.pdf');
    }
}
