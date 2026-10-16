@extends('main')
@section('titulo', 'Atração — BioViagens')
@section('conteudo')

    @php
        $editando = !empty($data->id);
        $action   = $editando ? route('atracao.update', $data->id) : route('atracao.store');
    @endphp

    <div class="page-header">
        <h3>
            <i class="bi bi-stars me-2"></i>
            {{ $editando ? 'Editar Atração' : 'Nova Atração Turística' }}
        </h3>
    </div>

    <div class="card">
        <div class="card-body p-4">
            {{-- enctype="multipart/form-data" é OBRIGATÓRIO para envio de arquivos --}}
            <form action="{{ $action }}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($editando) @method('PUT') @endif

                <div class="row g-3">

                    {{-- Nome da Atração --}}
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">
                            Nome da Atração <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nome"
                               class="form-control @error('nome') is-invalid @enderror"
                               value="{{ old('nome', $data->nome ?? '') }}"
                               placeholder="Ex: Cachoeira do Véu de Noiva">
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Select de Destino — carregado do banco de dados --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Destino <span class="text-danger">*</span>
                        </label>
                        <select name="destino_id"
                                class="form-select @error('destino_id') is-invalid @enderror">
                            <option value="">— Selecione um destino —</option>
                            @foreach ($destinos as $destino)
                                <option value="{{ $destino->id }}"
                                    {{-- Mantém a seleção ao editar ou ao retornar com erro de validação --}}
                                    {{ old('destino_id', $data->destino_id ?? '') == $destino->id ? 'selected' : '' }}>
                                    {{ $destino->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('destino_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Descrição --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Descrição <span class="text-danger">*</span>
                        </label>
                        <textarea name="descricao" rows="4"
                                  class="form-control @error('descricao') is-invalid @enderror"
                                  placeholder="Descreva a atração turística...">{{ old('descricao', $data->descricao ?? '') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Upload de Imagem --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Foto da Atração</label>

                        {{-- Pré-visualização da imagem atual (apenas no modo edição) --}}
                        @if ($editando && !empty($data->imagem))
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $data->imagem) }}"
                                     alt="Imagem atual"
                                     style="height: 120px; border-radius: .375rem; border: 1px solid #dee2e6;">
                                <p class="text-muted small mt-1">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Imagem atual. Envie uma nova para substituí-la.
                                </p>
                            </div>
                        @endif

                        <input type="file" name="imagem" accept="image/*"
                               class="form-control @error('imagem') is-invalid @enderror">
                        <div class="form-text">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2 MB.</div>
                        @error('imagem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>{{-- /row --}}

                <hr class="my-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Salvar
                    </button>
                    <a href="{{ url('atracao') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>
                </div>

            </form>
        </div>
    </div>

@stop
