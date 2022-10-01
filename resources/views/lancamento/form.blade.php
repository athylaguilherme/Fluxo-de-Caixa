@extends('layouts.base')

@section('conteudo')
    
    <h1>
        @if($lancamento)
        <i class="bi bi-basket-fill"></i> Atualizar lançamento
        @else
        <i class="bi bi-basket-fill"></i>Novo Lançamento
        @endif
    </h1>

    @if ($lancamento)
    <form action="{{ route('lancamento.update', ['id'=>$lancamento->id_lancamento]) }}" method="post" enctype="multipart/form-data">
    @else
    <form action="{{ route('lancamento.store') }}" method="post" enctype="multipart/form-data">
    @endif
        @csrf
        <div class="row">

            <div class="form-group col-md-4">
                <label for="id_centro_custo" class="form-label">Centro de Custo*</label>
                <div>
                    <select name="id_centro_custo" id="id_centro_custo" class="form-control">
                        <option value="">Selecione</option>
                        <optgroup label="Saídas">
                            @foreach ($saidas->where('id_tipo',2)->get() as $centrosDeCusto)
                                <option value="{{$centrosDeCusto->id_centro_custo}}" 
                                    {{$lancamento && $lancamento->id_centro_custo == $centrosDeCusto->id_centro_custo 
                                    ? 'selected' : ''
                                    }} >
                                    {{$centrosDeCusto->centro_custo}}
                                </option>
                                
                            @endforeach
                        </optgroup>
                        <optgroup label="Entradas">
                            @foreach ($entradas->where('id_tipo',1)->get() as $centrosDeCusto)
                                <option value="{{$centrosDeCusto->id_centro_custo}}" 
                                    {{$lancamento && $lancamento->id_centro_custo == $centrosDeCusto->id_centro_custo 
                                    ? 'selected' : ''
                                    }} >
                                    {{$centrosDeCusto->centro_custo}}
                                </option>
                                
                            @endforeach
                        </optgroup>
                    
                    </select>
               </div>
            
            </div>
            <div class="form-group col-md-2">
                <label for="dt_faturamento" class="form-label">DT Faturamento*</label>
                <input type="date" name="dt_faturamento" id="dt_faturamento" class="form-control" required
                value="{{$lancamento ? $lancamento->dt_faturamento->format('Y-m-d') : old('dt_faturamento')}}">
           </div>
           <div class="form-group col-md-2">
                <label for="valor" class="form-label">Valor*</label>
                <input type="number" name="valor" id="valor" class="form-control" min="0" required
                value="{{$lancamento ? $lancamento->valor : old('valor')}}">
           </div>

           <div class="form-group col-md-12">
                <label for="arquivo" class="form-label">Arquivo</label>
                <input type="file" name="arquivo" id="arquivo" class="form-control">
            </div>

           <div class="form-group col-md-12">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea name="descricao" id="descricao" rows="3" class="form-control">
                    {{$lancamento ? $lancamento->descricao : old('descricao')}}
                </textarea>
           </div>

            <div class="form-group col-md-2">
                <label for="btn-enviar" class="form-label">&nbsp;</label>
                <input  class='btn btn-success form-control' type="submit" value="{{ $lancamento? 'Atualizar' : 'Cadastrar' }}">
            </div>     
        </div>
    </form>

@endsection