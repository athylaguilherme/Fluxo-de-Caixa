<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Lancamento, CentroCusto, User, Tipo};
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use DateTime;
use Illuminate\Support\Facades\Storage;

use App\Mail\OlaT91Mail;
use App\Mail\OlaMd;
use Illuminate\Support\Facades\Mail;

class LancamentoController extends Controller
{
    /**
     * Mostrar todos o Lançamentos
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $pesquisar = $request->pesquisar;
        $dt_inicio = null;
        $dt_fim = null;
        if ( $request->dt_inicio ||  $request->dt_fim){
            // data de inicio
            if ($request->dt_inicio) {
                $dt_inicio = $request->dt_inicio;
            } else {
                $dt = new Carbon($request->dt_fim);
                $dt->subDays(10);
                $dt_inicio = $dt;
            }
            // data de fim
            if ($request->dt_fim){
                $dt_fim = $request->dt_fim;
            } else {
                $dt = new Carbon($request->dt_inicio);
                $dt->addDays(10);
                $dt_fim = $dt;
            }           
        }

        $lancamentos = Lancamento::where( function( $query ) use ($pesquisar,$dt_inicio,$dt_fim){
                    $query->where('id_user',Auth::user()->id_user);
                    
                    if($pesquisar){
                        $query->where('descricao','like',"%{$pesquisar}%");
                    }

                    if($dt_inicio || $dt_fim){
                        $query->whereBetween('dt_faturamento', [$dt_inicio, $dt_fim]);
                    }
        })->with(['centroCusto.tipo'])
            ->orderBy('dt_faturamento', 'desc')
            ->paginate(2); 
          
        return view('lancamento.index')
                    ->with(compact('lancamentos'));
        //Enviar E-mail
        //  Mail::to(Auth()->user())->send(new OlaT91Mail(Auth()->user()));
        // Mail::to('teste@t91.app.br')->send(new OlaMd());
        //

        
    }

    /**
     * Encaminha para o Formulario de Cadastro
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lancamento = null;
        $entradas = CentroCusto::where('id_tipo',1)->orderby('centro_custo');
        $saidas = CentroCusto::where('id_tipo',2)->orderby('centro_custo');

        return view('lancamento.form')->with(compact('entradas','saidas','lancamento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lancamento = new Lancamento();
        $lancamento->fill($request->all());
        $lancamento->id_user = Auth::user()->id_user;
        //Subir o arquivo
        if($request->arquivo){
            $extensao =  $request->arquivo->getClientOriginalExtension();
            $lancamento->arquivo = $request->arquivo->storeAs('arquivos',date('YmdHis').'.'.$extensao);
        }
        // $extensao =  $request->arquivo->getClientOriginalExtension();
        // $path = $request->arquivo->storeAs('arquivos',date('YmdHis').'.'.$extensao);
        $lancamento->save();
        return redirect()->route('lancamento.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function show(Lancamento $lancamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $entradas = CentroCusto::where('id_tipo',1)->orderby('centro_custo');
        $saidas = CentroCusto::where('id_tipo',2)->orderby('centro_custo');
        $lancamento = Lancamento::find($id);
        return view('lancamento.form')->with(compact('entradas','saidas','lancamento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $lancamento = Lancamento::find($id);
        // Verificar se um arquivo foi enviado
        // e se já existia um anterior, se tiver vai apagar o anterior
        if($request->arquivo && $lancamento->arquivo !=''){
            if(Storage::exists($lancamento->arquivo)){
                Storage::delete($lancamento->arquivo);
            }
        }
        $lancamento->fill($request->all());
        //Subir
        if($request->arquivo){
            $extensao =  $request->arquivo->getClientOriginalExtension();
            $lancamento->arquivo = $request->arquivo->storeAs('arquivos',date('YmdHis').'.'.$extensao);
        }
        $lancamento->save();

        return redirect()->route('lancamento.index')->with('success','Atualizado com Sucesso!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lancamento $lancamento)
    {
        //
    }
}
