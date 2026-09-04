@extends('main')
@section('titulo', 'Cliente — BioViagens')
@section('conteudo')

    @php
        $editando = !empty($data->id);
        $action   = $editando ? route('cliente.update', $data->id) : route('cliente.store');
    @endphp

    <div class="page-header">
        <h3>
            <i class="bi bi-person-{{ $editando ? 'gear' : 'plus' }}-fill me-2"></i>
            {{ $editando ? 'Editar Cliente' : 'Novo Cliente' }}
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
                        <label class="form-label fw-semibold">Nome <span class="text-danger">*</span></label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                            value="{{ old('nome', $data->nome ?? '') }}" placeholder="Nome completo">
                        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">CPF <span class="text-danger">*</span></label>
                        <input type="text" name="cpf" class="form-control @error('cpf') is-invalid @enderror"
                            value="{{ old('cpf', $data->cpf ?? '') }}" placeholder="000.000.000-00" maxlength="14">
                        @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Telefone</label>
                        <input type="text" name="telefone" class="form-control @error('telefone') is-invalid @enderror"
                            value="{{ old('telefone', $data->telefone ?? '') }}" placeholder="(00) 00000-0000" maxlength="15">
                        @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">E-mail</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $data->email ?? '') }}" placeholder="email@exemplo.com">
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Salvar
                    </button>
                    <a href="{{ url('cliente') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>

@stop
