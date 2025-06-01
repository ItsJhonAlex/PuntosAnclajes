<?php

namespace App\Http\Controllers;

use App\Models\SystemUse;
use Illuminate\Http\Request;

class SystemUseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('systemUse.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('systemUse.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'uso_sistema_proteccion' => 'required',
        ]);

        SystemUse::create($request->all());
        return redirect()->route('systemUse')->with('success', 'Resistencia de sistema de protección creada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $resistencias = SystemUse::orderBy('id')
            ->select('id', 'uso_sistema_proteccion')
            ->get();

        $data = [];
        foreach ($resistencias as $resistencia) {
            $data[] = [
                'id' => $resistencia->id,
                'uso_sistema_proteccion' => $resistencia->uso_sistema_proteccion,
            ];
        }

        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $systemUse = SystemUse::find($id);
        return view('systemUse.edit', compact('systemUse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'uso_sistema_proteccion' => 'required',
        ]);

        $systemUse = SystemUse::find($id);
        $systemUse->update($request->all());
        return redirect()->route('systemUse')->with('success', 'Resistencia de sistema de protección actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SystemUse::find($id)->delete();
        return redirect()->route('systemUse')->with('success', 'Resistencia de sistema de protección eliminada correctamente');
    }
}
