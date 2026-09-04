@extends('main')
@section('titulo', 'Clientes — BioViagens')
@section('conteudo')

    <div class="page-header d-flex justify-content-between align-items-center">
        <h3><i class="bi bi-people-fill me-2"></i> Clientes</h3>
        <a href="{{ url('cliente/create') }}" class="btn btn-light btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Novo Cliente
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('cliente.search') }}" method="post" class="row g-2 align-items-end">
                @csrf
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Buscar por</label>
                    <select name="tipo" class="form-select">
                        <option value="nome">Nome</option>
                        <option value="cpf">CPF</option>
                        <option value="telefone">Telefone</option>
                        <option value="email">E-mail</option>
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
                    <a href="{{ url('cliente') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="text-muted small">{{ $dados->count() }} registro(s) encontrado(s)</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dados as $item)
                        <tr>
                            <td class="text-muted small">{{ $item->id }}</td>
                            <td class="fw-semibold">{{ $item->nome }}</td>
                            <td>{{ $item->cpf }}</td>
                            <td>{{ $item->telefone }}</td>
                            <td>{{ $item->email }}</td>
                            <td class="text-center">
                                <a class="btn btn-warning btn-sm me-1" href="{{ route('cliente.edit', $item->id) }}" title="Editar">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('cliente.destroy', $item->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Deseja excluir este cliente?')" title="Excluir">
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
