@extends('main')
@section('titulo', 'Destino — BioViagens')
@section('conteudo')

    @php
        $editando = !empty($data->id);
        $action   = $editando ? route('destino.update', $data->id) : route('destino.store');
    @endphp

    <div class="page-header">
        <h3>
            <i class="bi bi-geo-alt-fill me-2"></i>
            {{ $editando ? 'Editar Destino' : 'Novo Destino' }}
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
                        <label class="form-label fw-semibold">Nome do Destino <span class="text-danger">*</span></label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                            value="{{ old('nome', $data->nome ?? '') }}" placeholder="Ex: Amazônia Brasileira">
                        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Localização <span class="text-danger">*</span></label>
                        <input type="text" name="localizacao" class="form-control @error('localizacao') is-invalid @enderror"
                            value="{{ old('localizacao', $data->localizacao ?? '') }}" placeholder="Ex: Brasil, América do Sul">
                        @error('localizacao') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Preço (R$) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" step="0.01" min="0" name="preco"
                                class="form-control @error('preco') is-invalid @enderror"
                                value="{{ old('preco', $data->preco ?? '') }}" placeholder="0,00">
                            @error('preco') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3"
                            placeholder="Descreva o destino...">{{ old('descricao', $data->descricao ?? '') }}</textarea>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Salvar
                    </button>
                    <a href="{{ url('destino') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>

@stop
