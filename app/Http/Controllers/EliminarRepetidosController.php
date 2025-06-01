<?php

namespace App\Http\Controllers;

use App\Exports\NotDeletedRecordsExport;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class EliminarRepetidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deletedRecordsPath = 'processed_records.json';

        // Leer los archivos JSON
        $deletedRecords = json_decode(Storage::get($deletedRecordsPath), true);


        // Paginación para registros eliminados
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10; // Número de registros por página
        $currentPageRecords = array_slice($deletedRecords, ($currentPage - 1) * $perPage, $perPage);
        $deletedRecordsPaginator = new LengthAwarePaginator(
            $currentPageRecords,
            count($deletedRecords),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        // Pasar los datos a la vista
        return view('registrosAEliminar', [
            'deletedRecords' => $deletedRecordsPaginator,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy() {
      $deletedinstallations = $this->deleteInstalationDuplicates();
      $deleteRecertifications = $this->deleteRecertification();

      return response()->json([
          'message' => 'Proceso completado',
          'deletedinstallations' => $deletedinstallations,
          'deletereinstallations' => $deleteRecertifications,
      ]);
    }

    public function exportToExcel(Request $request)
    {
        // Leer el JSON con los registros no eliminados
        $notDeletedRecords = json_decode(file_get_contents(storage_path('app/processed_records.json')), true);

        // Generar el archivo Excel
        return Excel::download(new NotDeletedRecordsExport($notDeletedRecords), 'processed_records_installation.xlsx');
    }

    public function exportToExcelRecertification(Request $request)
    {
        // Leer el JSON con los registros no eliminados
        $notDeletedRecords = json_decode(file_get_contents(storage_path('app/processed_records_recertification.json')), true);

        // Generar el archivo Excel
        return Excel::download(new NotDeletedRecordsExport($notDeletedRecords), 'processed_records_recertification.xlsx');
    }

    private function deleteInstalationDuplicates()
    {
        $duplicatedPrecintos = DB::table('isi_punto_anclaje_instalacion')
            ->select('precinto', DB::raw('COUNT(*) as total'))
            ->groupBy('precinto')
            ->having('total', '>', 1)
            ->pluck('precinto');

        // Lista para almacenar los registros procesados (eliminados y no eliminados)
        $processedRecords = [];

        // Paso 2: Procesar los registros duplicados
        DB::transaction(function () use ($duplicatedPrecintos, &$processedRecords) {
            foreach ($duplicatedPrecintos as $precinto) {
                // Obtener todos los registros con el mismo `precinto`
                $records = DB::table('isi_punto_anclaje_instalacion')
                    ->leftJoin('isi_empresas', 'isi_punto_anclaje_instalacion.id_empresa', '=', 'isi_empresas.id')
                    ->where('isi_punto_anclaje_instalacion.precinto', $precinto)
                    ->orderBy('isi_punto_anclaje_instalacion.id')
                    ->select(
                        'isi_punto_anclaje_instalacion.*',
                        DB::raw('IFNULL(isi_empresas.nombre, "sin_empresa") as nombre_empresa')
                    )
                    ->get();

                foreach ($records as $record) {
                    $differences = [];

                    // Añadir la entrada con los detalles
                    $processedRecords[] = [
                        'id' => $record->id,
                        'precinto' => $record->precinto,
                        'empresa' => $record->nombre_empresa
                    ];

                    // Eliminar cada registro duplicado
                    DB::table('isi_punto_anclaje_instalacion')
                        ->where('id', $record->id)
                        ->delete();
                }
            }
        });

        // Paso 3: Guardar la lista en un archivo JSON
        $processedRecordsPath = 'processed_records.json';
        Storage::put($processedRecordsPath, json_encode($processedRecords, JSON_PRETTY_PRINT));

        // Paso 4: Devolver la respuesta JSON con la ruta del archivo
        return $processedRecordsPath;
    }

    private function deleteRecertification(){
        $duplicatedPrecintos = DB::table('isi_puntos_anclaje_recertificacion')
            ->select('precinto', DB::raw('COUNT(*) as total'))
            ->groupBy('precinto')
            ->having('total', '>', 1)
            ->pluck('precinto');


            // Lista para almacenar los registros procesados (eliminados y no eliminados)
            $processedRecords = [];

            // Paso 2: Procesar los registros duplicados
            DB::transaction(function () use ($duplicatedPrecintos, &$processedRecords) {
                foreach ($duplicatedPrecintos as $precinto) {
                    // Obtener todos los registros con el mismo `precinto`
                    $records = DB::table('isi_puntos_anclaje_recertificacion')
                        ->leftJoin('isi_empresas', 'isi_puntos_anclaje_recertificacion.id_empresa', '=', 'isi_empresas.id')
                        ->where('isi_puntos_anclaje_recertificacion.precinto', $precinto)
                        ->orderBy('isi_puntos_anclaje_recertificacion.id')
                        ->select(
                            'isi_puntos_anclaje_recertificacion.*',
                            DB::raw('IFNULL(isi_empresas.nombre, "sin_empresa") as nombre_empresa')
                        )
                        ->get();

                    foreach ($records as $record) {
                        $differences = [];

                        // Añadir la entrada con los detalles
                        $processedRecords[] = [
                            'id' => $record->id,
                            'precinto' => $record->precinto,
                            'empresa' => $record->id . ' - ' . $record->nombre_empresa
                        ];

                        // Eliminar cada registro duplicado
                        DB::table('isi_puntos_anclaje_recertificacion')
                            ->where('id', $record->id)
                            ->delete();
                    }
                }
            });

            // Paso 3: Guardar la lista en un archivo JSON
            $processedRecordsPath = 'processed_records_recertification.json';
            Storage::put($processedRecordsPath, json_encode($processedRecords, JSON_PRETTY_PRINT));

            // Paso 4: Devolver la respuesta JSON con la ruta del archivo
            return  $processedRecordsPath;
            
    }
}
