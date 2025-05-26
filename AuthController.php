<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // 🔐 Login via API (Postman)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->senha, $admin->senha)) {
            return response()->json(['message' => 'Credenciais inválidas.'], 401);
        }

        Session::put('admin_id', $admin->id);

        return response()->json([
            'message' => 'Login bem-sucedido.',
            'admin' => $admin,
            'session' => session()->getId()
        ]);
    }

    // 🚪 Logout via API
    public function logout(Request $request)
    {
        Session::forget('admin_id');

        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }

    // ℹ️ API: Info do admin autenticado
    public function me()
    {
        if (!Session::has('admin_id')) {
            return response()->json(['message' => 'Não autenticado.'], 401);
        }

        $admin = Admin::find(Session::get('admin_id'));

        return response()->json(['admin' => $admin]);
    }

    // 👁️ Exibir formulário de login (web)
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 🔐 Login via formulário (Blade)
    public function loginWeb(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string'
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->senha, $admin->senha)) {
            return back()->withErrors(['email' => 'Credenciais inválidas.']);
        }

        Session::put('admin_id', $admin->id);

        return redirect()->route('dashboard');
    }

    // 🚪 Logout web (opcional para botão sair)
    public function logoutWeb()
    {
        Session::forget('admin_id');
        return redirect()->route('login');
    }
}
