<?php

namespace App\Http\Controllers;

use App\Models\ProtectionSystem;
use App\Models\PuntoAnclaje;
use App\Models\Recertification;
use App\Models\SystemUse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($propouse)
    {
        $usos  = SystemUse::all();
        $sistemaProteccion = ProtectionSystem::all();

        $associatedAnclajes = PuntoAnclaje::where('propuesta_instalacion', $propouse)->get();
        $rangeNumbers = PuntoAnclaje::where('propuesta_instalacion', $propouse)->groupBy('range_group_number')->pluck('range_group_number')->toArray();
        $dataRanges  = [];
        $cantPrecintos = 0;
        foreach ($rangeNumbers as $rangeNumberTMP) {
            $dataRanges []= PuntoAnclaje::where('propuesta_instalacion', $propouse)->where('range_group_number', $rangeNumberTMP)->get();
            $cantPrecintos += PuntoAnclaje::where('propuesta_instalacion', $propouse)->where('range_group_number', $rangeNumberTMP)->get()->count();
        }


        return view('recertification.create', compact('propouse', 'usos', 'sistemaProteccion', 'dataRanges', 'cantPrecintos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $listaPrecintosDuplicados=[];
        $precientoInicialLista = $request->precinto_inicial;
        $precientoFinalLista = $request->precinto_final;
        $ubicacionLista = $request->ubicacion;

        $parejasRangos=[];
        for($i=0; $i<count($precientoInicialLista);$i++){
            $parejasRangos[]=[
                "inicio"        => $precientoInicialLista[$i],
                "fin"           => $precientoFinalLista[$i],
                "ubicacion"     => $ubicacionLista[$i]
            ];
        }

        //Recorro los rangos
        for($i=0; $i<count($precientoInicialLista);$i++){
            $precintosAconsultar = [];
            $precientoInicial    = ltrim($parejasRangos[$i]['inicio'], '0');
            $precientoFinal      = ltrim($parejasRangos[$i]['fin'], '0');

            for ($j = $precientoInicial; $j <= $precientoFinal; $j++) {
                $precintosAconsultar[] = sprintf("%06d", $j);
            }
            //realizar una consulta para ver si ya existe el precinto donde el where use $precintosAconsultar
            $precintosDuplicados = Recertification::whereIn('precinto', $precintosAconsultar)->select('precinto')->get();

            if ($precintosDuplicados->count() > 0) {
                $listaPrecintosDuplicados []= $precintosDuplicados->pluck('precinto')->implode(', ');
                /*return redirect()->back()
                    ->withInput()  // Mantiene los datos del formulario
                    ->withErrors(['precinto' => "Error: Los siguientes precintos ya existen y no se pudieron registrar: {$listaPrecintosDuplicados}."]);*/
            }else{
                    $propuestaPrincipal = PuntoAnclaje::where('propuesta_instalacion', $request->id_propuesta)->first();
                    for ($j = $precientoInicial; $j <= $precientoFinal; $j++) {
                        try {
                                Recertification::create([
                                    'sistema_proteccion' => $request->sistema_proteccion,
                                    'serial' => date('m') . '' . date('y') . '' . $j,
                                    'precinto' => sprintf("%06d", $j),
                                    'fecha_recertificacion' => $request->fecha_recertificacion,
                                    'marca' => ($request->marca != 'OTRO') ? $request->marca : $request->marca_otro,
                                    'numero_usuarios' => $request->numero_usuarios,
                                    'uso' => $request->uso,
                                    'observaciones' => $request->observaciones  != null ? $request->observaciones : 'NO APLICA',
                                    'ubicacion' => $parejasRangos[$i]['ubicacion'],
                                    'estado' => $request->estado,
                                    'propuesta_recertificacion' => $request->propuesta_recertificacion,
                                    'propuesta_principal' => $request->id_propuesta,
                                    'id_empresa' => $propuestaPrincipal->id_empresa
                                ]);
                        } catch (\Illuminate\Database\QueryException $e) {
                            if ($e->errorInfo[1] == 1062) {
                                $precintoDuplicado = sprintf("%06d", $j);
                                $listaPrecintosDuplicados []= $precintoDuplicado;
                            }
                            throw $e;
                        }
                    }
            }
        }

        $listaPrecintosDuplicadosSTR = "";
        for ($i=0; $i<count($listaPrecintosDuplicados); $i++){
            if($i>0){
                $listaPrecintosDuplicadosSTR= $listaPrecintosDuplicadosSTR.', '.$listaPrecintosDuplicados[$i];
            }else{
                $listaPrecintosDuplicadosSTR= $listaPrecintosDuplicadosSTR.''.$listaPrecintosDuplicados[$i];
            }
        }

        return redirect('/lista/recertificacion');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('recertification.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $recertification = Recertification::with('empresa')->findOrFail($id);
            $usos = SystemUse::all();
            $sistemaProteccion = ProtectionSystem::all();
            
            return view('recertification.edit', compact('recertification', 'usos', 'sistemaProteccion'));
        } catch (\Exception $e) {
            return redirect('/lista/recertificacion')->with('error', 'Recertificación no encontrada');
        }
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
        try {
            $request->validate([
                'propuesta_recertificacion' => 'required|string|max:255',
                'sistema_proteccion' => 'required|integer',
                'serial' => 'required|string|max:100',
                'precinto' => 'required|string|max:100',
                'fecha_recertificacion' => 'required|date',
                'marca' => 'required|string|max:100',
                'numero_usuarios' => 'required|integer|min:1|max:10',
                'uso' => 'required|string|max:100',
                'estado' => 'required|in:APROBADO,NO APROBADO',
                'ubicacion' => 'required|string|max:100',
                'observaciones' => 'nullable|string|max:500'
            ]);

            $recertification = Recertification::findOrFail($id);
            
            // Verificar si el precinto ya existe en otro registro
            $existingPrecinto = Recertification::where('precinto', $request->precinto)
                ->where('id', '!=', $id)
                ->first();
                
            if ($existingPrecinto) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['precinto' => 'El precinto ya existe en otro registro']);
            }

            $recertification->update([
                'propuesta_recertificacion' => $request->propuesta_recertificacion,
                'sistema_proteccion' => $request->sistema_proteccion,
                'serial' => $request->serial,
                'precinto' => $request->precinto,
                'fecha_recertificacion' => $request->fecha_recertificacion,
                'marca' => ($request->marca != 'OTRO') ? $request->marca : $request->marca_otro,
                'numero_usuarios' => $request->numero_usuarios,
                'uso' => $request->uso,
                'estado' => $request->estado,
                'ubicacion' => $request->ubicacion,
                'observaciones' => $request->observaciones ?? 'NO APLICA'
            ]);

            return redirect('/lista/recertificacion')->with('success', 'Recertificación actualizada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la recertificación: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $recertification = Recertification::findOrFail($id);
            $recertification->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Recertificación eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la recertificación: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getRecertifications(Request $request)
    {

        try {
            $draw = $request->get('draw');
            $start = $request->get('start');
            $rowperpage = $request->get("length");

            $columnIndex_arr = $request->get('order', []);
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');

            $columnIndex = $columnIndex_arr[0]['column'];
            $columnName = $columnName_arr[$columnIndex]['data'];
            $columnSortOrder = $order_arr[0]['dir'];
            $searchValue = $search_arr['value'];



            $totalRecords = Recertification::count();
            $totalRecordswithFilter = Recertification::where(function ($query) use ($searchValue) {
                $query->where('sistema_proteccion', 'like', '%' . $searchValue . '%')
                    ->orWhere('propuesta_principal', 'like', '%' . $searchValue . '%')
                    ->orWhere('propuesta_recertificacion', 'like', '%' . $searchValue . '%')
                    ->orWhere('precinto', 'like', '%' . $searchValue . '%')
                    ->orWhere('serial', 'like', '%' . $searchValue . '%')
                    ->orWhere('fecha_recertificacion', 'like', '%' . $searchValue . '%')
                    ->orWhere('marca', 'like', '%' . $searchValue . '%')
                    ->orWhere('numero_usuarios', 'like', '%' . $searchValue . '%')
                    ->orWhere('uso', 'like', '%' . $searchValue . '%')
                    ->orWhere('estado', 'like', '%' . $searchValue . '%')
                    ->orWhere('ubicacion', 'like', '%' . $searchValue . '%')
                    ->orWhere('observaciones', 'like', '%' . $searchValue . '%')
                    ->orWhere('id', 'like', '%' . $searchValue . '%');
            })
                ->orWhereHas('empresa', function ($query) use ($searchValue) {
                    $query->where('nombre', 'like', '%' . $searchValue . '%');
                })->count();


            $puntosAnclaje = Recertification::where(function ($query) use ($searchValue) {
                $query->where('sistema_proteccion', 'like', '%' . $searchValue . '%')
                    ->orWhere('propuesta_principal', 'like', '%' . $searchValue . '%')
                    ->orWhere('propuesta_recertificacion', 'like', '%' . $searchValue . '%')
                    ->orWhere('precinto', 'like', '%' . $searchValue . '%')
                    ->orWhere('serial', 'like', '%' . $searchValue . '%')
                    ->orWhere('fecha_recertificacion', 'like', '%' . $searchValue . '%')
                    ->orWhere('marca', 'like', '%' . $searchValue . '%')
                    ->orWhere('numero_usuarios', 'like', '%' . $searchValue . '%')
                    ->orWhere('uso', 'like', '%' . $searchValue . '%')
                    ->orWhere('estado', 'like', '%' . $searchValue . '%')
                    ->orWhere('ubicacion', 'like', '%' . $searchValue . '%')
                    ->orWhere('observaciones', 'like', '%' . $searchValue . '%')
                    ->orWhere('id', 'like', '%' . $searchValue . '%');
            })
                ->orWhereHas('empresa', function ($query) use ($searchValue) {
                    $query->where('nombre', 'like', '%' . $searchValue . '%');
                })
                ->orderBy($columnName, $columnSortOrder)
                ->with('empresa')
                ->skip($start)
                ->take($rowperpage)
                ->get();

            $data_arr = array();

            foreach ($puntosAnclaje as $puntoAnclaje) {
                
                $data_arr[] = array(
                    "sistema_proteccion" => $puntoAnclaje->sistema_proteccion,
                    "propuesta_principal" => $puntoAnclaje->propuesta_principal,
                    "propuesta_recertificacion" => $puntoAnclaje->propuesta_recertificacion,
                    "precinto" => $puntoAnclaje->precinto,
                    "serial" => $puntoAnclaje->serial,
                    "empresa" => $puntoAnclaje->empresa != null ? $puntoAnclaje->empresa->nombre : 'Empresa Eliminada',
                    "fecha_recertificacion" => $puntoAnclaje->fecha_recertificacion,
                    "marca" => $puntoAnclaje->marca,
                    "numero_usuarios" => $puntoAnclaje->numero_usuarios,
                    "uso" => $puntoAnclaje->uso,
                    "estado" => $puntoAnclaje->estado,
                    "ubicacion" => $puntoAnclaje->ubicacion,
                    "observaciones" => $puntoAnclaje->observaciones,
                    "id" => $puntoAnclaje->id,

                );
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr
            );

            return response($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
