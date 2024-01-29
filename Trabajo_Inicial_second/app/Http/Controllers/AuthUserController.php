<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthUserController extends Controller
{
    public function verify()
    {
        return view('MailView');
    }
    public function verifyTwoFactor(Request $request)
    {
        
        $request->validate([
            'verification_code' => 'required|digits:6' // Ajusta la validación según tus necesidades
        ]);

        $user = User::where('id', $request->user)->first();

        if ($request->verification_code == $user->two_factor_code && $user->two_factor_expires_at > now()) {
            $chnguser = User::where('id', $user->id)->first();
            $chnguser->two_factor_code = null;
            $chnguser->two_factor_expires_at = null;
            $chnguser->save();
            $time = now();

            Auth::login($user);
            Log::info('User Admin: ' . $user->name . ' (' . $user->email . ') passed the second Authentication Phase.');
            Log::info('User Admin: ' . $user->name . ' (' . $user->email . '), Time:('.$time.') has logged in.');
            // Puedes redirigir al usuario a su dashboard u otra página
            return redirect()->route('AdminHome');
        } else {
            // Código incorrecto, muestra un mensaje de error
            return back()->withErrors(['verification_code' => 'Código incorrecto']);
        }
    }
}
