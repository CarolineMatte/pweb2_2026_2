<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Atracao;
use App\Models\Destino;

class AtracaoController extends Controller
{
    public function index()
    {
        $dados = Atracao::with('destino')->get();

        $graficoLabels = $dados->pluck('nome');
        $graficoDados  = $dados->map(function ($atracao) {
            return $atracao->reservas()->where('status', 'Confirmada')->count();
        });

        return view('atracao.list', compact('dados', 'graficoLabels', 'graficoDados'));
    }

    function create()
    {
        $destinos = Destino::orderBy('nome')->get();

        return view('atracao.form', compact('destinos'));
    }

    function store(Request $request)
    {
        $request->validate([
            'nome'       => 'required',
            'descricao'  => 'required',
            'destino_id' => 'required',
            'imagem'     => 'nullable|image|max:2048',
        ], [
            'nome.required'       => 'O nome da atração é obrigatório.',
            'descricao.required'  => 'A descrição é obrigatória.',
            'destino_id.required' => 'Selecione um destino.',
            'imagem.image'        => 'O arquivo enviado deve ser uma imagem.',
            'imagem.max'          => 'A imagem não pode ultrapassar 2 MB.',
        ]);

        $nomeArquivo = null;
        if ($request->hasFile('imagem')) {
            $nomeArquivo = $request->file('imagem')->store('atracoes', 'public');
        }

        Atracao::create([
            'nome'       => $request->nome,
            'descricao'  => $request->descricao,
            'destino_id' => $request->destino_id,
            'imagem'     => $nomeArquivo,
        ]);

        return redirect('atracao')->with('success', 'Atração cadastrada com sucesso!');
    }

    function edit($id)
    {
        $data     = Atracao::find($id);
        $destinos = Destino::orderBy('nome')->get();

        return view('atracao.form', compact('data', 'destinos'));
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'nome'       => 'required',
            'descricao'  => 'required',
            'destino_id' => 'required',
            'imagem'     => 'nullable|image|max:2048',
        ], [
            'nome.required'       => 'O nome da atração é obrigatório.',
            'descricao.required'  => 'A descrição é obrigatória.',
            'destino_id.required' => 'Selecione um destino.',
            'imagem.image'        => 'O arquivo enviado deve ser uma imagem.',
            'imagem.max'          => 'A imagem não pode ultrapassar 2 MB.',
        ]);

        $atracao = Atracao::find($id);

        $nomeArquivo = $atracao->imagem;
        if ($request->hasFile('imagem')) {
            if ($atracao->imagem) {
                Storage::disk('public')->delete($atracao->imagem);
            }
            $nomeArquivo = $request->file('imagem')->store('atracoes', 'public');
        }

        $atracao->update([
            'nome'       => $request->nome,
            'descricao'  => $request->descricao,
            'destino_id' => $request->destino_id,
            'imagem'     => $nomeArquivo,
        ]);

        return redirect('atracao')->with('success', 'Atração atualizada com sucesso!');
    }

    function destroy($id)
    {
        $atracao = Atracao::find($id);

        if ($atracao->imagem) {
            Storage::disk('public')->delete($atracao->imagem);
        }

        $atracao->delete();

        return redirect('atracao')->with('success', 'Atração removida com sucesso!');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Atracao::with('destino')
                        ->where('nome', 'like', "%$request->valor%")
                        ->get();
        } else {
            $dados = Atracao::with('destino')->get();
        }

        $graficoLabels = $dados->pluck('nome');
        $graficoDados  = $dados->map(function ($atracao) {
            return $atracao->reservas()->where('status', 'Confirmada')->count();
        });

        return view('atracao.list', compact('dados', 'graficoLabels', 'graficoDados'));
    }
}
