@extends('main')
@section('titulo', 'Destinos — BioViagens')
@section('conteudo')

    <div class="page-header d-flex justify-content-between align-items-center">
        <h3><i class="bi bi-geo-alt-fill me-2"></i> Destinos</h3>
        <a href="{{ url('destino/create') }}" class="btn btn-light btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Novo Destino
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('destino.search') }}" method="post" class="row g-2 align-items-end">
                @csrf
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Buscar por</label>
                    <select name="tipo" class="form-select">
                        <option value="nome">Nome</option>
                        <option value="localizacao">Localização</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Valor</label>
                    <input type="text" name="valor" placeholder="Digite para pesquisar..." class="form-control">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Buscar
                    </button>
                    <a href="{{ url('destino') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <span class="text-muted small">{{ $dados->count() }} registro(s) encontrado(s)</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Localização</th>
                        <th>Preço</th>
                        <th>Descrição</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dados as $item)
                        <tr>
                            <td class="text-muted small">{{ $item->id }}</td>
                            <td class="fw-semibold">{{ $item->nome }}</td>
                            <td><i class="bi bi-pin-map me-1 text-primary"></i>{{ $item->localizacao }}</td>
                            <td class="text-success fw-semibold">R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                            <td class="text-muted small">{{ $item->descricao }}</td>
                            <td class="text-center">
                                <a class="btn btn-warning btn-sm me-1" href="{{ route('destino.edit', $item->id) }}" title="Editar">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('destino.destroy', $item->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Deseja excluir este destino?')" title="Excluir">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop
