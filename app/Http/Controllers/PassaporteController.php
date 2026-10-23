<?php

namespace App\Http\Controllers;

use App\Models\Passaporte;
use App\Models\Cliente;
use Illuminate\Http\Request;

class PassaporteController extends Controller
{
    // Lista todos os passaportes
    public function index()
    {
        $passaportes = Passaporte::with('cliente')->get();
        return view('passaportes.list', compact('passaportes'));
    }

    // Exibe o formulário de criação
    public function create()
    {
        // Só clientes que ainda NÃO têm passaporte podem ser selecionados
        $clientes = Cliente::whereDoesntHave('passaporte')->get();
        return view('passaportes.form', compact('clientes'));
    }

    // Salva o novo passaporte
    public function store(Request $request)
    {
        $request->validate([
            'numero_documento' => 'required|string|max:30',
            'pais_emissor'     => 'required|string|max:100',
            'data_validade'    => 'required|date',
            'cliente_id'       => 'required|exists:clientes,id|unique:passaportes,cliente_id',
        ]);

        Passaporte::create($request->all());

        return redirect()->route('passaportes.index')->with('sucesso', 'Passaporte cadastrado com sucesso!');
    }

    // Exibe o formulário de edição
    public function edit($id)
    {
        $passaporte = Passaporte::findOrFail($id);
        // Na edição, inclui o cliente atual + os que não têm passaporte
        $clientes = Cliente::whereDoesntHave('passaporte')
            ->orWhere('id', $passaporte->cliente_id)
            ->get();
        return view('passaportes.form', compact('passaporte', 'clientes'));
    }

    // Atualiza o passaporte
    public function update(Request $request, $id)
    {
        $passaporte = Passaporte::findOrFail($id);

        $request->validate([
            'numero_documento' => 'required|string|max:30',
            'pais_emissor'     => 'required|string|max:100',
            'data_validade'    => 'required|date',
            'cliente_id'       => 'required|exists:clientes,id|unique:passaportes,cliente_id,' . $passaporte->id,
        ]);

        $passaporte->update($request->all());

        return redirect()->route('passaportes.index')->with('sucesso', 'Passaporte atualizado com sucesso!');
    }

    // Exclui o passaporte
    public function destroy($id)
    {
        $passaporte = Passaporte::findOrFail($id);
        $passaporte->delete();

        return redirect()->route('passaportes.index')->with('sucesso', 'Passaporte excluído com sucesso!');
    }
}
