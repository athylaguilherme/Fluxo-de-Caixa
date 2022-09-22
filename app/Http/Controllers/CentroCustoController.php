<?php

namespace App\Http\Controllers;

use App\Models\{CentroCusto, Tipo};
use Illuminate\Http\Request;

class CentroCustoController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $centros = CentroCusto::OrderBy('centro_custo');
        
        return View('centro.index')->with(compact('centros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $centro = null;
        $tipos = Tipo::orderby('tipo')->Get();
        return view('centro.form')->with(compact('centro','tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $centro = new CentroCusto();
        $centro->fill($request->all());
        $centro->save();

        return redirect()->route('centro.index')->with('success','Cadastro com Sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CentroCusto  $centro
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $centro = CentroCusto::find($id);
        return view('centro.show')->with(compact('centro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CentroCusto  $centro
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $centro = CentroCusto::find($id);
        $tipos = Tipo::orderby('tipo')->Get();
        return view('centro.form')->with(compact('centro','tipos'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CentroCusto  $centro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $centro = CentroCusto::find($id);
        $centro->fill($request->all());
        $centro->save();

        return redirect()->route('centro.index')->with('success','Atualizado com Sucesso!');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CentroCusto  $centro
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $centro = CentroCusto::find($id);
        $centro->delete();

        return redirect()->route('centro.index')->with('danger','Deletado com Sucesso!');
    }
}
