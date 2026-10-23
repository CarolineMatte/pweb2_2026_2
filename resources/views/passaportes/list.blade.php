@extends('main')
@section('titulo', 'Passaportes — BioViagens')
@section('conteudo')

    <div class="page-header d-flex justify-content-between align-items-center">
        <h3><i class="bi bi-passport me-2"></i> Passaportes</h3>
        <a href="{{ route('passaportes.create') }}" class="btn btn-light btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Novo Passaporte
        </a>
    </div>

    @if (session('sucesso'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('sucesso') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-white">
            <span class="text-muted small">{{ $passaportes->count() }} registro(s) encontrado(s)</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nº Documento</th>
                        <th>País Emissor</th>
                        <th>Validade</th>
                        <th>Cliente</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($passaportes as $item)
                        <tr>
                            <td class="text-muted small">{{ $item->id }}</td>
                            <td class="fw-semibold">{{ $item->numero_documento }}</td>
                            <td><i class="bi bi-flag me-1 text-primary"></i>{{ $item->pais_emissor }}</td>
                            <td>
                                @php
                                    $validade = \Carbon\Carbon::parse($item->data_validade);
                                    $vencido  = $validade->isPast();
                                @endphp
                                <span class="badge {{ $vencido ? 'bg-danger' : 'bg-success' }}">
                                    {{ $validade->format('d/m/Y') }}
                                    {{ $vencido ? '(Vencido)' : '' }}
                                </span>
                            </td>
                            <td>
                                <i class="bi bi-person me-1 text-secondary"></i>
                                {{ $item->cliente->nome ?? '—' }}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-warning btn-sm me-1"
                                   href="{{ route('passaportes.edit', $item->id) }}" title="Editar">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('passaportes.destroy', $item->id) }}"
                                      method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Deseja excluir este passaporte?')" title="Excluir">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                Nenhum passaporte cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@stop
