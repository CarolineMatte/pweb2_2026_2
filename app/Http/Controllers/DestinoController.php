<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Destino;

class DestinoController extends Controller
{
    public function index()
    {
        $dados = Destino::all();

        // Dados para o Gráfico de Pizza — quantas reservas cada destino tem
        $graficoLabels = $dados->pluck('nome');
        $graficoDados  = $dados->map(fn($d) => $d->reservas()->count());

        return view('destino.list', compact('dados', 'graficoLabels', 'graficoDados'));
    }

    function create()
    {
        return view('destino.form');
    }

    function validateForm(Request $request)
    {
        $request->validate([
            'nome'        => 'required',
            'localizacao' => 'required',
            'preco'       => 'required',
            'imagem'      => 'nullable|image|max:2048',
        ], [
            'nome.required'        => "O :attribute é obrigatório",
            'localizacao.required' => "A :attribute é obrigatória",
            'preco.required'       => "O :attribute é obrigatório",
            'imagem.image'         => 'O arquivo enviado deve ser uma imagem.',
            'imagem.max'           => 'A imagem não pode ultrapassar 2 MB.',
        ]);
    }

    // STORE — salva o novo destino + faz upload da imagem
    function store(Request $request)
    {
        $this->validateForm($request);

        // Upload da imagem
        $nomeArquivo = null;
        if ($request->hasFile('imagem')) {
            $nomeArquivo = $request->file('imagem')->store('destinos', 'public');
        }

        Destino::create([
            'nome'        => $request->nome,
            'localizacao' => $request->localizacao,
            'preco'       => $request->preco,
            'descricao'   => $request->descricao,
            'imagem'      => $nomeArquivo,
        ]);

        return redirect('destino')->with("success", 'Registro salvo com sucesso!');
    }

    function edit($id)
    {
        $data = Destino::find($id);

        return view('destino.form', compact('data'));
    }

    // UPDATE — se nova imagem for enviada, remove a antiga e salva a nova
    function update(Request $request, $id)
    {
        $this->validateForm($request);

        $destino = Destino::find($id);

        // Mantém a imagem atual; só substitui se o usuário enviou uma nova
        $nomeArquivo = $destino->imagem;
        if ($request->hasFile('imagem')) {
            // Remove o arquivo antigo do disco 'public'
            if ($destino->imagem) {
                Storage::disk('public')->delete($destino->imagem);
            }
            $nomeArquivo = $request->file('imagem')->store('destinos', 'public');
        }

        $destino->update([
            'nome'        => $request->nome,
            'localizacao' => $request->localizacao,
            'preco'       => $request->preco,
            'descricao'   => $request->descricao,
            'imagem'      => $nomeArquivo,
        ]);

        return redirect('destino')->with("success", 'Registro atualizado com sucesso!');
    }

    // DESTROY — exclui o arquivo de imagem do disco antes de remover o registro
    function destroy($id)
    {
        $destino = Destino::find($id);

        if ($destino->reservas()->exists()) {
            return redirect('destino')->with("error", 'Não é possível excluir: este destino possui reservas associadas.');
        }

        // Exclui a imagem do storage, se existir
        if ($destino->imagem) {
            Storage::disk('public')->delete($destino->imagem);
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
