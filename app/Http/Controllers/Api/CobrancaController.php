<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cobranca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CobrancaController extends Controller
{
    public function show(Cobranca $cobranca)
    {
        $this->authorize('view', $cobranca);
        
        $cobranca->load('divida.cliente');

        return response()->json([
            'success' => true,
            'data' => $cobranca,
        ]);
    }

    public function update(Request $request, Cobranca $cobranca)
    {
        $this->authorize('update', $cobranca);

        $validated = $request->validate([
            'link_pagamento' => ['nullable', 'url'],
        ]);

        $cobranca->update($validated);

        return response()->json([
            'success' => true,
            'data' => $cobranca,
            'message' => 'Cobrança atualizada com sucesso',
        ]);
    }

    public function destroy(Cobranca $cobranca)
    {
        $this->authorize('delete', $cobranca);

        $cobranca->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cobrança excluída com sucesso',
        ]);
    }

    public function marcarPago(Cobranca $cobranca)
    {
        $this->authorize('update', $cobranca);

        $cobranca->marcarComoPago();

        return response()->json([
            'success' => true,
            'data' => $cobranca->fresh('divida.cliente'),
            'message' => 'Cobrança marcada como paga',
        ]);
    }

    public function whatsAppLink(Cobranca $cobranca)
    {
        $this->authorize('view', $cobranca);
        
        $cobranca->load('divida.cliente');

        return response()->json([
            'success' => true,
            'data' => [
                'link' => $cobranca->link_whatsapp,
                'mensagem' => $cobranca->mensagem_whatsapp,
            ],
        ]);
    }
}
