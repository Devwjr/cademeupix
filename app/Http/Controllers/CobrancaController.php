<?php

namespace App\Http\Controllers;

use App\Models\Cobranca;
use App\Models\Divida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CobrancaController extends Controller
{
    public function create(Divida $divida)
    {
        $this->authorize('create', [Cobranca::class, $divida]);
        
        if ($divida->cobranca) {
            return redirect()
                ->route('cobrancas.show', $divida->cobranca)
                ->with('info', 'Esta dívida já possui uma cobrança.');
        }

        return view('cobrancas.create', [
            'divida' => $divida,
        ]);
    }

    public function store(Request $request, Divida $divida)
    {
        $this->authorize('create', [Cobranca::class, $divida]);

        if ($divida->cobranca) {
            return back()->with('error', 'Esta dívida já possui uma cobrança.');
        }

        $validated = $request->validate([
            'link_pagamento' => ['nullable', 'url'],
        ]);

        $cobranca = Cobranca::create([
            'user_id' => Auth::id(),
            'divida_id' => $divida->id,
            'chave_pix' => Cobranca::gerarChavePix(),
            'valor' => $divida->valor,
            'status' => Cobranca::STATUS_PENDENTE,
            'link_pagamento' => $validated['link_pagamento'] ?? null,
        ]);

        return redirect()
            ->route('cobrancas.show', $cobranca)
            ->with('success', 'Cobrança gerada com sucesso!');
    }

    public function show(Cobranca $cobranca)
    {
        $this->authorize('view', $cobranca);
        
        $cobranca->load('divida.cliente');

        return view('cobrancas.show', [
            'cobranca' => $cobranca,
        ]);
    }

    public function edit(Cobranca $cobranca)
    {
        $this->authorize('update', $cobranca);

        return view('cobrancas.edit', [
            'cobranca' => $cobranca,
        ]);
    }

    public function update(Request $request, Cobranca $cobranca)
    {
        $this->authorize('update', $cobranca);

        $validated = $request->validate([
            'link_pagamento' => ['nullable', 'url'],
        ]);

        $cobranca->update($validated);

        return redirect()
            ->route('cobrancas.show', $cobranca)
            ->with('success', 'Cobrança atualizada com sucesso!');
    }

    public function destroy(Cobranca $cobranca)
    {
        $this->authorize('delete', $cobranca);

        $cobranca->delete();

        return redirect()
            ->route('dividas.show', $cobranca->divida_id)
            ->with('success', 'Cobrança excluída com sucesso!');
    }

    public function marcarPago(Cobranca $cobranca)
    {
        $this->authorize('update', $cobranca);

        $cobranca->marcarComoPago();

        return back()->with('success', 'Cobrança marcada como paga!');
    }

    public function enviarWhatsApp(Cobranca $cobranca)
    {
        $this->authorize('view', $cobranca);
        
        $cobranca->load('divida.cliente');

        return view('cobrancas.whatsapp', [
            'cobranca' => $cobranca,
            'linkWhatsApp' => $cobranca->link_whatsapp,
        ]);
    }
}
