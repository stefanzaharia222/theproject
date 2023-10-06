<?php

use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AutomationsController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\ProfilesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [SuperAdminController::class, 'index']);
    Route::get('/get-modal-content', [\App\Http\Controllers\ModalController::class, 'getModalContent']);
    Route::get('/update-modal-content', [\App\Http\Controllers\ModalController::class, 'updateRecord'])->name('updateRecord');
    Route::get('/fields', [FieldController::class, 'fieldsList'])->name('fields');
    Route::get('/users', [UserController::class, 'usersList'])->name('users');
    Route::get("/tickets", [TicketController::class, 'ticketList'])->name('tickets');
    Route::get("/tasks", [TaskController::class, 'tasksList'])->name('tasks');
    Route::get("/status", [StatusController::class, 'statusList'])->name('status');
    Route::get("/process", [ProcessController::class, 'processList'])->name('process');
    Route::get("/automations", [AutomationsController::class, 'automationsList'])->name('automations');
    Route::get("/groups", [GroupsController::class, 'groupsList'])->name('groups');
    Route::get("/roles", [AssignmentsController::class, 'rolesList'])->name('roles');
    Route::get("/profiles", [ProfilesController::class, 'list'])->name('profiles');

    // That Route will trash or restore bulk selected items
    Route::post("/bulk/form", [FormController::class, 'formProcess'])->name('form_bulk_action');

    Route::middleware('superAdminAccess')->group(function () {
        Route::get('/entities', [SuperAdminController::class, 'entitiesList'])->name('entities');
        Route::get('/entities-select', [SuperAdminController::class, 'entitiesJson'])->name('entity_select');
    });
    Route::prefix('profile')->group(function () {
        Route::get('/{user}', [ProfileController::class, 'index'])->name('admin.profile.index');
        Route::get('/{user}/update-profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('/{user}/upload-image', [ProfileController::class, 'storeImage'])->name('admin.profile.upload-image');
        Route::post('/{user}/store', [ProfileController::class, 'store'])->name('admin.profile.store');
    });
    Route::get('/lang/json', function () {
        $filePath = resource_path('lang/'.app()->getLocale().'.json');

        if (File::exists($filePath)) {
            $jsonContent = File::get($filePath);
            $data = json_decode($jsonContent, true);

            return response()->json($data);
        }

        return response()->json(['error' => 'Language file not found'], 404);
    });
});

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('set-locale');