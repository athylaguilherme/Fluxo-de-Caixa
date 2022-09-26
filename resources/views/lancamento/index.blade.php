@extends('layouts.base')

@section('conteudo')

    <h1><i class="bi bi-basket-fill"></i> Lançamento - 
        <a class="btn btn-dark" href="{{ route('lancamento.created',) }}">Novo <i class="bi bi-plus"></i></a>  
    </h1>

     <h2>
        Usuário: {{Auth::user()->nome}} - Total de Lançamento - {{$lancamentos->count()}}
        - R${{$lancamentos->sum('valor')}}
     </h2>
    <table class="table table-striped table-border">
        <thead>
            <tr>
                <th>Ações</th>
                <th>ID</th>
                <th>Data de Faturamento</th>
                <th>R$ Valor</th>
                <th>Tipo</th>
                <th>Centro de custo</th>
                <th>Descrição</th>
                <th>Data de Lançamento</th>
                <th>Data de Atualização</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($lancamentos->get() as $lancamento)
            <tr>
                <td> 
                    <a class="btn btn-warning" href="{{ route('lancamento.edit',['id'=>$lancamento->id_lancamento]) }}">
                        Editar <i class="bi bi-pencil-square"></i> 
                    </a> 
                </td>
                <td>{{ $lancamento->id_lancamento }}</td>
                <td>{{ $lancamento->dt_faturamento->format('d/m/Y') }}</td>
                <td>{{ $lancamento->valor }}</td>
                <td>{{ $lancamento->centroCusto->tipo->tipo }}</td>
                <td>{{ $lancamento->centroCusto->centro_custo}}</td>
                <td>{{ $lancamento->descricao }}</td>
                <td>{{ $lancamento->created_at->format('d/m/Y') }}</td>
                <td>{{ $lancamento->update_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


@endsection