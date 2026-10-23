<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Destinos e Reservas</title>
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
        ul {
            margin: 0;
            padding-left: 15px;
        }
    </style>
</head>
<body>

    <div class="header-info">
        Gerado em: {{ date('d/m/Y H:i') }} | BioViagens
    </div>

    <h2>Relatório de Destinos Turísticos e Passageiros</h2>

    <table>
        <thead>
            <tr>
                <th>Destino</th>
                <th>Localização</th>
                <th>Preço</th>
                <th>Atrações Cadastradas</th>
                <th>Clientes com Reserva</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($destinos as $destino)
                <tr>
                    <td><strong>{{ $destino->nome }}</strong></td>
                    <td>{{ $destino->localizacao }}</td>
                    <td>R$ {{ number_format($destino->preco, 2, ',', '.') }}</td>
                    <td>
                        @if ($destino->atracoes->count() > 0)
                            <ul>
                                @foreach ($destino->atracoes as $atracao)
                                    <li>{{ $atracao->nome }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span style="color: #999;">Sem atrações</span>
                        @endif
                    </td>
                    <td>
                        @if ($destino->reservas->count() > 0)
                            <ul>
                                @foreach ($destino->reservas as $reserva)
                                    <li>{{ $reserva->cliente->nome ?? 'Cliente não identificado' }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span style="color: #999;">Nenhuma reserva</span>
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
