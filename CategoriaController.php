<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Restaurante;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::with('restaurante')->get();

        if ($request->wantsJson()) {
            return response()->json($categorias);
        }

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        $restaurantes = Restaurante::all();
        return view('categorias.create', compact('restaurantes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'restaurante_id' => 'required|exists:restaurantes,id'
        ]);

        $categoria = Categoria::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Categoria criada com sucesso.',
                'categoria' => $categoria
            ], 201);
        }

        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function show(Categoria $categoria, Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json($categoria);
        }

        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        $restaurantes = Restaurante::all();
        return view('categorias.edit', compact('categoria', 'restaurantes'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'restaurante_id' => 'required|exists:restaurantes,id'
        ]);

        $categoria->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Categoria atualizada com sucesso.',
                'categoria' => $categoria
            ]);
        }

        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Categoria $categoria, Request $request)
    {
        $categoria->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Categoria excluída com sucesso.']);
        }

        return redirect()->route('categorias.index')->with('success', 'Categoria excluída com sucesso!');
    }
}
