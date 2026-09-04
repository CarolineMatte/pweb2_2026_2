<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destino;

class DestinoController extends Controller
{
    public function index()
    {
        $dados = Destino::all();

        return view('destino.list')->with(['dados' => $dados]);
    }

    function create()
    {
        return view('destino.form');
    }

    function validateForm(Request $request)
    {
        $request->validate([
            'nome'       => 'required',
            'localizacao'=> 'required',
            'preco'      => 'required',
        ], [
            'nome.required'        => "O :attribute é obrigatório",
            'localizacao.required' => "A :attribute é obrigatória",
            'preco.required'       => "O :attribute é obrigatório",
        ]);
    }

    function store(Request $request)
    {
        $this->validateForm($request);

        Destino::create($request->all());

        return redirect('destino')->with("success", 'Registro salvo com sucesso!');
    }

    function edit($id)
    {
        $data = Destino::find($id);

        return view('destino.form', compact('data'));
    }

    function update(Request $request, $id)
    {
        $this->validateForm($request);

        Destino::find($id)->update($request->all());

        return redirect('destino')->with("success", 'Registro atualizado com sucesso!');
    }

    function destroy($id)
    {
        $destino = Destino::find($id);

        if ($destino->reservas()->exists()) {
            return redirect('destino')->with("error", 'Não é possível excluir: este destino possui reservas associadas.');
        }

        $destino->delete();

        return redirect('destino')->with("success", 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Destino::where(
                $request->tipo,
                'like',
                "%$request->valor%"
            )->get();
        } else {
            $dados = Destino::all();
        }

        return view('destino.list', compact('dados'));
    }
}
