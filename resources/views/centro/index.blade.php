@extends('layouts.base')

@section('conteudo')

    <h1><i class="bi bi-basket-fill"></i> Centro de Custo - 
        <a class="btn btn-dark" href="{{ route('centro.created',) }}">Novo <i class="bi bi-plus"></i></a>  
    </h1>
     
    <table class="table table-striped table-border">
        <thead>
            <tr>
                <th>Ações</th>
                <th>ID</th>
                <th>Tipo</th>
                <th>Centro de custo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($centros->get() as $centro)
            <tr>
                <td> 
                    <a class="btn btn-warning" href="{{ route('centro.edit',['id'=>$centro->id_centro_custo]) }}">
                        <i class="bi bi-pencil-square"></i> 
                    </a> 
                </td>
                <td>{{ $centro->id_centro_custo }}</td>
                <td>{{ $centro->tipo->tipo }}</td>
                <td>{{ $centro->centro_custo}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


@endsection