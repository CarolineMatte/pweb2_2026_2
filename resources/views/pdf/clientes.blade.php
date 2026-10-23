<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Clientes e Reservas</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; margin: 15px; }
        h2 { text-align: center; color: #198754; margin-bottom: 5px; }
        p.subtitulo { text-align: center; font-size: 10px; color: #666; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
    </style>
</head>
<body>
    <h2>BioViagens - Relatório de Clientes e Reservas</h2>
    <p class="subtitulo">Gerado em: {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>CPF</th>
                <th>Passaporte</th>
                <th>Destino</th>
                <th>Ida / Volta</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->cpf }}</td>
                    <td>{{ $cliente->passaporte ? $cliente->passaporte->numero_documento . ' (' . $cliente->passaporte->pais_emissor . ')' : 'Não possui' }}</td>
                    <td>{{ $cliente->reserva && $cliente->reserva->destino ? $cliente->reserva->destino->nome : 'Sem reserva' }}</td>
                    <td>
                        @if($cliente->reserva)
                            {{ date('d/m/Y', strtotime($cliente->reserva->data_reserva)) }}
                            @if($cliente->reserva->data_volta)
                                até {{ date('d/m/Y', strtotime($cliente->reserva->data_volta)) }}
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Nenhum cliente cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
