@extends('main')
@section('titulo', 'Reserva — BioViagens')
@section('conteudo')

    @php
        $editando = !empty($data->id);
        $action   = $editando ? route('reserva.update', $data->id) : route('reserva.store');
    @endphp

    <div class="page-header">
        <h3>
            <i class="bi bi-calendar2-{{ $editando ? 'check' : 'plus' }}-fill me-2"></i>
            {{ $editando ? 'Editar Reserva' : 'Nova Reserva' }}
        </h3>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <form action="{{ $action }}" method="post">
                @csrf
                @if ($editando) @method('PUT') @endif
                <input type="hidden" name="id" value="{{ old('id', $data->id ?? '') }}">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Cliente <span class="text-danger">*</span></label>
                        <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror">
                            <option value="">— Selecione um cliente —</option>
                            @foreach ($clientes as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('cliente_id', $data->cliente_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Destino <span class="text-danger">*</span></label>
                        <select name="destino_id" id="select_destino" class="form-select @error('destino_id') is-invalid @enderror" onchange="atualizarAtracoes()">
                            <option value="">— Selecione um destino —</option>
                            @foreach ($destinos as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('destino_id', $data->destino_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nome }} — R$ {{ number_format($item->preco, 2, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('destino_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Atração do Destino</label>
                        <select name="atracao_id" id="select_atracao" class="form-select @error('atracao_id') is-invalid @enderror">
                            <option value="">— Selecione primeiro um destino —</option>
                        </select>
                        @error('atracao_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">Apenas atrações pertencentes ao destino selecionado serão listadas.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            @foreach (['Confirmada', 'Pendente', 'Cancelada'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('status', $data->status ?? '') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Data de Ida <span class="text-danger">*</span></label>
                        <input type="date" name="data_reserva"
                            class="form-control @error('data_reserva') is-invalid @enderror"
                            value="{{ old('data_reserva', $data->data_reserva ?? '') }}">
                        @error('data_reserva') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Data de Volta</label>
                        <input type="date" name="data_volta"
                            class="form-control @error('data_volta') is-invalid @enderror"
                            value="{{ old('data_volta', $data->data_volta ?? '') }}">
                        @error('data_volta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">Opcional. Deve ser igual ou posterior à data de ida.</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Observação</label>
                        <textarea name="observacao" class="form-control" rows="3"
                            placeholder="Informações adicionais sobre a reserva...">{{ old('observacao', $data->observacao ?? '') }}</textarea>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Salvar
                    </button>
                    <a href="{{ url('reserva') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const destinosAtracoes = {
            @foreach ($destinos as $dest)
                "{{ $dest->id }}": [
                    @foreach ($dest->atracoes as $atracao)
                        { id: "{{ $atracao->id }}", nome: "{{ addslashes($atracao->nome) }}" },
                    @endforeach
                ],
            @endforeach
        };

        const atracaoSelecionada = "{{ old('atracao_id', $data->atracao_id ?? '') }}";

        function atualizarAtracoes() {
            const destinoId = document.getElementById('select_destino').value;
            const selectAtracao = document.getElementById('select_atracao');

            selectAtracao.innerHTML = '<option value="">— Nenhuma atração escolhida —</option>';

            if (destinoId && destinosAtracoes[destinoId] && destinosAtracoes[destinoId].length > 0) {
                destinosAtracoes[destinoId].forEach(function(atracao) {
                    const opt = document.createElement('option');
                    opt.value = atracao.id;
                    opt.text = atracao.nome;
                    if (atracao.id == atracaoSelecionada) {
                        opt.selected = true;
                    }
                    selectAtracao.appendChild(opt);
                });
            } else if (destinoId) {
                selectAtracao.innerHTML = '<option value="">— Este destino não possui atrações cadastradas —</option>';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            atualizarAtracoes();
        });
    </script>

@stop
