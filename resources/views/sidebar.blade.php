<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #031273;">
  <div class="container">

    <a class="navbar-brand fw-bold" href="{{ url('/') }}" style="color: #6b8eff; letter-spacing: 1px;">
      <i class="bi bi-airplane-engines-fill me-1" style="color: #d4af37;"></i> BioViagens
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarBioViagens" aria-controls="navbarBioViagens"
        aria-expanded="false" aria-label="Abrir menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarBioViagens">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
            <i class="bi bi-house-door me-1"></i> Início
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('cliente*') ? 'active' : '' }}" href="{{ url('cliente') }}">
            <i class="bi bi-people me-1"></i> Clientes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('destino*') ? 'active' : '' }}" href="{{ url('destino') }}">
            <i class="bi bi-geo-alt me-1"></i> Destinos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('reserva*') ? 'active' : '' }}" href="{{ url('reserva') }}">
            <i class="bi bi-calendar-check me-1"></i> Reservas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('atracao*') ? 'active' : '' }}" href="{{ url('atracao') }}">
            <i class="bi bi-stars me-1"></i> Atrações
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('passaporte*') ? 'active' : '' }}" href="{{ route('passaportes.index') }}">
            <i class="bi bi-passport me-1"></i> Passaportes
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-file-earmark-pdf me-1"></i> Relatórios
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('relatorios.clientes') }}" target="_blank"><i class="bi bi-people me-1"></i> Relatório Clientes & Viagens</a></li>
            <li><a class="dropdown-item" href="{{ route('relatorios.destinos') }}" target="_blank"><i class="bi bi-geo-alt me-1"></i> Relatório Destinos & Reservas</a></li>
          </ul>
        </li>
      </ul>
    </div>

  </div>
</nav>
