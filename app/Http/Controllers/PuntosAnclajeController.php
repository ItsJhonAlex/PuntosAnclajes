<?php

namespace App\Http\Controllers;

use App\Exports\PrecintosExport;
use App\Models\Empresa;
use App\Models\ProtectionSystem;
use App\Models\PuntoAnclaje;
use App\Models\Recertification;
use App\Models\SystemUse;
use App\Models\Worker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PuntosAnclajeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        $totalRecords = PuntoAnclaje::count();
        $totalRecordswithFilter = PuntoAnclaje::where(function ($query) use ($searchValue) {
            $query->where('sistema_proteccion', 'like', '%' . $searchValue . '%')
                ->orWhere('propuesta_instalacion', 'like', '%' . $searchValue . '%')
                ->orWhere('precinto', 'like', '%' . $searchValue . '%')
                ->orWhere('serial', 'like', '%' . $searchValue . '%')
                ->orWhere('fecha_instalacion', 'like', '%' . $searchValue . '%')
                ->orWhere('fecha_inspeccion', 'like', '%' . $searchValue . '%')
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


        $puntosAnclaje = PuntoAnclaje::where(function ($query) use ($searchValue) {
            $query->where('sistema_proteccion', 'like', '%' . $searchValue . '%')
                ->orWhere('propuesta_instalacion', 'like', '%' . $searchValue . '%')
                ->orWhere('precinto', 'like', '%' . $searchValue . '%')
                ->orWhere('serial', 'like', '%' . $searchValue . '%')
                ->orWhere('fecha_instalacion', 'like', '%' . $searchValue . '%')
                ->orWhere('fecha_inspeccion', 'like', '%' . $searchValue . '%')
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
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($puntosAnclaje as $puntoAnclaje) {
            $data_arr[] = array(
                "id" => $puntoAnclaje->id,
                "precinto" => $puntoAnclaje->precinto,
                "serial" => $puntoAnclaje->serial,
                "marca" => $puntoAnclaje->marca,
                "fecha_instalacion" => $puntoAnclaje->fecha_instalacion,
                "fecha_inspeccion" => $puntoAnclaje->fecha_inspeccion,
                "fecha_proxima_inspeccion" => $puntoAnclaje->fecha_proxima_inspeccion,
                "numero_usuarios" => $puntoAnclaje->numero_usuarios,
                "uso" => $puntoAnclaje->uso,
                "observaciones" => $puntoAnclaje->observaciones,
                "ubicacion" => $puntoAnclaje->ubicacion,
                "instalador" => $puntoAnclaje->instalador,
                "estado" => $puntoAnclaje->estado,
                "resistencia" => $puntoAnclaje->resistencia,
                "persona_calificada" => $puntoAnclaje->persona_calificada,
                "empresa" => $puntoAnclaje->empresa->nombre,
                "sistema_proteccion" => $puntoAnclaje->sistema_proteccion,
                "created_at" => $puntoAnclaje->created_at,
                "updated_at" => $puntoAnclaje->updated_at,
                "propuesta_instalacion" => $puntoAnclaje->propuesta_instalacion,
            );
        }


        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresas = Empresa::all();
        $instaladores = Worker::all();
        $personaCalificada = Worker::all();
        $usos  = SystemUse::all();
        $sistemaProteccion = ProtectionSystem::all();

        return view('registrarPuntoAnclaje', compact('empresas', 'instaladores', 'usos', 'sistemaProteccion', 'personaCalificada'));
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

        $lastGroupId = PuntoAnclaje::max('range_group_number') + 1;
        $tmpGroupId  = $lastGroupId;

        //Recorro los rangos
        for($i=0; $i<count($precientoInicialLista);$i++){

            $precintosAconsultar = [];
            $precientoInicial    = ltrim($parejasRangos[$i]['inicio'], '0');
            $precientoFinal      = ltrim($parejasRangos[$i]['fin'], '0');

            for ($j = $precientoInicial; $j <= $precientoFinal; $j++) {
                $precintosAconsultar[] = sprintf("%06d", $j);
            }
            //realizar una consulta para ver si ya existe el precinto donde el where use $precintosAconsultar
            $precintosDuplicados = PuntoAnclaje::whereIn('precinto', $precintosAconsultar)->select('precinto')->get();

            if ($precintosDuplicados->count() > 0) {
                $listaPrecintosDuplicados []= $precintosDuplicados->pluck('precinto')->implode(', ');
                /*return redirect()->back()
                    ->withInput()  // Mantiene los datos del formulario
                    ->withErrors(['precinto' => "Error: Los siguientes precintos ya existen y no se pudieron registrar: {$listaPrecintosDuplicados}."]);*/
            }else{

                    for ($j = $precientoInicial; $j <= $precientoFinal; $j++) {
                        try {
                            PuntoAnclaje::create([
                                'sistema_proteccion' => $request->sistema_proteccion,
                                'id_empresa' => $request->id_empresa,
                                //'serial' => date('m') . '' . date('y') . '' . $request->precinto,
                                'serial' => date('m') . '' . date('y') . '' . $j,
                                'precinto' => sprintf("%06d", $j),
                                'fecha_instalacion' => $request->fecha_instalacion,
                                'fecha_inspeccion' => $request->fecha_inspeccion,
                                'fecha_proxima_inspeccion' => Carbon::parse($request->fecha_inspeccion)->addYear(),
                                'marca' => ($request->marca != 'OTRO') ? $request->marca : $request->marca_otro,
                                'numero_usuarios' => $request->numero_usuarios,
                                'uso' => $request->uso,
                                'observaciones' => $request->observaciones  != null ? $request->observaciones : 'NO APLICA',
                                'ubicacion' => $parejasRangos[$i]['ubicacion'],
                                'instalador' => $request->instalador,
                                'estado' => $request->estado,
                                'resistencia' => $request->resistencia,
                                'persona_calificada' => $request->persona_calificada,
                                'propuesta_instalacion' => $request->numero_propuesta,
                                'range_group_number'    => $tmpGroupId
                            ]);
                        } catch (\Illuminate\Database\QueryException $e) {
                            if ($e->errorInfo[1] == 1062) {
                                $precintoDuplicado = sprintf("%06d", $j);
                                $listaPrecintosDuplicados []= $precintoDuplicado;
                            }
                            throw $e;
                        }
                    }
                    $tmpGroupId++;

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
        \Session::put('$listaPrecintosDuplicadosSTR', $listaPrecintosDuplicadosSTR);

        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByReference(Request $request)
    {
        $message = "";
        $puntoAnclajeRequest = $request->puntoAnclaje;
        $showAlert = true;
        $puntoAnclaje = null;

        $recertificacion = Recertification::where('precinto', $puntoAnclajeRequest)
            ->with('empresa')
            ->with('sistemaProteccion')
            ->first();

        if ($recertificacion) {
            $proyectoPrincipal = PuntoAnclaje::where('propuesta_instalacion', $recertificacion->propuesta_principal)->first();
            $puntoAnclaje = $recertificacion;
            $puntoAnclaje->instalador = $proyectoPrincipal ? $proyectoPrincipal->instalador : 'SIN INFORMACIÓN';
            $puntoAnclaje->persona_calificada = $proyectoPrincipal ? $proyectoPrincipal->persona_calificada : 'SIN INFORMACIÓN';
            $puntoAnclaje->fecha_instalacion =  $proyectoPrincipal ? $proyectoPrincipal->fecha_instalacion : 'SIN INFORMACIÓN';
            $puntoAnclaje->fecha_inspeccion = $proyectoPrincipal ? $proyectoPrincipal->fecha_inspeccion : 'SIN INFORMACIÓN';
            $puntoAnclaje->fecha_proxima_inspeccion = $proyectoPrincipal ? $proyectoPrincipal->fecha_proxima_inspeccion : 'SIN INFORMACIÓN';
            $puntoAnclaje->sistema_proteccion = $proyectoPrincipal ? $recertificacion->sistemaProteccion->nombre : 'SIN INFORMACIÓN';
            $puntoAnclaje->propuesta_instalacion = $proyectoPrincipal ? $recertificacion->propuesta_principal : 'SIN INFORMACIÓN';
            $puntoAnclaje->propuesta_recertificacion = $proyectoPrincipal ? $recertificacion->propuesta_recertificacion : 'SIN INFORMACIÓN';
        }


        if (!$puntoAnclaje) {
            $puntoAnclaje = PuntoAnclaje::where('precinto', $puntoAnclajeRequest)->with('empresa')->first();
        }

        if ($puntoAnclajeRequest == null) {
            $showAlert = false;
        }

        if ($puntoAnclaje == null) {
            $message = "El punto de anclaje <span style='font-weight: bold;'>" . $puntoAnclajeRequest . "</span> aún no se encuentra registrado, por favor inicie sesión para registrarlo o comuníquese con el administrador para su registro !";
        }

        return view('welcome', compact('puntoAnclaje', 'showAlert', 'message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empresas = Empresa::all();
        $puntoAnclaje = PuntoAnclaje::where('id', $id)->first();
        $sistemaProteccion = ProtectionSystem::all();
        return view('editarPuntoAnclaje', compact('empresas', 'puntoAnclaje', 'sistemaProteccion'));
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

        $puntoAnclaje = PuntoAnclaje::where('id', $id)->first();

        $puntoAnclaje->sistema_proteccion = $request->sistema_proteccion;
        $puntoAnclaje->id_empresa = $request->id_empresa;
        $puntoAnclaje->precinto = $request->precinto;
        $puntoAnclaje->fecha_instalacion = $request->fecha_instalacion;
        $puntoAnclaje->fecha_inspeccion = $request->fecha_inspeccion;
        $puntoAnclaje->marca = ($request->marca != 'OTRO') ? $request->marca : $request->marca_otro;
        $puntoAnclaje->numero_usuarios = $request->numero_usuarios;
        $puntoAnclaje->uso = $request->uso;
        $puntoAnclaje->observaciones = $request->observaciones != null ? $request->observaciones : 'NO APLICA';
        $puntoAnclaje->ubicacion = $request->ubicacion;
        $puntoAnclaje->instalador = $request->instalador;
        $puntoAnclaje->estado = $request->estado;
        $puntoAnclaje->resistencia = $request->resistencia;
        $puntoAnclaje->persona_calificada = $request->persona_calificada;
        $puntoAnclaje->save();

        return redirect('/home');
    }

    public function delete()
    {
        return view('eliminarPuntoAnclaje');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'precinto_inicial' => 'required',
            'precinto_final' => '',
        ]);

        $precintoInicial = (int) $request->input('precinto_inicial');
        $precintoFinal = $request->input('precinto_final') ? (int) $request->input('precinto_final') : $precintoInicial;

        if ($precintoInicial > $precintoFinal) {
            $validator->errors()->add('precinto_final', 'El número de precinto inicial no puede ser mayor que el número de precinto final.');
        }

        if ($validator->errors()->isNotEmpty()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $i = $precintoInicial;

        do {
            $precintoFormatted = str_pad($i, 6, '0', STR_PAD_LEFT);
            PuntoAnclaje::where('precinto', $precintoFormatted)->delete();
            $i++;
        } while ($i <= $precintoFinal);

        session()->flash('success', 'Registro eliminados correctamente.');
        return redirect()->back();
    }

    public function registerCompany()
    {
        return view('registrarEmpresa');
    }

    public function insertCompany(Request $request)
    {
        Empresa::create([
            'nombre' => $request->empresa,
        ]);
        return redirect('/home');
    }

    public function export()
    {
        return Excel::download(new PrecintosExport, 'Precintos.xlsx');
    }

    public function getSystemProjects()
    {
        $systemProjects = $this->getDataSystemProposals();
        $dataTableSystemProjects = [];

        return view('recertification.index', compact('systemProjects', 'dataTableSystemProjects'));
    }

    public function getSystemProjectsByProposals(Request $request)
    {
        $systemProjects = $this->getDataSystemProposals();
        $systemProyects = $request->input('systemProyects');

        $anchorPonits = PuntoAnclaje::orderBy('id')
            ->groupBy('propuesta_instalacion')
            ->whereIn('propuesta_instalacion', $systemProyects)
            ->select('propuesta_instalacion', 'id_empresa', 'fecha_instalacion', DB::raw('count(id) as total'))
            ->with(['empresa' => function ($query) {
                $query->select('id', 'nombre'); // Selecciona solo el campo 'nombre' de la tabla 'empresa'
            }])
            ->get()
            ->toArray();

        $anchroPointsSystems = PuntoAnclaje::orderBy('id')
            ->select('sistema_proteccion', 'propuesta_instalacion', 'fecha_instalacion', DB::raw('count(id) as total'))
            ->groupBy('sistema_proteccion', 'propuesta_instalacion')
            ->whereIn('propuesta_instalacion', function ($query) use ($systemProyects) {
                $query->select('propuesta_instalacion')
                    ->from('isi_punto_anclaje_instalacion')
                    ->where(function ($subquery) use ($systemProyects) {
                        foreach ($systemProyects as $systemProyect) {
                            $subquery->orWhere('propuesta_instalacion', 'like', '%' . $systemProyect . '%');
                        }
                    });
            })
            ->get()
            ->toArray();

        $recertificationsPropouse = Recertification::orderBy('id')
            ->groupBy('propuesta_principal')
            ->groupBy('propuesta_recertificacion')
            ->whereIn('propuesta_principal', $systemProyects)
            ->select('propuesta_principal', 'propuesta_recertificacion', 'fecha_recertificacion')
            ->get()->toArray();

        $recirtificationPointsSystems = Recertification::orderBy('id')
            ->select('sistema_proteccion', 'propuesta_principal', DB::raw('DATE(fecha_recertificacion) as fecha_recertificacion'), 'propuesta_recertificacion', DB::raw('count(id) as total'))
            ->with('sistemaProteccion')
            ->groupBy('sistema_proteccion', 'propuesta_principal')
            ->whereIn('propuesta_principal', function ($query) use ($systemProyects) {
                $query->select('propuesta_principal')
                    ->from('isi_punto_anclaje_instalacion')
                    ->where(function ($subquery) use ($systemProyects) {
                        foreach ($systemProyects as $systemProyect) {
                            $subquery->orWhere('propuesta_principal', 'like', '%' . $systemProyect . '%');
                        }
                    });
            })
            ->get()
            ->toArray();

        // Organizar los datos en un nuevo array
        $dataTableSystemProjects = [];

        // Recorrer los resultados de anchorPonits
        foreach ($anchorPonits as $anchor) {
            // Obtener la propuesta_instalacion actual
            $propuestaInstalacion = $anchor['propuesta_instalacion'];

            // Filtrar recertificationsPropouse para la propuesta_instalacion actual
            $recertifications = array_filter($recertificationsPropouse, function ($recertification) use ($propuestaInstalacion) {
                return $recertification['propuesta_principal'] == $propuestaInstalacion;
            });

            // Obtener solo las propuesta_recertificacion de los resultados filtrados
            $recertificaciones = array_column($recertifications, 'propuesta_recertificacion');


            $protectionSystems = array_filter($anchroPointsSystems, function ($system) use ($propuestaInstalacion) {
                return $system['propuesta_instalacion'] == $propuestaInstalacion;
            });

            $recertificationSystems = array_filter($recirtificationPointsSystems, function ($system) use ($propuestaInstalacion) {
                return $system['propuesta_principal'] == $propuestaInstalacion;
            });

            // Agregar la propuesta_instalacion y sus recertificaciones al nuevo array con la estructura deseada
            $dataTableSystemProjects[] = [
                'propuesta_instalacion' => $propuestaInstalacion,
                'recertificaciones' => $recertificaciones,
                'empresa' => $anchor['empresa']['nombre'],
                'instalaciones' => $protectionSystems,
                'fecha_instalacion' => $anchor['fecha_instalacion'],
                'instalaciones_recertificacion' => $recertificationSystems
            ];
        }

        return view('recertification.index', compact('systemProjects', 'dataTableSystemProjects'));
    }

    private function getDataSystemProposals()
    {
        $systemProjects = PuntoAnclaje::orderBy('id')
            ->where('propuesta_instalacion', '!=', null)
            ->where('propuesta_instalacion', '!=', '')
            ->select('propuesta_instalacion')
            ->groupBy('propuesta_instalacion')
            ->get();

        return $systemProjects;
    }


    public function proposalNumberList(Request $request){
        $query = $request->get('query');
        $dataResponse = [];
        $rows = PuntoAnclaje::where('propuesta_instalacion','<>', "")->distinct('propuesta_instalacion')->get()->unique('propuesta_instalacion');
        foreach($rows as $row){
            if($query!="" && (strpos($row->propuesta_instalacion, $query) !== false)){
                $dataResponse[]=[
                    'value' => $row->propuesta_instalacion,
                    'data'  => $row->id
                ];
            }
        }
        return response()->json(['query'=> $query ,'suggestions'=>$dataResponse], 200);
    }


    public function updateProposalNumberList(Request $request){
        $responseArray = [ 'success' => false, 'errors'=>[], 'message'=>"", 'statusCode' => 200 ];
        $statusCode = 200;
        $query = $request->get('propuesta_instalacion_anterior');
        $UpdatedProposalNumber = $request->get('propuesta_instalacion_nuevo');
        $dataResponse = [];
        $count = PuntoAnclaje::where('propuesta_instalacion',$query)->get()->count();
        if($count>0){
            $updatedRows = PuntoAnclaje::where('propuesta_instalacion',$query)->update([
                    'propuesta_instalacion' => $UpdatedProposalNumber
            ]);
            if($updatedRows){
                $responseArray['success'] = true;
                $responseArray['message'] = "Se han actualizado los datos de ".$count. " filas!";
            }
        }else{
            $responseArray['message'] = "No existen registros para actualizar";
        }
        return response()->json($responseArray, $statusCode);
    }


}
