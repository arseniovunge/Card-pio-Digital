<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // Listar todos os itens
    public function index(Request $request)
    {
        $items = Item::with('categoria')->get();

        if ($request->wantsJson()) {
            return response()->json($items);
        }

        return view('items.index', compact('items'));
    }

    // Formulário de criação
    public function create()
    {
        $categorias = Categoria::all();
        return view('items.create', compact('categorias'));
    }

    // Armazenar novo item
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric',
            'imagem_url' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'restaurante_id' => 'required|exists:restaurantes,id'
        ]);

        $item = Item::create($data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Item criado com sucesso.', 'item' => $item], 201);
        }

        return redirect()->route('items.index')->with('success', 'Item criado com sucesso!');
    }

    // Mostrar detalhes
    public function show(Item $item, Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json($item);
        }

        return view('items.show', compact('item'));
    }

    // Formulário de edição
    public function edit(Item $item)
    {
        $categorias = Categoria::all();
        return view('items.edit', compact('item', 'categorias'));
    }

    // Atualizar item
    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric',
            'imagem_url' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'restaurante_id' => 'required|exists:restaurantes,id'
        ]);

        $item->update($data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Item atualizado com sucesso.', 'item' => $item]);
        }

        return redirect()->route('items.index')->with('success', 'Item atualizado com sucesso!');
    }

    // Excluir item
    public function destroy(Item $item, Request $request)
    {
        $item->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Item excluído com sucesso.']);
        }

        return redirect()->route('items.index')->with('success', 'Item excluído com sucesso!');
    }
}
