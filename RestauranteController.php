<?php
namespace App\Http\Controllers;
use App\Models\Restaurante;
use Illuminate\Http\Request;

class RestauranteController extends Controller
{
    public function index(Request $request)
    {
        $restaurantes = Restaurante::all();

        if ($request->wantsJson()) {
            return response()->json($restaurantes);
        }

        return view('restaurantes.index', compact('restaurantes'));
    }

    public function create()
    {
        return view('restaurantes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string',
            'endereco' => 'required|string',
            'telefone' => 'required|string',
            'email' => 'required|email|unique:restaurantes,email'
        ]);

        $restaurante = Restaurante::create($data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Restaurante criado com sucesso.', 'restaurante' => $restaurante], 201);
        }

        return redirect()->route('restaurantes.index')->with('success', 'Restaurante criado com sucesso!');
    }

    public function show(Restaurante $restaurante, Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json($restaurante);
        }

        return view('restaurantes.show', compact('restaurante'));
    }

    public function edit(Restaurante $restaurante)
    {
        return view('restaurantes.edit', compact('restaurante'));
    }

    public function update(Request $request, Restaurante $restaurante)
    {
        $data = $request->validate([
            'nome' => 'required|string',
            'endereco' => 'required|string',
            'telefone' => 'required|string',
            'email' => 'required|email|unique:restaurantes,email,' . $restaurante->id
        ]);

        $restaurante->update($data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Restaurante atualizado com sucesso.', 'restaurante' => $restaurante]);
        }

        return redirect()->route('restaurantes.index')->with('success', 'Restaurante atualizado com sucesso!');
    }

    public function destroy(Restaurante $restaurante, Request $request)
    {
        $restaurante->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Restaurante excluído com sucesso.']);
        }

        return redirect()->route('restaurantes.index')->with('success', 'Restaurante excluído com sucesso!');
    }
}
