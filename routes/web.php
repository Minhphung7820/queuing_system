<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\GiveNumber;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ManageUsersController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Models\Services;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect("/admin/");
})->middleware('prevent-back-history');
Route::get('/my-account', [UserController::class, "myAccount"])->middleware('login', 'prevent-back-history');
Route::post('/change-avt',[UserController::class,"changeAvatar"]);
Route::post('/view-chart', [IndexController::class, "viewChart"]);
Route::get('/error', [IndexController::class, "NonFunction"]);
Route::get("/dang-xuat", [UserController::class, "logout"]);
Route::post("/dang-xuat", [UserController::class, "_logout"]);
Route::middleware('if-logined', 'prevent-back-history')->group(function () {
    Route::get("/dang-nhap", [UserController::class, "login"]);
    Route::post("/dang-nhap", [UserController::class, "_login"]);
    Route::get("/quen-mat-khau", [UserController::class, "forgot"]);
    Route::post("/quen-mat-khau", [UserController::class, "_forgot"]);
    Route::get("/xac-thuc-email/{code}", [UserController::class, "verifi"]);
    Route::post("/dat-lai-mat-khau", [UserController::class, "reset"]);
});


Route::middleware('login', 'prevent-back-history')->prefix('admin')->name('admin.')->group(function () {
    Route::get("/", [IndexController::class, "index"]);
    Route::post('/load-notification',[IndexController::class,"loadnotification"]);
    Route::prefix('devices')->name('devices.')->group(function () {
        Route::get('/all', [DeviceController::class, "index"]);
        Route::get('/create', [DeviceController::class, "create"])->middleware('function:1');
        Route::post('/create', [DeviceController::class, "store"]);
        Route::post('/get-devices-by-status', [DeviceController::class, "fiter_by_status"]);
        Route::post('/load-view-more-devices-filter', [DeviceController::class, "load_more_devices_filter"]);
        Route::post('/keyup-search-devices', [DeviceController::class, "keyup"]);
        Route::get('/show/{id?}', [DeviceController::class, "show"])->middleware('function:3');
        Route::get('/edit/{id?}', [DeviceController::class, "edit"])->middleware('function:2');
        Route::post('/update', [DeviceController::class, "update"]);
        Route::post('/load-ratio', [IndexController::class, "ratioDevices"]);
    });
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/all', [ServiceController::class, "index"]);
        Route::post('/get-services-by-date', [ServiceController::class, "filter"]);
        Route::post('/view-more-services', [ServiceController::class, "viewMore"]);
        Route::post('/keyup-search-services', [ServiceController::class, "keyup"]);
        Route::post('/view-more-keyup-services', [ServiceController::class, "viewMoreKeyup"]);
        Route::get('/create', [ServiceController::class, "create"])->middleware('function:4');
        Route::post('/create', [ServiceController::class, "store"]);
        Route::get('/show/{id?}', [ServiceController::class, "show"])->middleware('function:6');
        Route::get('/edit/{id?}', [ServiceController::class, "edit"])->middleware('function:5');
        Route::post('/update', [ServiceController::class, "update"]);
        Route::post('/filter-number-in-services', [ServiceController::class, "filterNumbersServices"]);
        Route::post('/view-more-numbers-in-detail-service', [ServiceController::class, "viewMoreNumbersInService"]);
        Route::post('/keyup-search-numbers-in-detail-services', [ServiceController::class, "keyupSearchNumbers"]);
        Route::post('/view-more-keyup-result-numbers-in-detail-services', [ServiceController::class, "viewMoreKeyupResultSearchNumbers"]);
        Route::post('/load-ratio', [IndexController::class, "ratioServices"]);
    });
    Route::prefix('number')->name('number.')->group(function () {
        Route::get('/all', [GiveNumber::class, 'index']);
        Route::get('/show/{id?}', [GiveNumber::class, "show"])->middleware('function:8');
        Route::get('/create', [GiveNumber::class, 'create'])->middleware('function:7');
        Route::post('/create', [GiveNumber::class, "store"]);
        Route::post('/filter', [GiveNumber::class, 'filter'])->middleware('function:9');
        Route::post('/view-more', [GiveNumber::class, 'viewMore']);
        Route::post('/keyup', [GiveNumber::class, "keyup"]);
        Route::post('/view-more-keyup', [GiveNumber::class, "viewMoreKeyup"]);
        Route::post('/load-ratio', [IndexController::class, "ratioNumbers"]);
    });
    Route::prefix('system')->name('system.')->group(function () {
        Route::prefix('role')->name('role.')->group(function () {
            Route::get('/all', [RoleController::class, "index"]);
            Route::get('/create', [RoleController::class, "create"])->middleware('function:12');
            Route::post('/create', [RoleController::class, "store"]);
            Route::get('/show/{id?}', [RoleController::class, "show"])->middleware('function:13');
            Route::post('/update', [RoleController::class, "update"]);
            Route::post('/keyup',[RoleController::class,"keyup"]);
        });
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/all', [ManageUsersController::class, "index"]);
            Route::get('/create', [ManageUsersController::class, "create"])->middleware('function:10');
            Route::post('/create', [ManageUsersController::class, "store"]);
            Route::get('/edit/{id?}', [ManageUsersController::class, "edit"])->middleware('function:11');
            Route::post('/update', [ManageUsersController::class, "update"]);
            Route::post('/filter',[ManageUsersController::class,"filter"]);
            Route::post('/view-more',[ManageUsersController::class,"viewMore"]);
            Route::post('/keyup',[ManageUsersController::class,"keyup"]);
            Route::post('/view-more-keyup',[ManageUsersController::class,"viewMoreKeyup"]);
        });
        Route::prefix('diary')->name('diary.')->group(function () {
            Route::get('/all', [ManageUsersController::class, "history"]);
            Route::post('/filter',[ManageUsersController::class,"filterHistory"]);
            Route::post('/view-more-filter',[ManageUsersController::class,"viewMoreFilter"]);
            Route::post('/keyup',[ManageUsersController::class,"keyupHistory"]);
            Route::post('/view-more-keyup',[ManageUsersController::class,"viewMoreHistoryKeyup"]);
        });
    });
    Route::prefix('report')->group(function(){
            Route::get('/all',[ReportController::class,"index"]);
            Route::post('/filter',[ReportController::class,"filter"]);
            Route::post('/view-more',[ReportController::class,"viewMore"]);
            Route::post('/filter-input',[ReportController::class,"filterInput"]);
    });
});
