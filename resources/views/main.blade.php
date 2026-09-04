<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'BioViagens')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --navy:       #031273;
            --navy-mid:   #0a1fa8;
            --navy-light: #1a35d0;
            --accent:     #6b8eff;
            --gold:       #d4af37;
            --gold-hover: #c49f27;
        }

        body {
            background-color: #f2f5f8; /* Cor gelo */
            font-family: 'Segoe UI', sans-serif;
        }

        /* --- Cabeçalho de página --- */
        .page-header {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
            color: #fff;
            padding: 1.2rem 1.5rem;
            border-radius: .5rem;
            margin-bottom: 1.5rem;
        }
        .page-header h3 { margin: 0; font-weight: 600; }

        /* --- Cards --- */
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            border-radius: .5rem;
        }
        .card-header {
            font-weight: 600;
            background-color: #fff;
            border-bottom: 1px solid #e2e8f0;
        }

        /* --- Tabela --- */
        .table thead th {
            background-color: var(--navy);
            color: #fff;
            border: none;
        }
        .table tbody tr:hover { background-color: #e8f0fe; }

        /* --- Botões de ação --- */
        .btn-sm { font-size: .8rem; }

        /* --- Cards da home --- */
        .card-icon-navy  { color: var(--gold); }
        
        /* --- Botões Destaque (Navy com toque Ouro) --- */
        .btn-primary, .btn-navy {
            background-color: var(--navy-mid);
            border-color: var(--navy-mid);
            color: #fff !important;
            font-weight: 500;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active,
        .btn-navy:hover, .btn-navy:focus, .btn-navy:active {
            background-color: var(--navy);
            border-color: var(--gold);
            color: var(--gold) !important;
        }
    </style>
</head>

<body>
    @include('sidebar')

    <main class="container py-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="bi bi-exclamation-circle me-1"></i> Por favor, verifique os erros abaixo:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        @yield('conteudo')

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
