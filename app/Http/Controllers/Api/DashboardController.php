<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Divida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalPendentes = $user->dividas()
            ->whereIn('status', [Divida::STATUS_PENDENTE, Divida::STATUS_VENCIDO])
            ->sum('valor');
        
        $totalVencidas = $user->dividas()
            ->where('status', Divida::STATUS_VENCIDO)
            ->sum('valor');
        
        $totalClientes = $user->clientes()->count();
        
        $qtdPendentes = $user->dividas()
            ->whereIn('status', [Divida::STATUS_PENDENTE, Divida::STATUS_VENCIDO])
            ->count();
        
        $qtdVencidas = $user->dividas()
            ->where('status', Divida::STATUS_VENCIDO)
            ->count();

        $dividasRecentes = $user->dividas()
            ->with('cliente')
            ->whereIn('status', [Divida::STATUS_PENDENTE, Divida::STATUS_VENCIDO])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $topDevedores = $user->clientes()
            ->withSum(['dividas' => fn($q) => 
                $q->whereIn('status', [Divida::STATUS_PENDENTE, Divida::STATUS_VENCIDO])], 'valor')
            ->orderByDesc('dividas_sum_valor')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_pendente' => $totalPendentes,
                'total_vencido' => $totalVencidas,
                'total_clientes' => $totalClientes,
                'qtd_pendente' => $qtdPendentes,
                'qtd_vencido' => $qtdVencidas,
                'dividas_recentes' => $dividasRecentes,
                'top_devedores' => $topDevedores,
            ],
        ]);
    }
}
