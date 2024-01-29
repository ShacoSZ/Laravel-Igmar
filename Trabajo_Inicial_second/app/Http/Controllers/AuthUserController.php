<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthUserController extends Controller
{
    public function verify()
    {
        return view('welcome');
    }
    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|digits:6' // Ajusta la validación según tus necesidades
        ]);

        $user = Auth::user();

        if ($request->verification_code == $user->two_factor_code ) {
            $chnguser = User::where('id', $user->id)->first();
            $chnguser->two_factor_code = null;
            $chnguser->two_factor_expires_at = null;
            $chnguser->save();
            

            Auth::login($user);
            // Puedes redirigir al usuario a su dashboard u otra página
            return redirect()->route('test');
        } else {
            // Código incorrecto, muestra un mensaje de error
            return back()->withErrors(['verification_code' => 'Código incorrecto']);
        }
    }
}
