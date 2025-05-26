<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Restaurante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $admins = Admin::with('restaurante')->get();

        if ($request->wantsJson()) {
            return response()->json($admins);
        }

        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        $restaurantes = Restaurante::all();
        return view('admins.create', compact('restaurantes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email|unique:admins,email',
            'senha' => 'required|string|min:4',
            'restaurante_id' => 'required|exists:restaurantes,id'
        ]);

        $data['senha'] = bcrypt($data['senha']);

        $admin = Admin::create($data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Administrador criado com sucesso.', 'admin' => $admin], 201);
        }

        return redirect()->route('admins.index')->with('success', 'Administrador criado com sucesso!');
    }

    public function show(Admin $admin, Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json($admin);
        }

        return view('admins.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        $restaurantes = Restaurante::all();
        return view('admins.edit', compact('admin', 'restaurantes'));
    }

    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'senha' => 'nullable|string|min:4',
            'restaurante_id' => 'required|exists:restaurantes,id'
        ]);

        if (!empty($data['senha'])) {
            $data['senha'] = bcrypt($data['senha']);
        } else {
            unset($data['senha']);
        }

        $admin->update($data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Administrador atualizado.', 'admin' => $admin]);
        }

        return redirect()->route('admins.index')->with('success', 'Administrador atualizado com sucesso!');
    }

    public function destroy(Admin $admin, Request $request)
    {
        $admin->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Administrador excluído com sucesso.']);
        }

        return redirect()->route('admins.index')->with('success', 'Administrador excluído com sucesso!');
    }
}
