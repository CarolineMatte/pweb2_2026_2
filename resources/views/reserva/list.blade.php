@extends('main')
@section('titulo', 'Reservas — BioViagens')
@section('conteudo')

    <div class="page-header d-flex justify-content-between align-items-center">
        <h3><i class="bi bi-calendar-check-fill me-2"></i> Reservas</h3>
        <a href="{{ url('reserva/create') }}" class="btn btn-light btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Nova Reserva
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('reserva.search') }}" method="post" class="row g-2 align-items-end">
                @csrf
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Buscar por</label>
                    <select name="tipo" class="form-select">
                        <option value="cliente">Cliente (Nome)</option>
                        <option value="status">Status</option>
                        <option value="data_reserva">Data</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Valor</label>
                    <input type="text" name="valor" placeholder="Ex: Confirmada" class="form-control">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Buscar
                    </button>
                    <a href="{{ url('reserva') }}" class="btn btn-outline-secondary">
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
                        <th>Cliente</th>
                        <th>Destino</th>
                        <th>Atração</th>
                        <th>Ida / Volta</th>
                        <th>Status</th>
                        <th>Observação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dados as $item)
                        <tr>
                            <td class="text-muted small">{{ $item->id }}</td>
                            <td>{{ $item->cliente->nome ?? '—' }}</td>
                            <td>{{ $item->destino->nome ?? '—' }}</td>
                            <td>
                                @if ($item->atracao)
                                    <span class="badge bg-secondary"><i class="bi bi-stars me-1"></i>{{ $item->atracao->nome }}</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <i class="bi bi-calendar-event me-1 text-primary"></i>
                                {{ date('d/m/Y', strtotime($item->data_reserva)) }}
                                @if (!empty($item->data_volta))
                                    <br><small class="text-muted"><i class="bi bi-arrow-return-left me-1"></i>volta: {{ date('d/m/Y', strtotime($item->data_volta)) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $item->status == 'Confirmada' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>{{ $item->observacao ?? '—' }}</td>
                            <td class="text-center">
                                <a class="btn btn-warning btn-sm me-1" href="{{ url('reserva/edit/' . $item->id) }}" title="Editar">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('reserva.destroy', $item->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Deseja excluir esta reserva?')" title="Excluir">
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
