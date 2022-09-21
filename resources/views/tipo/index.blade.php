@extends('layouts.base')

@section('conteudo')

    <h1>Tipos de lançamentos - 
        <a class="btn btn-dark" href="{{ route('tipo.created',) }}">Novo <i class="bi bi-plus"></i></a>  
    </h1>
     
    <table class="table table-striped table-border">
        <thead>
            <tr>
                <th>Ações</th>
                <th>ID</th>
                <th>Tipo</th>
                <th>--</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tipos->get() as $tipo)
            <tr>
                <td> 
                    <a class="btn btn-warning" href="{{ route('tipo.edit',['id'=>$tipo->id_tipo]) }}">Editar <i class="bi bi-pencil-square"></i> </a> 
                </td>
                <td>{{ $tipo->id_tipo }}</td>
                <td>{{ $tipo->tipo }}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>


@endsection