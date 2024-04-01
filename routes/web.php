<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HousekeeperController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user-access:1'])->group(function (){
    Route::get('/Admin/Dashboard', [AdminController::class, 'adminHome'])->name('admin.home');
    //Lodge
    Route::get('/Admin/Lodge-Areas', [AdminController::class, 'ViewLodge'])->name('admin.lodges');
    Route::get('/Admin/Add-Lodge-Areas', [AdminController::class, 'AddLodge'])->name('admin.add-lodge');
    Route::get('Admin/Edit-Lodge-Area/{edit}', [AdminController::class, 'EditLodge'])->name('admin.edit-lodge');
    Route::post('/Admin/Add-Lodge-Area', [AdminController::class, 'StoreLodge'])->name('store-lodge');
    Route::put('/Admin/Edit-Lodge-Area/{id}', [AdminController::class, 'UpdateLodge'])->name('admin.update-lodge');
    Route::delete('/Admin/Delete-Lodge-Area/{id}', [AdminController::class, 'DeleteLodge'])->name('admin.delete-lodge');
    //Employee
    Route::get('/Admin/Employee', [AdminController::class, 'ViewEmployee'])->name('admin.employee');
    Route::get('/Admin/Employee-Lodge', [AdminController::class, 'LodgeEmployee'])->name('admin.lodge-employees');
    Route::get('/Admin/Employee-Search', [AdminController::class, 'SearchEmployee'])->name('admin.search-employee');
    Route::get('/Admin/Employee-Position', [AdminController::class, 'PositionEmployee'])->name('admin.position-employees');
    Route::get('/Admin/Employee-Filtered', [AdminController::class, 'FilterEmployee'])->name('admin.filter.employees');
    Route::get('Admin/Add-Employees', [AdminController::class, 'AddEmployee'])->name('admin.add-employees');
    Route::get('/Admin/Edit-Employee/{edit}', [AdminController::class, 'EditEmployee'])->name('admin.edit-employee');
    Route::post('/Admin/Add-Employee', [AdminController::class, 'StoreEmployee'])->name('admin.store-employee');
    Route::put('/Admin/Edit-Employee/{edit}', [AdminController::class, 'UpdateEmployee'])->name('admin.update-employee');
    Route::delete('Admin/Delete-Employee/{id}', [AdminController::class, 'DeleteEmployee'])->name('admin.delete-employee');
    //Rooms
    Route::get('/Admin/Rooms', [AdminController::class, 'ViewRoom'])->name('admin.room');
    Route::get('/Admin/Add-Rooms', [AdminController::class, 'AddRoom'])->name('admin.add-room');
    Route::get('/Admin/Add-Amenity', [AdminController::class, 'AddAmenity'])->name('admin.add-amenity');
    Route::get('/Admin/Edit-Room/{id}', [AdminController::class, 'EditRoom'])->name('admin.edit-room');
    Route::get('/Admin/Rooms-Filtered', [AdminController::class, 'filterRooms'])->name('admin.filter-room');
    Route::get('/Admin/{room_id}/Room-Details', [AdminController::class, 'DetailsRoom'])->name('admin.details-room');
    Route::get('/cleaning-history/{room_id}', [AdminController::class, 'CleanHistory']);
    Route::get('/cleaning-history/{room_id}/search', [AdminController::class, 'searchCleaningHistory']);
    Route::post('/Admin/Add-Room', [AdminController::class, 'StoreRoom'])->name('admin.store-room');
    Route::post('/Admin/Add-Amenity', [AdminController::class, 'StoreAmenity'])->name('admin.store-amenity');
    Route::put('/Admin/Update-Room-Status/{roomId}', [AdminController::class, 'UpdateStatus'])->name('admin.update-status');
    Route::put('/Admin/Update-Room/{id}', [AdminController::class, 'UpdateRoom'])->name('admin.update-room');
    Route::delete('/Admin/Delete-Room/{id}', [AdminController::class, 'DeleteRoom'])->name('admin.delete-room');
    //Calendar
    Route::get('/Admin/Calendar', [AdminController::class, 'calendar'])->name('admin.calendar');
    Route::post('/Admin/Add-Event', [AdminController::class, 'StoreEvent'])->name('admin.store-event');
    //Analytics
    Route::get('/Admin/Analytics', [AdminController::class, 'Analytics'])->name('admin.analytics');
    Route::get('/generate-report', [AdminController::class, 'generateReport'])->name('generate.pdf');
});

Route::middleware(['auth', 'user-access:2'])->group(function() {
    Route::get('/Front-Desk/Dashboard', [HomeController::class, 'frontdeskHome'])->name('front-desk.home');
});

Route::middleware(['auth', 'user-access:3'])->group(function() {
    Route::get('/Housekeeper/Dashboard', [HousekeeperController::class, 'housekeeperHome'])->name('housekeeper.home');
    Route::get('/Housekeeper/Rooms', [HousekeeperController::class, 'Rooms'])->name('housekeeper.rooms');
    Route::put('/housekeeper/update-room/{roomId}', [HousekeeperController::class, 'updateRoomStatusAndAmenities'])->name('housekeeper.update-room');
});
