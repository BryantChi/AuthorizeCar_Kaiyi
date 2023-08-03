<?php

use App\Http\Controllers\Admin\CarModelController;
use App\Http\Controllers\Admin\DetectionReportController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');

// 強制禁止Register
// Route::any('register', function() {
//     return redirect('/');
// });

Route::prefix('admin')->group(function () {
    Route::middleware(['auth'])->group(function() {
        Route::resource('authorizeStatuses', App\Http\Controllers\Admin\AuthorizeStatusController::class, ["as" => 'admin']);
        Route::resource('regulations', App\Http\Controllers\Admin\RegulationsController::class, ["as" => 'admin']);
        Route::resource('reporters', App\Http\Controllers\Admin\ReporterController::class, ["as" => 'admin']);
        Route::resource('carBrands', App\Http\Controllers\Admin\CarBrandController::class, ["as" => 'admin']);
        Route::resource('carModels', App\Http\Controllers\Admin\CarModelController::class, ["as" => 'admin']);

        Route::any('detectionReports', [DetectionReportController::class, 'index'])->name('admin.detectionReports.index');
        Route::any('detectionReports/create', [DetectionReportController::class, 'create'])->name('admin.detectionReports.create');
        Route::any('detectionReports/store', [DetectionReportController::class, 'store'])->name('admin.detectionReports.store');
    });
});

Route::any('get-models-by-brand', [CarModelController::class, 'getModelsByBrand'])->name('getModelsByBrand');

