<!DOCTYPE html>
<html>

<head>

    <title>Listagem de Cursos</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <div class="row">

        <h3>Listagem de Cursos</h3>

    </div>


    <div class="row mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Carga Horária</th>
                    <th scope="col">Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dados as $item)
                    <tr>
                        <th scope='row'>{{ $item->id }}</th>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->requisito }}</td>
                        <td>{{ $item->carga_horaria }}</td>
                        <td>R${{ $item->valor }}</td>
                        <td>
                    </tr>
                    @endforeach
                            <a class='btn btn-primary' title='Turmas'
                                href="{{ route('curso.turmas', $item->id) }}">Ver Turmas {{ $item->turmas->count()}}</a>
                        </td>
                        <td>
                            <a class='btn btn-warning' title='Editar' href="{{ route('curso.edit', $item->id) }}">Editar</a>
                        </td>
                        <td>
                            <form action="{{ route('curso.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class='btn btn-danger' title='Exclur'
                                    onclick="return confirm('Deseja Excluir?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
