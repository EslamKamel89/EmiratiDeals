<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller {
	public function showLoginForm() {
		return inertia( 'Admin/Auth/login' );
	}
	public function login( Request $request ) {
		if ( auth()->attempt(
			[ 'email' => $request->email, 'password' => $request->password, 'isadmin' => 1 ]
		) ) {
			return redirect()->route( 'admin.dashboard' );
		}
		return redirect()->route( 'admin.login' )->with( 'error', 'Invalid Credentials' );
	}
	public function logout() {
		auth()->logout();
		session()->invalidate();
		return redirect()->route( 'admin.login' );
	}
}
