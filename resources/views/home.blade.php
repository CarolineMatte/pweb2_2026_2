@extends('main')
@section('titulo', 'Início — BioViagens')
@section('conteudo')

    <div class="text-center mb-5">
        <h2 class="fw-bold" style="color: #0d1b2a;">
            Bem-vindo ao <span style="color: #1e3a5f;">BioViagens</span>
        </h2>
        <p class="text-muted">Sistema de gerenciamento de viagens ecoturísticas</p>
        <hr>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <i class="bi bi-people-fill card-icon-navy" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3 fw-bold">Clientes</h5>
                    <p class="card-text text-muted">Gerencie o cadastro de clientes da agência.</p>
                    <a href="{{ url('cliente') }}" class="btn btn-navy mt-2">
                        <i class="bi bi-arrow-right-circle me-1"></i> Acessar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <i class="bi bi-geo-alt-fill card-icon-navy" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3 fw-bold">Destinos</h5>
                    <p class="card-text text-muted">Cadastre e consulte os destinos disponíveis.</p>
                    <a href="{{ url('destino') }}" class="btn btn-navy mt-2">
                        <i class="bi bi-arrow-right-circle me-1"></i> Acessar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <i class="bi bi-calendar-check-fill card-icon-navy" style="font-size: 3rem;"></i>
                    <h5 class="card-title mt-3 fw-bold">Reservas</h5>
                    <p class="card-text text-muted">Registre e acompanhe as reservas realizadas.</p>
                    <a href="{{ url('reserva') }}" class="btn btn-navy mt-2">
                        <i class="bi bi-arrow-right-circle me-1"></i> Acessar
                    </a>
                </div>
            </div>
        </div>

    </div>

@stop
