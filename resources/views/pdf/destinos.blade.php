<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Destinos</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; margin: 15px; }
        h2 { text-align: center; color: #0d6efd; margin-bottom: 5px; }
        p.subtitulo { text-align: center; font-size: 10px; color: #666; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
    </style>
</head>
<body>
    <h2>BioViagens - Relatório de Destinos e Atrações</h2>
    <p class="subtitulo">Gerado em: {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Destino</th>
                <th>País</th>
                <th>Preço Diária</th>
                <th>Total Reservas</th>
                <th>Atrações Cadastradas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($destinos as $destino)
                <tr>
                    <td>{{ $destino->nome }}</td>
                    <td>{{ $destino->pais ?? $destino->localizacao }}</td>
                    <td>R$ {{ number_format($destino->preco, 2, ',', '.') }}</td>
                    <td>{{ $destino->reservas ? $destino->reservas->count() : 0 }}</td>
                    <td>
                        @if($destino->atracoes && $destino->atracoes->count() > 0)
                            {{ $destino->atracoes->pluck('nome')->implode(', ') }}
                        @else
                            <em>Nenhuma atração</em>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Nenhum destino cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
