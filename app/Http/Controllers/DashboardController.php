<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Divida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $totalClientes = Cliente::where('user_id', $user->id)->count();
        $totalDividasPendentes = Divida::where('user_id', $user->id)
            ->whereIn('status', [Divida::STATUS_PENDENTE, Divida::STATUS_VENCIDO])
            ->sum('valor');

        $totalDividasVencidas = Divida::where('user_id', $user->id)
            ->where('status', Divida::STATUS_VENCIDO)
            ->count();

        $dividasPorCliente = Divida::where('user_id', $user->id)
            ->with('cliente')
            ->selectRaw('cliente_id, COUNT(*) as total, SUM(valor) as valor_total')
            ->whereIn('status', [Divida::STATUS_PENDENTE, Divida::STATUS_VENCIDO])
            ->groupBy('cliente_id')
            ->orderByDesc('valor_total')
            ->limit(5)
            ->get();

        $filtro = $request->get('filtro', 'todos');
        $status = match ($filtro) {
            'pendente' => Divida::STATUS_PENDENTE,
            'pago' => Divida::STATUS_PAGO,
            'vencido' => Divida::STATUS_VENCIDO,
            default => null,
        };

        $dividas = Divida::where('user_id', $user->id)
            ->with('cliente', 'cobranca')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(15);

        $evolucaoMensal = Divida::where('user_id', $user->id)
            ->selectRaw('strftime("%Y-%m", created_at) as mes, SUM(valor) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->limit(6)
            ->get();

        $statusLabels = ['Pendente', 'Pago', 'Vencido'];
        $statusValues = [
            Divida::where('user_id', $user->id)->where('status', Divida::STATUS_PENDENTE)->count(),
            Divida::where('user_id', $user->id)->where('status', Divida::STATUS_PAGO)->count(),
            Divida::where('user_id', $user->id)->where('status', Divida::STATUS_VENCIDO)->count(),
        ];

        return view('dashboard.index', [
            'totalClientes' => $totalClientes,
            'totalDividasPendentes' => $totalDividasPendentes,
            'totalDividasVencidas' => $totalDividasVencidas,
            'dividasPorCliente' => $dividasPorCliente,
            'dividas' => $dividas,
            'filtro' => $filtro,
            'evolucaoMensal' => $evolucaoMensal,
            'statusLabels' => $statusLabels,
            'statusValues' => $statusValues,
        ]);
    }
}
