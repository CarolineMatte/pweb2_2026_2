<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Atracao;
use App\Models\Destino;

class AtracaoController extends Controller
{
    // INDEX — lista todas as atrações com filtro de busca por nome
    public function index()
    {
        // Sem filtro: retorna todos os registros
        $dados = Atracao::with('destino')->get();

        return view('atracao.list')->with(['dados' => $dados]);
    }

    // CREATE — exibe o formulário em branco para nova atração
    function create()
    {
        // Busca todos os destinos para popular o <select> no formulário
        $destinos = Destino::orderBy('nome')->get();

        return view('atracao.form', compact('destinos'));
    }

    // STORE — valida e persiste o novo registro + faz upload da imagem
    function store(Request $request)
    {
        // Validação dos campos obrigatórios
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

        // Upload da imagem 
        $nomeArquivo = null;
        if ($request->hasFile('imagem')) {
            // store() salva o arquivo na pasta 'atracoes' dentro do disco 'public'
            // e retorna o caminho relativo (ex: "atracoes/abc123.jpg")
            $nomeArquivo = $request->file('imagem')->store('atracoes', 'public');
        }

        // Cria o registro no banco com os dados do formulário + nome do arquivo
        Atracao::create([
            'nome'       => $request->nome,
            'descricao'  => $request->descricao,
            'destino_id' => $request->destino_id,
            'imagem'     => $nomeArquivo,
        ]);

        return redirect('atracao')->with('success', 'Atração cadastrada com sucesso!');
    }

    // EDIT — exibe o formulário preenchido para edição
    function edit($id)
    {
        $data     = Atracao::find($id);
        $destinos = Destino::orderBy('nome')->get();

        return view('atracao.form', compact('data', 'destinos'));
    }

    // UPDATE — valida, remove imagem antiga (se houver nova) e atualiza o registro
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

        // Atualização de imagem
        // Só executa o upload se o usuário enviou um novo arquivo
        $nomeArquivo = $atracao->imagem; // mantém a imagem atual por padrão
        if ($request->hasFile('imagem')) {
            // Remove o arquivo ANTIGO do disco 'public' antes de salvar o novo
            if ($atracao->imagem) {
                Storage::disk('public')->delete($atracao->imagem);
            }
            // Faz o upload do novo arquivo e obtém o caminho relativo
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

    // DESTROY — remove o registro e exclui o arquivo de imagem do disco
    function destroy($id)
    {
        $atracao = Atracao::find($id);

        // Exclusão da imagem
        // Se existir um arquivo cadastrado, apaga-o do disco 'public'
        if ($atracao->imagem) {
            Storage::disk('public')->delete($atracao->imagem);
        }

        $atracao->delete();

        return redirect('atracao')->with('success', 'Atração removida com sucesso!');
    }

    // SEARCH — filtra atrações pelo nome usando LIKE
    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            // Busca registros cujo 'nome' contenha o valor digitado (case-insensitive)
            $dados = Atracao::with('destino')
                        ->where('nome', 'like', "%$request->valor%")
                        ->get();
        } else {
            // Campo vazio: retorna tudo
            $dados = Atracao::with('destino')->get();
        }

        return view('atracao.list', compact('dados'));
    }
}
