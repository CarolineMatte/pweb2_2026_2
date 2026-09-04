<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index()
    {
        $dados = Cliente::all();

        return view('cliente.list')->with(['dados' => $dados]);
    }

    function create()
    {
        return view('cliente.form');
    }

    function validateForm(Request $request)
    {
        $request->validate([
            'nome'     => 'required|max:255',
            'cpf'      => 'required|max:14',
            'telefone' => 'nullable|max:15',
        ], [
            'nome.required' => "O :attribute é obrigatório",
            'cpf.required'  => "O :attribute é obrigatório",
            'cpf.max'       => "O :attribute deve ter no máximo 14 caracteres",
            'telefone.max'  => "O :attribute deve ter no máximo 15 caracteres",
        ]);
    }

    function store(Request $request)
    {
        $this->validateForm($request);

        Cliente::create($request->all());

        return redirect('cliente')->with("success", 'Registro salvo com sucesso!');
    }

    function edit($id)
    {
        $data = Cliente::find($id);

        return view('cliente.form', compact('data'));
    }

    function update(Request $request, $id)
    {
        $this->validateForm($request);

        Cliente::find($id)->update($request->all());

        return redirect('cliente')->with("success", 'Registro atualizado com sucesso!');
    }

    function destroy($id)
    {
        $cliente = Cliente::find($id);
        
        if ($cliente->reserva) {
            return redirect('cliente')->with("error", 'Não é possível excluir: este cliente possui uma reserva associada.');
        }

        $cliente->delete();

        return redirect('cliente')->with("success", 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Cliente::where(
                $request->tipo,
                'like',
                "%$request->valor%"
            )->get();
        } else {
            $dados = Cliente::all();
        }

        return view('cliente.list', compact('dados'));
    }
}
