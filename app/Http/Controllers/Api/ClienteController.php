<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        
        $clientes = Auth::user()->clientes()
            ->when($search, fn($q) => $q->where('nome', 'like', "%{$search}%")
                ->orWhere('telefone', 'like', "%{$search}%")
                ->orWhere('cpf', 'like', "%{$search}%"))
            ->withCount(['dividas as dividas_pendentes_count' => fn($q) => 
                $q->whereIn('status', ['pendente', 'vencido'])])
            ->withSum(['dividas as total_pendente' => fn($q) => 
                $q->whereIn('status', ['pendente', 'vencido'])], 'valor')
            ->orderBy('nome')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $clientes,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'telefone' => ['required', 'string', 'max:20'],
            'cpf' => ['nullable', 'string', 'max:14'],
        ]);

        $validated['user_id'] = Auth::id();

        $cliente = Cliente::create($validated);

        return response()->json([
            'success' => true,
            'data' => $cliente,
            'message' => 'Cliente criado com sucesso',
        ], 201);
    }

    public function show(Cliente $cliente)
    {
        $this->authorize('view', $cliente);
        
        $cliente->load(['dividas' => fn($q) => $q->orderByDesc('created_at')]);
        
        return response()->json([
            'success' => true,
            'data' => $cliente,
        ]);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $this->authorize('update', $cliente);

        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'telefone' => ['required', 'string', 'max:20'],
            'cpf' => ['nullable', 'string', 'max:14'],
        ]);

        $cliente->update($validated);

        return response()->json([
            'success' => true,
            'data' => $cliente,
            'message' => 'Cliente atualizado com sucesso',
        ]);
    }

    public function destroy(Cliente $cliente)
    {
        $this->authorize('delete', $cliente);

        $cliente->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cliente excluído com sucesso',
        ]);
    }
}
