<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Lancamento, CentroCusto, User, Tipo};
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use DateTime;

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
        $lancamentos = Lancamento::where('id_user',Auth::user()->id_user)
        ->orderby('dt_faturamento','desc')->paginate(2);
        

        //Descrição
        if($request->get('pesquisar'))
        {
            $pesquisar ='%'.$request->get('pesquisar').'%';
            $lancamentos->where('descricao','like',$pesquisar);
        }

        //Datas
        if($request->get('dt_inicio') || $request->get('dt_fim'))
        {
            //Data de Incio
            if ($request->get('dt_inicio')) {
                $dt_inicio = $request->get('dt_inicio');
            } else {
                $dt = new Carbon($request->get('dt_fim'));
                $dt->subDays(10);
                $dt_inicio = $dt;
            }
            // /Data de Inicio

            //Data de Fim
            if ($request->get('dt_fim')) {
                $dt_fim = $request->get('dt_fim');
            } else {
                $dt = new Carbon($request->get('dt_inicio'));
                $dt->addDays(10);
                $dt_fim = $dt;
            }
            // /Data de Fim

            // $dt_inicio = $request->get('dt_inicio');
            // $dt_fim = $request->get('dt_fim');

            $lancamentos->wherebetween('dt_faturamento',[$dt_inicio,$dt_fim]);
        }

        //Enviar E-mail
         Mail::to(Auth()->user())->send(new OlaT91Mail(Auth()->user()));
        // Mail::to('teste@t91.app.br')->send(new OlaMd());
        //

        return View('lancamento.index')->with(compact('lancamentos'));
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
        $lancamento->fill($request->all());
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
