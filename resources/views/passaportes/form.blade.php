@extends('main')
@section('titulo', 'Passaporte — BioViagens')
@section('conteudo')

    @php
        $editando = !empty($passaporte->id);
        $action   = $editando ? route('passaportes.update', $passaporte->id) : route('passaportes.store');
    @endphp

    <div class="page-header">
        <h3>
            <i class="bi bi-passport me-2"></i>
            {{ $editando ? 'Editar Passaporte' : 'Novo Passaporte' }}
        </h3>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <form action="{{ $action }}" method="post">
                @csrf
                @if ($editando) @method('PUT') @endif

                <div class="row g-3">

                    {{-- Número do Documento --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Nº do Documento <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="numero_documento" maxlength="30"
                               class="form-control @error('numero_documento') is-invalid @enderror"
                               value="{{ old('numero_documento', $passaporte->numero_documento ?? '') }}"
                               placeholder="Ex: AB123456">
                        @error('numero_documento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- País Emissor --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            País Emissor <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="pais_emissor" maxlength="100"
                               class="form-control @error('pais_emissor') is-invalid @enderror"
                               value="{{ old('pais_emissor', $passaporte->pais_emissor ?? '') }}"
                               placeholder="Ex: Brasil">
                        @error('pais_emissor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Data de Validade --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Data de Validade <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="data_validade"
                               class="form-control @error('data_validade') is-invalid @enderror"
                               value="{{ old('data_validade', $passaporte->data_validade ?? '') }}">
                        @error('data_validade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Select de Cliente (1:1 — só clientes sem passaporte) --}}
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">
                            Cliente <span class="text-danger">*</span>
                        </label>
                        <select name="cliente_id"
                                class="form-select @error('cliente_id') is-invalid @enderror">
                            <option value="">— Selecione um cliente —</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ old('cliente_id', $passaporte->cliente_id ?? '') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nome }} — CPF: {{ $cliente->cpf }}
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Apenas clientes sem passaporte cadastrado são exibidos.
                        </div>
                    </div>

                </div>{{-- /row --}}

                <hr class="my-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Salvar
                    </button>
                    <a href="{{ route('passaportes.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>

@stop
