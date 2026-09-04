<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Destino;

class ReservaController extends Controller
{
    public function index()
    {
        $dados = Reserva::all();

        return view('reserva.list')->with(['dados' => $dados]);
    }

    function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $destinos = Destino::orderBy('nome')->get();

        return view('reserva.form', compact('clientes', 'destinos'));
    }

    function validateForm(Request $request, $id = null)
    {
        $request->validate([
            'data_reserva' => 'required',
            'status'       => 'required',
            'cliente_id'   => 'required|unique:reservas,cliente_id,' . $id,
            'destino_id'   => 'required',
        ], [
            'data_reserva.required' => "A :attribute é obrigatória",
            'status.required'       => "O :attribute é obrigatório",
            'cliente_id.required'   => "O :attribute é obrigatório",
            'cliente_id.unique'     => "Este cliente já possui uma reserva ativa.",
            'destino_id.required'   => "O :attribute é obrigatório",
        ]);
    }

    function store(Request $request)
    {
        $this->validateForm($request);

        Reserva::create($request->all());

        return redirect('reserva')->with("success", 'Registro salvo com sucesso!');
    }

    function edit($id)
    {
        $data     = Reserva::find($id);
        $clientes = Cliente::orderBy('nome')->get();
        $destinos = Destino::orderBy('nome')->get();

        return view('reserva.form', compact('data', 'clientes', 'destinos'));
    }

    function update(Request $request, $id)
    {
        $this->validateForm($request, $id);

        Reserva::find($id)->update($request->all());

        return redirect('reserva')->with("success", 'Registro atualizado com sucesso!');
    }

    function destroy($id)
    {
        Reserva::destroy($id);

        return redirect('reserva')->with("success", 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Reserva::where(
                $request->tipo,
                'like',
                "%$request->valor%"
            )->get();
        } else {
            $dados = Reserva::all();
        }

        return view('reserva.list', compact('dados'));
    }
}
