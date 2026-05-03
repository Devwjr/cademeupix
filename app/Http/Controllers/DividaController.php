<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
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
            ->paginate(15);

        return view('dividas.index', [
            'dividas' => $dividas,
            'search' => $search,
            'status' => $status,
            'statusOptions' => Divida::getStatusOptions(),
        ]);
    }

    public function create(Request $request)
    {
        $clienteId = $request->get('cliente_id');
        $clientes = Auth::user()->clientes()->orderBy('nome')->get();
        
        return view('dividas.create', [
            'clientes' => $clientes,
            'clienteId' => $clienteId,
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

        return redirect()
            ->route('dividas.show', $divida)
            ->with('success', 'Dívida registrada com sucesso!');
    }

    public function show(Divida $divida)
    {
        $this->authorize('view', $divida);
        
        $divida->load('cliente', 'cobranca');
        $divida->verificarEAtualizarStatus();
        
        return view('dividas.show', [
            'divida' => $divida,
        ]);
    }

    public function edit(Divida $divida)
    {
        $this->authorize('update', $divida);
        
        $clientes = Auth::user()->clientes()->orderBy('nome')->get();
        
        return view('dividas.edit', [
            'divida' => $divida,
            'clientes' => $clientes,
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

        return redirect()
            ->route('dividas.show', $divida)
            ->with('success', 'Dívida atualizada com sucesso!');
    }

    public function destroy(Divida $divida)
    {
        $this->authorize('delete', $divida);

        $divida->delete();

        return redirect()
            ->route('dividas.index')
            ->with('success', 'Dívida excluída com sucesso!');
    }

    public function marcarPago(Divida $divida)
    {
        $this->authorize('update', $divida);

        $divida->marcarComoPaga();

        return back()->with('success', 'Dívida marcada como paga!');
    }
}
