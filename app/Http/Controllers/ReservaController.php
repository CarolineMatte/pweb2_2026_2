<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Destino;
use App\Models\Atracao;

class ReservaController extends Controller
{
    public function index()
    {
        $dados = Reserva::with(['cliente', 'destino', 'atracao'])->get();

        return view('reserva.list')->with(['dados' => $dados]);
    }

    function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $destinos = Destino::with('atracoes')->orderBy('nome')->get();

        return view('reserva.form', compact('clientes', 'destinos'));
    }

    function validateForm(Request $request, $id = null)
    {
        $request->validate([
            'data_reserva' => 'required|date',
            'data_volta'   => 'nullable|date|after_or_equal:data_reserva',
            'status'       => 'required',
            'cliente_id'   => 'required|unique:reservas,cliente_id,' . $id,
            'destino_id'   => 'required',
        ], [
            'data_reserva.required'      => "A data de ida é obrigatória",
            'data_reserva.date'          => "A data de ida deve ser uma data válida",
            'data_volta.date'            => "A data de volta deve ser uma data válida",
            'data_volta.after_or_equal'  => "A data de volta deve ser igual ou posterior à data de ida",
            'status.required'            => "O :attribute é obrigatório",
            'cliente_id.required'        => "O :attribute é obrigatório",
            'cliente_id.unique'          => "Este cliente já possui uma reserva ativa.",
            'destino_id.required'        => "O :attribute é obrigatório",
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
        $destinos = Destino::with('atracoes')->orderBy('nome')->get();

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
            if ($request->tipo == 'cliente') {
                $dados = Reserva::with(['cliente', 'destino', 'atracao'])->whereHas('cliente', function ($query) use ($request) {
                    $query->where('nome', 'like', "%$request->valor%");
                })->get();
            } else {
                $dados = Reserva::with(['cliente', 'destino', 'atracao'])->where(
                    $request->tipo,
                    'like',
                    "%$request->valor%"
                )->get();
            }
        } else {
            $dados = Reserva::with(['cliente', 'destino', 'atracao'])->get();
        }

        return view('reserva.list', compact('dados'));
    }
}
