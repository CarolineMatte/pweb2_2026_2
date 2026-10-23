<?php

namespace App\Http\Controllers;

use App\Models\Passaporte;
use App\Models\Cliente;
use Illuminate\Http\Request;

class PassaporteController extends Controller
{
    public function index()
    {
        $passaportes = Passaporte::with('cliente')->get();
        return view('passaportes.list', compact('passaportes'));
    }

    public function create()
    {
        $clientes = Cliente::whereDoesntHave('passaporte')->get();
        return view('passaportes.form', compact('clientes'));
    }

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

    public function edit($id)
    {
        $passaporte = Passaporte::findOrFail($id);
        $clientes = Cliente::whereDoesntHave('passaporte')
            ->orWhere('id', $passaporte->cliente_id)
            ->get();
        return view('passaportes.form', compact('passaporte', 'clientes'));
    }

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

    public function destroy($id)
    {
        $passaporte = Passaporte::findOrFail($id);
        $passaporte->delete();

        return redirect()->route('passaportes.index')->with('sucesso', 'Passaporte excluído com sucesso!');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            if ($request->tipo == 'cliente') {
                $passaportes = Passaporte::with('cliente')
                    ->whereHas('cliente', function ($query) use ($request) {
                        $query->where('nome', 'like', "%$request->valor%");
                    })->get();
            } else {
                $passaportes = Passaporte::with('cliente')
                    ->where($request->tipo, 'like', "%$request->valor%")
                    ->get();
            }
        } else {
            $passaportes = Passaporte::with('cliente')->get();
        }

        return view('passaportes.list', compact('passaportes'));
    }
}
