<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Restaurante;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MesaController extends Controller
{
    public function index(Request $request)
    {
        $mesas = Mesa::with('restaurante')->get();

        if ($request->wantsJson()) {
            return response()->json($mesas);
        }

        return view('mesas.index', compact('mesas'));
    }

    public function create()
    {
        $restaurantes = Restaurante::all();
        return view('mesas.create', compact('restaurantes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'numero' => 'required|integer',
            'restaurante_id' => 'required|exists:restaurantes,id'
        ]);

        // Cria a mesa sem QR Code inicialmente
        $mesa = Mesa::create([
            'numero' => $data['numero'],
            'restaurante_id' => $data['restaurante_id'],
            'qr_code_url' => ''
        ]);

        // Gera o QR Code com a URL da mesa
        $url = url("/api/mesa/{$mesa->id}");
        $qrFileName = "qr_codes/mesa_{$mesa->id}.png";
        $qrImage = QrCode::format('png')->size(300)->generate($url);
        Storage::disk('public')->put($qrFileName, $qrImage);

        // Atualiza a mesa com o caminho do QR gerado
        $mesa->update([
            'qr_code_url' => asset("storage/{$qrFileName}")
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Mesa criada com QR Code.', 'mesa' => $mesa], 201);
        }

        return redirect()->route('mesas.index')->with('success', 'Mesa criada com sucesso!');
    }

    public function show(Mesa $mesa, Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json($mesa);
        }

        return view('mesas.show', compact('mesa'));
    }

    public function edit(Mesa $mesa)
    {
        $restaurantes = Restaurante::all();
        return view('mesas.edit', compact('mesa', 'restaurantes'));
    }

    public function update(Request $request, Mesa $mesa)
    {
        $data = $request->validate([
            'numero' => 'required|integer',
            'restaurante_id' => 'required|exists:restaurantes,id'
        ]);

        $mesa->update($data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Mesa atualizada com sucesso.', 'mesa' => $mesa]);
        }

        return redirect()->route('mesas.index')->with('success', 'Mesa atualizada com sucesso!');
    }

    public function destroy(Mesa $mesa, Request $request)
    {
        $mesa->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Mesa excluída com sucesso.']);
        }

        return redirect()->route('mesas.index')->with('success', 'Mesa excluída com sucesso!');
    }

    // ✅ Método extra: rota pública do cardápio
    public function cardapio($id)
    {
        $mesa = Mesa::find($id);

        if (!$mesa) {
            return response()->json(['message' => 'Mesa não encontrada.'], 404);
        }

        $restauranteId = $mesa->restaurante_id;

        $categorias = Categoria::with(['items' => function ($query) use ($restauranteId) {
            $query->where('restaurante_id', $restauranteId);
        }])
        ->where('restaurante_id', $restauranteId)
        ->get();

        return response()->json([
            'mesa' => $mesa->numero,
            'restaurante' => $mesa->restaurante->nome,
            'cardapio' => $categorias
        ]);
    }
}
