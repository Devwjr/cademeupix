<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        
        $clientes = Auth::user()
            ->clientes()
            ->when($search, fn($q) => $q->where('nome', 'like', "%{$search}%")
                ->orWhere('telefone', 'like', "%{$search}%")
                ->orWhere('cpf', 'like', "%{$search}%"))
            ->orderBy('nome')
            ->paginate(15);

        return view('clientes.index', [
            'clientes' => $clientes,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'telefone' => ['required', 'string', 'max:20'],
            'cpf' => ['nullable', 'string', 'max:14', 'unique:clientes,cpf'],
        ]);

        $validated['user_id'] = Auth::id();

        Cliente::create($validated);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function show(Cliente $cliente)
    {
        $this->authorize('view', $cliente);
        
        $cliente->load('dividas.cobranca');
        
        return view('clientes.show', [
            'cliente' => $cliente,
        ]);
    }

    public function edit(Cliente $cliente)
    {
        $this->authorize('update', $cliente);
        
        return view('clientes.edit', [
            'cliente' => $cliente,
        ]);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $this->authorize('update', $cliente);

        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'telefone' => ['required', 'string', 'max:20'],
            'cpf' => ['nullable', 'string', 'max:14', Rule::unique('clientes')->ignore($cliente->id)],
        ]);

        $cliente->update($validated);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $this->authorize('delete', $cliente);

        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }
}
