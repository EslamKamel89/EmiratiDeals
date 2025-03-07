<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


//! user routes
Route::get( '/', function () {
	return Inertia::render( 'Welcome', [ 
		'canLogin' => Route::has( 'login' ),
		'canRegister' => Route::has( 'register' ),
		'laravelVersion' => Application::VERSION,
		'phpVersion' => PHP_VERSION,
	] );
} );

Route::get( '/dashboard', function () {
	return Inertia::render( 'Dashboard' );
} )->middleware( [ 'auth', 'verified' ] )->name( 'dashboard' );

Route::middleware( 'auth' )->group( function () {
	Route::get( '/profile', [ ProfileController::class, 'edit' ] )->name( 'profile.edit' );
	Route::patch( '/profile', [ ProfileController::class, 'update' ] )->name( 'profile.update' );
	Route::delete( '/profile', [ ProfileController::class, 'destroy' ] )->name( 'profile.destroy' );
} );

//!admin routes
Route::prefix( 'admin' )
	->group( function () {
		Route::middleware( [ 'redirectAdmin' ] )
			->group( function () {
				Route::get( '/login', [ AdminAuthController::class, 'showLoginForm' ] )
					->name( 'admin.login' );
				Route::post( '/login', [ AdminAuthController::class, 'login' ] )
					->name( 'admin.login.post' );
			} );
		Route::middleware( [ 'auth' ] )->group( function () {
			Route::post( '/logout', [ AdminAuthController::class, 'logout' ] )
				->name( 'admin.logout' )->withoutMiddleware( 'redirectAdmin' );
		} );
		Route::middleware( [ 'auth', 'admin' ] )
			->group( function () {
				Route::get( '/dashboard', [ AdminController::class, 'index' ] )
					->name( 'admin.dashboard' );
			} );
	} );

require __DIR__ . '/auth.php';
