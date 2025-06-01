<?php

namespace App\Http\Controllers;

use App\Models\ProtectionSystem;
use Illuminate\Http\Request;

class ProtectionSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('protectionSystem.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('protectionSystem.create');
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
            'nombre' => 'required'
        ]);

        ProtectionSystem::create($request->all());
        return redirect()->route('protectionSystem')->with('success', 'Sistema de protección creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $sistemas = ProtectionSystem::orderBy('id')
            ->select('id', 'nombre')
            ->get();

        $data = [];
        foreach ($sistemas as $sistema) {
            $data[] = [
                'id' => $sistema->id,
                'nombre' => $sistema->nombre
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
        $protectionSystem = ProtectionSystem::find($id);
        return view('protectionSystem.edit', compact('protectionSystem'));
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
            'nombre' => 'required'
        ]);

        ProtectionSystem::find($id)->update($request->all());
        return redirect()->route('protectionSystem')->with('success', 'Sistema de protección actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProtectionSystem::find($id)->delete();
        return redirect()->route('protectionSystem')->with('success', 'Sistema de protección eliminado correctamente');
    }
}
