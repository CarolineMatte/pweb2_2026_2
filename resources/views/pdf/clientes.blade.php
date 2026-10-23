<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Clientes e Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        h2 {
            text-align: center;
            color: #031273;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #031273;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .header-info {
            margin-bottom: 15px;
            font-size: 11px;
            color: #666;
            text-align: right;
        }
        .badge {
            display: inline-block;
            padding: 2px 5px;
            font-size: 10px;
            background-color: #eee;
            border-radius: 3px;
        }
    </style>
</head>
<body>

    <div class="header-info">
        Gerado em: {{ date('d/m/Y H:i') }} | BioViagens
    </div>

    <h2>Relatório Geral de Clientes e Viagens</h2>

    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Contato</th>
                <th>Passaporte</th>
                <th>Destino</th>
                <th>Período</th>
                <th>Atrações do Destino</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clientes as $cliente)
                <tr>
                    <td><strong>{{ $cliente->nome }}</strong><br><small>CPF: {{ $cliente->cpf }}</small></td>
                    <td>{{ $cliente->telefone ?? '—' }}<br><small>{{ $cliente->email }}</small></td>
                    <td>
                        @if ($cliente->passaporte)
                            {{ $cliente->passaporte->numero_documento }} ({{ $cliente->passaporte->pais_emissor }})
                        @else
                            <span style="color: #999;">Sem passaporte</span>
                        @endif
                    </td>
                    <td>
                        {{ $cliente->reserva->destino->nome ?? 'Sem reserva' }}
                    </td>
                    <td>
                        @if ($cliente->reserva)
                            Ida: {{ \Carbon\Carbon::parse($cliente->reserva->data_reserva)->format('d/m/Y') }}<br>
                            Volta: {{ $cliente->reserva->data_volta ? \Carbon\Carbon::parse($cliente->reserva->data_volta)->format('d/m/Y') : '—' }}
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if (isset($cliente->reserva->destino) && $cliente->reserva->destino->atracoes->count() > 0)
                            {{ $cliente->reserva->destino->atracoes->pluck('nome')->implode(', ') }}
                        @else
                            <span style="color: #999;">Nenhuma</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Nenhum cliente cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
