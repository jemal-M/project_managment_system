<?php

use App\Http\Controllers\LeaseController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::put('/users', [UserController::class, 'update']);
    Route::put('/users/{id}/edit', [UserController::class, 'edit']);

    Route::get('/organizations', [OrganizationController::class, 'index']);
    Route::post('/organizations', [OrganizationController::class, 'store']);
    Route::get('/organizations/{id}', [OrganizationController::class, 'show']);
    Route::delete('/organizations/{id}', [OrganizationController::class, 'show']);
    Route::put('/organizations/{id}', [OrganizationController::class, 'update']);
    Route::get('/organizations/{id}/edit', [OrganizationController::class, 'edit']);


    Route::get('/properties', [PropertyController::class, 'index']);
    Route::post('/properties', [PropertyController::class, 'store']);
    Route::get('/properties/{id}', [PropertyController::class, 'show']);
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);
    Route::put('/properties/{id}', [PropertyController::class, 'update']);
    Route::get('/properties/{id}/edit', [PropertyController::class, 'edit']);

    Route::get('/units', [UnitController::class, 'index']);
    Route::post('/units', [UnitController::class, 'store']);
    Route::get('/units/{id}', [UnitController::class, 'show']);
    Route::put('/units/{id}', [UnitController::class, 'update']);
    Route::delete('/units/{id}', [UnitController::class, 'delete']);
    Route::get('/units/{id}/edit', [UnitController::class, 'edit']);

    Route::get('/leases', [LeaseController::class, 'index']);
    Route::post('/leases', [LeaseController::class, 'store']);
    Route::get('/leases/{id}', [LeaseController::class, 'show']);
    Route::put('/leases/{id}', [LeaseController::class, 'update']);
    Route::delete('/leases/{id}', [LeaseController::class, 'destroy']);
    Route::get('/leases/{id}/edit', [LeaseController::class, 'store']);

    Route::get('/tenants', [TenantController::class, 'index']);
    Route::post('/tenants', [TenantController::class, 'store']);
    Route::get('/tenants/{id}', [TenantController::class, 'show']);
    Route::put('/tenants/{id}', [TenantController::class, 'update']);
    Route::delete('/tenants/{id}', [TenantController::class, 'destroy']);
    Route::get('/tenants/{id}/edit', [TenantController::class, 'edit']);

    Route::get('payments', [PaymentController::class, 'index']);
    Route::post('payments', [PaymentController::class, 'store']);
    Route::get('payments/{id}', [PaymentController::class, 'show']);
    Route::put('payments/{id}', [PaymentController::class, 'update']);
    Route::delete('payments/{id}', [PaymentController::class, 'destroy']);
    Route::get('payments/{id}/edit', [PaymentController::class, 'edit']);
});
