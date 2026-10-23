@extends('main')
@section('titulo', 'Destinos — BioViagens')
@section('conteudo')

    <div class="page-header d-flex justify-content-between align-items-center">
        <h3><i class="bi bi-geo-alt-fill me-2"></i> Destinos</h3>
        <a href="{{ url('destino/create') }}" class="btn btn-light btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Novo Destino
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="card mb-4">
        <div class="card-header bg-white fw-semibold">
            <i class="bi bi-pie-chart-fill me-2 text-primary"></i> Destinos mais procurados (Reservas Confirmadas)
        </div>
        <div class="card-body d-flex flex-column align-items-center">
            @php
                $totalReservasConfirmadasDestinos = collect($graficoDados)->sum();
            @endphp

            @if ($totalReservasConfirmadasDestinos == 0)
                <div class="alert alert-info d-flex align-items-center py-2 px-3 my-2" role="alert">
                    <i class="bi bi-info-circle me-2 fs-5"></i>
                    <div>
                        Ainda não há reservas confirmadas para nenhum destino.
                    </div>
                </div>
            @endif

            <div style="max-width: 380px; width: 100%;">
                <canvas id="graficoDestinos"></canvas>
            </div>
        </div>
    </div>

    <script>
        const ctxDestinos = document.getElementById('graficoDestinos').getContext('2d');
        new Chart(ctxDestinos, {
            type: 'pie',
            data: {
                labels: {!! json_encode($graficoLabels) !!},
                datasets: [{
                    data: {!! json_encode($graficoDados) !!},
                    backgroundColor: [
                        '#4e79a7','#f28e2b','#e15759','#76b7b2',
                        '#59a14f','#edc948','#b07aa1','#ff9da7',
                        '#9c755f','#bab0ac'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.label}: ${ctx.parsed} reserva(s) confirmada(s)`
                        }
                    }
                }
            }
        });
    </script>

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
                    <input type="text" name="valor" placeholder="Digite para buscar..." class="form-control">
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
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Localização</th>
                        <th>Preço Diária</th>
                        <th>Atrações</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dados as $item)
                        <tr>
                            <td class="text-muted small">{{ $item->id }}</td>
                            <td>
                                @if (!empty($item->imagem))
                                    <img src="{{ asset('storage/' . $item->imagem) }}"
                                         alt="{{ $item->nome }}"
                                         class="rounded shadow-sm"
                                         style="width: 52px; height: 52px; object-fit: cover;">
                                @else
                                    <span class="d-inline-flex align-items-center justify-content-center bg-light text-muted rounded border"
                                          style="width: 52px; height: 52px;" title="Sem imagem">
                                        <i class="bi bi-image text-secondary"></i>
                                    </span>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $item->nome }}</td>
                            <td><i class="bi bi-geo-alt me-1 text-danger"></i>{{ $item->localizacao }}</td>
                            <td>R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $item->atracoes ? $item->atracoes->count() : 0 }} atração(ões)
                                </span>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-warning btn-sm me-1" href="{{ url('destino/edit/' . $item->id) }}" title="Editar">
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
