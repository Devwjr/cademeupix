<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cobranca;
use App\Models\Divida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DividaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $search = $request->get('search', '');
        $status = $request->get('status', '');
        
        $dividas = $user->dividas()
            ->with('cliente', 'cobranca')
            ->when($search, fn($q) => $q->where('descricao', 'like', "%{$search}%"))
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $dividas,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'descricao' => ['required', 'string', 'max:255'],
            'valor' => ['required', 'numeric', 'min:0.01'],
            'data_venda' => ['required', 'date'],
            'data_vencimento' => ['nullable', 'date', 'after_or_equal:data_venda'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = Divida::STATUS_PENDENTE;

        $divida = Divida::create($validated);

        return response()->json([
            'success' => true,
            'data' => $divida->load('cliente'),
            'message' => 'Dívida criada com sucesso',
        ], 201);
    }

    public function show(Divida $divida)
    {
        $this->authorize('view', $divida);
        
        $divida->load('cliente', 'cobranca');
        $divida->verificarEAtualizarStatus();

        return response()->json([
            'success' => true,
            'data' => $divida,
        ]);
    }

    public function update(Request $request, Divida $divida)
    {
        $this->authorize('update', $divida);

        $validated = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'descricao' => ['required', 'string', 'max:255'],
            'valor' => ['required', 'numeric', 'min:0.01'],
            'data_venda' => ['required', 'date'],
            'data_vencimento' => ['nullable', 'date', 'after_or_equal:data_venda'],
        ]);

        $divida->update($validated);
        $divida->verificarEAtualizarStatus();

        return response()->json([
            'success' => true,
            'data' => $divida,
            'message' => 'Dívida atualizada com sucesso',
        ]);
    }

    public function destroy(Divida $divida)
    {
        $this->authorize('delete', $divida);

        $divida->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dívida excluída com sucesso',
        ]);
    }

    public function marcarPago(Divida $divida)
    {
        $this->authorize('update', $divida);

        $divida->marcarComoPaga();

        return response()->json([
            'success' => true,
            'data' => $divida->fresh('cliente', 'cobranca'),
            'message' => 'Dívida marcada como paga',
        ]);
    }

    public function gerarCobranca(Divida $divida)
    {
        $this->authorize('create', [Cobranca::class, $divida]);

        if ($divida->cobranca) {
            return response()->json([
                'success' => false,
                'message' => 'Esta dívida já possui uma cobrança',
            ], 400);
        }

        $cobranca = Cobranca::create([
            'user_id' => Auth::id(),
            'divida_id' => $divida->id,
            'chave_pix' => Cobranca::gerarChavePix(),
            'valor' => $divida->valor,
            'status' => Cobranca::STATUS_PENDENTE,
        ]);

        return response()->json([
            'success' => true,
            'data' => $cobranca->load('divida.cliente'),
            'message' => 'Cobrança gerada com sucesso',
        ], 201);
    }
}
