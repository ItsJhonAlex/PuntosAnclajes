<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\PuntosAnclajeController::class, 'showByReference'])->name('welcome');

Auth::routes();



// Route::get('/puntoAnclaje/{precinto}', [App\Http\Controllers\PuntosAnclajeController::class, 'show']);
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/registrarPuntoAnclaje', [App\Http\Controllers\PuntosAnclajeController::class, 'create']);
    Route::get('/obtenerPuntosDeAnclaje', [App\Http\Controllers\PuntosAnclajeController::class, 'index']);
    Route::post('/insertarPuntoAnclaje', [App\Http\Controllers\PuntosAnclajeController::class, 'store'])->name('insertarPuntoAnclaje');
    Route::get('/editarPuntoAnclaje/{id}', [App\Http\Controllers\PuntosAnclajeController::class, 'edit'])->name('editarEmpresa');
    Route::put('/actualizarPuntoAnclaje/{id}', [App\Http\Controllers\PuntosAnclajeController::class, 'update'])->name('actualizarPuntoAnclaje');
    Route::get('/registrarEmpresa', [App\Http\Controllers\PuntosAnclajeController::class, 'registerCompany']);
    Route::post('/insertarEmpresa', [App\Http\Controllers\PuntosAnclajeController::class, 'insertCompany'])->name('insertarEmpresa');
    Route::get('/exportar', [App\Http\Controllers\PuntosAnclajeController::class, 'export']);
    Route::get('/eliminarPuntosAnclaje', [App\Http\Controllers\PuntosAnclajeController::class, 'delete'])->name('eliminarPuntosAnclaje');
    Route::post('/eliminarSistemas', [App\Http\Controllers\PuntosAnclajeController::class, 'destroy'])->name('eliminarSistemas');
    Route::post('/ajax/numeros_propuesta/', [App\Http\Controllers\PuntosAnclajeController::class, 'proposalNumberList'])->name('ListanumerosPropuesta');//Added by adonis
    Route::post('/ajax/update_numeros_propuesta/', [App\Http\Controllers\PuntosAnclajeController::class, 'updateProposalNumberList'])->name('ActualizarPropuesta');//Added by adonis


    Route::get('/company', [App\Http\Controllers\EmpresaController::class, 'index'])->name('company');
    Route::get('/company/table', [App\Http\Controllers\EmpresaController::class, 'show']);
    Route::get('/company/create', [App\Http\Controllers\EmpresaController::class, 'create']);
    Route::post('/company/store', [App\Http\Controllers\EmpresaController::class, 'store'])->name('company.store');
    Route::get('/company/edit/{id}', [App\Http\Controllers\EmpresaController::class, 'edit']);
    Route::put('/company/update/{id}', [App\Http\Controllers\EmpresaController::class, 'update'])->name('company.update');
    Route::get('/company/delete/{id}', [App\Http\Controllers\EmpresaController::class, 'delete']);

    Route::get('/worker', [App\Http\Controllers\WorkerController::class, 'index'])->name('worker');
    Route::get('/worker/table', [App\Http\Controllers\WorkerController::class, 'show']);
    Route::get('/worker/create', [App\Http\Controllers\WorkerController::class, 'create']);
    Route::post('/worker/store', [App\Http\Controllers\WorkerController::class, 'store'])->name('worker.store');
    Route::get('/worker/edit/{id}', [App\Http\Controllers\WorkerController::class, 'edit']);
    Route::put('/worker/update/{id}', [App\Http\Controllers\WorkerController::class, 'update'])->name('worker.update');
    Route::get('/worker/delete/{id}', [App\Http\Controllers\WorkerController::class, 'destroy']);

    Route::get('/protectionSystem', [App\Http\Controllers\ProtectionSystemController::class, 'index'])->name('protectionSystem');
    Route::get('/protectionSystem/table', [App\Http\Controllers\ProtectionSystemController::class, 'show']);
    Route::get('/protectionSystem/create', [App\Http\Controllers\ProtectionSystemController::class, 'create']);
    Route::post('/protectionSystem/store', [App\Http\Controllers\ProtectionSystemController::class, 'store'])->name('protectionSystem.store');
    Route::get('/protectionSystem/edit/{id}', [App\Http\Controllers\ProtectionSystemController::class, 'edit']);
    Route::put('/protectionSystem/update/{id}', [App\Http\Controllers\ProtectionSystemController::class, 'update'])->name('protectionSystem.update');
    Route::get('/protectionSystem/delete/{id}', [App\Http\Controllers\ProtectionSystemController::class, 'destroy']);
    
    Route::get('/systemUse', [App\Http\Controllers\SystemUseController::class, 'index'])->name('systemUse');
    Route::get('/systemUse/table', [App\Http\Controllers\SystemUseController::class, 'show']);
    Route::get('/systemUse/create', [App\Http\Controllers\SystemUseController::class, 'create']);
    Route::post('/systemUse/store', [App\Http\Controllers\SystemUseController::class, 'store'])->name('systemUse.store');
    Route::get('/systemUse/edit/{id}', [App\Http\Controllers\SystemUseController::class, 'edit']);
    Route::put('/systemUse/update/{id}', [App\Http\Controllers\SystemUseController::class, 'update'])->name('systemUse.update');
    Route::get('/systemUse/delete/{id}', [App\Http\Controllers\SystemUseController::class, 'destroy']);

    Route::get('/systemProject', [App\Http\Controllers\PuntosAnclajeController::class, 'getSystemProjects']);
    Route::get('/SystemProject/data', [App\Http\Controllers\PuntosAnclajeController::class, 'getSystemProjectsByProposals'])->name('system-project-data');
    Route::get('/recertification/{propouse}', [App\Http\Controllers\RecertificationController::class, 'create'])->name('recertification.create');
    Route::post('/recertification/store', [App\Http\Controllers\RecertificationController::class, 'store'])->name('recertification.store');
    Route::get('/lista/recertificacion', [App\Http\Controllers\RecertificationController::class, 'show']);
    Route::get('/lista/recertificaciones', [App\Http\Controllers\RecertificationController::class, 'getRecertifications']);
    Route::get('/recertification/edit/{id}', [App\Http\Controllers\RecertificationController::class, 'edit'])->name('recertification.edit');
    Route::put('/recertification/update/{id}', [App\Http\Controllers\RecertificationController::class, 'update'])->name('recertification.update');
    Route::delete('/recertification/destroy/{id}', [App\Http\Controllers\RecertificationController::class, 'destroy'])->name('recertification.destroy');
});


Route::get('/eliminar/duplicados/', [App\Http\Controllers\EliminarRepetidosController::class, 'destroy'])->middleware('auth');
Route::get('/registros/eliminar', [App\Http\Controllers\EliminarRepetidosController::class, 'index'])->middleware('auth');
Route::post('/registros/eliminar', [App\Http\Controllers\EliminarRepetidosController::class, 'eliminarPorCriterios'])->name('eliminar.registros');
Route::get('/export-to-excel', [App\Http\Controllers\EliminarRepetidosController::class, 'exportToExcel'])->name('exportToExcel');
Route::get('/export-to-excel-recertification', [App\Http\Controllers\EliminarRepetidosController::class, 'exportToExcelRecertification'])->name('exportToExcelRecertification');
