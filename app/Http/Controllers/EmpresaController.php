<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    public function index()
    {
        return view('company.index');
    }

    public function show()
    {
        $empresas = Empresa::orderBy('id')
            ->select('id', 'nombre', 'sede', 'ciudad', 'nit', 'nombre_contacto_empresa', 'telefono_contacto_empresa', 'email_contacto_empresa', 'nombre_contacto_empresa_2', 'telefono_contacto_empresa_2', 'email_contacto_empresa_2')
            ->get();

        $data = [];
        foreach ($empresas as $empresa) {
            $data[] = [
                'id' => $empresa->id,
                'nombre' => $empresa->nombre,
                'sede' => $empresa->sede,
                'ciudad' => $empresa->ciudad,
                'nit' => $empresa->nit,
                'nombre_contacto_empresa' => $empresa->nombre_contacto_empresa,
                'telefono_contacto_empresa' => $empresa->telefono_contacto_empresa,
                'email_contacto_empresa' => $empresa->email_contacto_empresa,
                'nombre_contacto_empresa_2' => $empresa->nombre_contacto_empresa_2,
                'telefono_contacto_empresa_2' => $empresa->telefono_contacto_empresa_2,
                'email_contacto_empresa_2' => $empresa->email_contacto_empresa_2,
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function create()
    {
        return view('company.create');
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'sede' => 'required',
            'ciudad' => 'required',
            'nit' => 'required',
            'nombre_contacto_empresa' => 'required',
            'telefono_contacto_empresa' => 'required',
            'email_contacto_empresa' => 'required|email',
            'nombre_contacto_empresa_2' => '',
            'telefono_contacto_empresa_2' => '',
            'email_contacto_empresa_2' => '',
        ]);

        if ($validator->fails()) {
            return redirect()->route('company')
                        ->withErrors($validator)
                        ->withInput();
        }

        Empresa::create([
            'nombre' => $request['nombre'],
            'sede' => $request['sede'],
            'ciudad' => $request['ciudad'],
            'nit' => $request['nit'],
            'nombre_contacto_empresa' => $request['nombre_contacto_empresa'],
            'telefono_contacto_empresa' => $request['telefono_contacto_empresa'],
            'email_contacto_empresa' => $request['email_contacto_empresa'],
            'nombre_contacto_empresa_2' => $request['nombre_contacto_empresa_2'],
            'telefono_contacto_empresa_2' => $request['telefono_contacto_empresa_2'],
            'email_contacto_empresa_2' => $request['email_contacto_empresa_2'],
        ]);

        return redirect()->route('company')->with('success', 'Empresa registrada correctamente');
    }

    public function edit($id)
    {
        $empresa = Empresa::find($id);
        return view('company.edit', compact('empresa'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'sede' => 'required',
            'ciudad' => 'required',
            'nit' => 'required',
            'nombre_contacto_empresa' => 'required',
            'telefono_contacto_empresa' => 'required',
            'email_contacto_empresa' => 'required|email',
            'nombre_contacto_empresa_2' => '',
            'telefono_contacto_empresa_2' => '',
            'email_contacto_empresa_2' => '',
        ]);

        $empresa = Empresa::find($request->id);
        $empresa->nombre = $request->nombre;
        $empresa->sede = $request->sede;
        $empresa->ciudad = $request->ciudad;
        $empresa->nit = $request->nit;
        $empresa->nombre_contacto_empresa = $request->nombre_contacto_empresa;
        $empresa->telefono_contacto_empresa = $request->telefono_contacto_empresa;
        $empresa->email_contacto_empresa = $request->email_contacto_empresa;
        $empresa->nombre_contacto_empresa_2 = $request->nombre_contacto_empresa_2;
        $empresa->telefono_contacto_empresa_2 = $request->telefono_contacto_empresa_2;
        $empresa->email_contacto_empresa_2 = $request->email_contacto_empresa_2;
        $empresa->save();

        return redirect()->route('company')->with('success', 'Empresa actualizada correctamente');
    }

    public function delete($id)
    {
        $empresa = Empresa::find($id);
        $empresa->delete();
        return redirect()->route('company')->with('success', 'Empresa eliminada correctamente');
    }
}
