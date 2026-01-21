<?php

use App\Http\Controllers\Admin\CarBrandController;
use App\Http\Controllers\Admin\CarModelController;
use App\Http\Controllers\Admin\DetectionReportController;
use App\Models\Admin\CarBrand;
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

Route::any('/clear-cache', function () {
    \Artisan::call('optimize:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('route:clear');
    \Artisan::call('config:clear');
    \Artisan::call('config:cache');
    \Artisan::call('view:clear');
    // return "All Cache is cleared";
    // $pageInfo = PageSettingInfo::getHomeBanner('/index');
    // return view('index', ['pageInfo' => $pageInfo]);
    return redirect()->route('home');
});

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
Route::any('register', function() {
    return redirect('/');
});

Route::prefix('admin')->group(function () {
    Route::middleware(['auth'])->group(function() {
        Route::resource('authorizeStatuses', App\Http\Controllers\Admin\AuthorizeStatusController::class, ["as" => 'admin']);
        Route::resource('regulations', App\Http\Controllers\Admin\RegulationsController::class, ["as" => 'admin']);
        Route::resource('reporters', App\Http\Controllers\Admin\ReporterController::class, ["as" => 'admin']);
        Route::resource('carBrands', App\Http\Controllers\Admin\CarBrandController::class, ["as" => 'admin']);
        Route::resource('carModels', App\Http\Controllers\Admin\CarModelController::class, ["as" => 'admin']);
        Route::resource('inspectionInstitutions', App\Http\Controllers\Admin\InspectionInstitutionController::class, ["as" => 'admin']);
        Route::resource('companyInfos', App\Http\Controllers\Admin\CompanyInfoController::class, ["as" => 'admin']);
        Route::resource('deliveryRecords', App\Http\Controllers\Admin\DeliveryRecordController::class, ["as" => 'admin']);
        Route::resource('agreeAuthorizeRecords', App\Http\Controllers\Admin\AgreeAuthorizeRecordsController::class, ["as" => 'admin']);
        Route::resource('cumulativeAuthorizedUsageRecords', App\Http\Controllers\Admin\CumulativeAuthorizedUsageRecordsController::class, ["as" => 'admin']);
        Route::resource('exportAuthorizeRecords', App\Http\Controllers\Admin\ExportAuthorizeRecordsController::class, ["as" => 'admin']);
        Route::resource('affidavitRecords', App\Http\Controllers\Admin\AffidavitRecordController::class, ["as" => 'admin']);
        Route::resource('postponeRecords', App\Http\Controllers\Admin\PostponeRecordController::class, ["as" => 'admin']);
        Route::resource('carPatterns', App\Http\Controllers\Admin\CarPatternController::class, ["as" => 'admin']);
        Route::resource('carFuelCategories', App\Http\Controllers\Admin\CarFuelCategoryController::class, ["as" => 'admin']);

        Route::any('detectionReports', [DetectionReportController::class, 'index'])->name('admin.detectionReports.index');
        Route::any('detectionReports/create', [DetectionReportController::class, 'create'])->name('admin.detectionReports.create');
        Route::any('detectionReports/store', [DetectionReportController::class, 'store'])->name('admin.detectionReports.store');
        Route::any('detectionReports/destroy/{id}', [DetectionReportController::class, 'destroy'])->name('admin.detectionReports.destroy');
        Route::any('detectionReports/update/{id}', [DetectionReportController::class, 'update'])->name('admin.detectionReports.update');
        Route::any('detectionReports/edit/{id}', [DetectionReportController::class, 'edit'])->name('admin.detectionReports.edit');
        Route::any('detectionReports/reply-modify', [DetectionReportController::class, 'modifyReply'])->name('admin.detectionReports.reply-modify');

        Route::any('deliveryRecordsDownloadPdf', [App\Http\Controllers\Admin\DeliveryRecordController::class, 'convertToPdfWithContract_s1'])->name('admin.deliveryRecords.downloadPdf');
    });
});

Route::any('getBrands', [CarBrandController::class, 'getBrands'])->name('getBrands');
Route::any('get-models-by-brand', [CarModelController::class, 'getModelsByBrand'])->name('getModelsByBrand');
Route::any('get-status-by-letter', [DetectionReportController::class, 'getStatusByLetter'])->name('getStatusByLetter');
Route::any('exportDocument', [DetectionReportController::class, 'exportDocument'])->name('exportDocument');
Route::any('showReportModal', [DetectionReportController::class, 'showReportModal'])->name('showReportModal');
Route::any('getReportsByRegs', [DetectionReportController::class, 'getReportsByRegs'])->name('getReportsByRegs');
Route::any('getRegs', [DetectionReportController::class, 'getRegs'])->name('getRegs');
Route::any('getReportsData', [DetectionReportController::class, 'getReportsData'])->name('getReportsData');
Route::any('getReportByNum', [DetectionReportController::class, 'getReportByNum'])->name('getReportByNum');
Route::get('getNextSerialNumber', [DetectionReportController::class, 'getNextSerialNumber'])->name('getNextSerialNumber');
// Route::any('exportExcelTest', [DetectionReportController::class, 'exportExcelTest'])->name('exportExcelTest');
// Route::any('convertToPdf', [DetectionReportController::class, 'convertToPdf'])->name('convertToPdf');

Route::any('importReport', [DetectionReportController::class, 'importReport'])->name('importReport');
Route::any('/save-draft', [DetectionReportController::class, 'saveDraft'])->name('saveDraft');
Route::any('exportDetectionReports', [DetectionReportController::class, 'exportDetectionReports'])->name('exportDetectionReports');
Route::any('/letter-modify', [DetectionReportController::class, 'modifyLetterId'])->name('modifyLetter');
