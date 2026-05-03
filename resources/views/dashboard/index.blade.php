@extends('layouts.app')

@push('styles')
<style>
    .stat-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(25, 135, 84, 0.2);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #198754, #20c997);
    }
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .chart-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .chart-card .card-header {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        border: none;
        border-radius: 16px 16px 0 0;
        padding: 1.25rem 1.5rem;
    }
    .table-modern thead th {
        background: linear-gradient(135deg, #198754, #157347);
        color: white;
        border: none;
        font-weight: 600;
        padding: 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table-modern tbody tr {
        transition: all 0.2s;
    }
    .table-modern tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.08);
    }
    .badge-modern {
        padding: 0.5em 1em;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold">
                <i class="bi bi-speedometer2 text-success me-2"></i> Dashboard
            </h2>
            <p class="text-muted mb-0">Visão geral das suas finanças</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('clientes.create') }}" class="btn btn-outline-primary">
                <i class="bi bi-person-plus me-2"></i> Novo Cliente
            </a>
            <a href="{{ route('dividas.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i> Nova Dívida
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card h-100" style="background: linear-gradient(135deg, #f8fff9, #e8f5e9);">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-uppercase small fw-bold text-muted mb-1" style="letter-spacing: 1px;">Total Pendente</p>
                            <h3 class="fw-bold mb-0" style="color: #198754;">R$ {{ number_format($totalDividasPendentes, 2, ',', '.') }}</h3>
                            <small class="text-muted">Em dívidas</small>
                        </div>
                        <div class="stat-icon" style="background-color: rgba(25, 135, 84, 0.15);">
                            <i class="bi bi-currency-dollar" style="color: #198754; font-size: 1.8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card h-100" style="background: linear-gradient(135deg, #fff5f5, #ffe0e0);">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-uppercase small fw-bold text-muted mb-1" style="letter-spacing: 1px;">Vencidas</p>
                            <h3 class="fw-bold mb-0 text-danger">{{ $totalDividasVencidas }}</h3>
                            <small class="text-muted">Dívidas vencidas</small>
                        </div>
                        <div class="stat-icon" style="background-color: rgba(220, 53, 69, 0.15);">
                            <i class="bi bi-exclamation-triangle text-danger" style="font-size: 1.8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card h-100" style="background: linear-gradient(135deg, #f0f9ff, #e0f0ff);">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-uppercase small fw-bold text-muted mb-1" style="letter-spacing: 1px;">Clientes</p>
                            <h3 class="fw-bold mb-0" style="color: #0d6efd;">{{ $totalClientes }}</h3>
                            <small class="text-muted">Cadastrados</small>
                        </div>
                        <div class="stat-icon" style="background-color: rgba(13, 110, 253, 0.15);">
                            <i class="bi bi-people" style="color: #0d6efd; font-size: 1.8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card h-100" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-uppercase small fw-bold text-muted mb-1" style="letter-spacing: 1px;">Cobranças</p>
                            <h3 class="fw-bold mb-0" style="color: #20c997;">{{ $dividas->total() }}</h3>
                            <small class="text-muted">Registradas</small>
                        </div>
                        <div class="stat-icon" style="background-color: rgba(32, 201, 151, 0.15);">
                            <i class="bi bi-qr-code" style="color: #20c997; font-size: 1.8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="mb-0 text-white">
                        <i class="bi bi-graph-up me-2"></i> Evolução Mensal
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="evoluacaoChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card chart-card h-100">
                <div class="card-header">
                    <h5 class="mb-0 text-white">
                        <i class="bi bi-pie-chart me-2"></i> Status das Dívidas
                    </h5>
                </div>
                <div class="card-body d-flex align-items-center">
                    <canvas id="statusChart" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card chart-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">
                            <i class="bi bi-list-ul me-2"></i> Dívidas Recentes
                        </h5>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('dashboard', ['filtro' => 'todos']) }}"
                               class="btn btn-sm {{ $filtro === 'todos' ? 'btn-dark' : 'btn-outline-dark' }}">Todos</a>
                            <a href="{{ route('dashboard', ['filtro' => 'pendente']) }}"
                               class="btn btn-sm {{ $filtro === 'pendente' ? 'btn-dark' : 'btn-outline-dark' }}">Pendentes</a>
                            <a href="{{ route('dashboard', ['filtro' => 'vencido']) }}"
                               class="btn btn-sm {{ $filtro === 'vencido' ? 'btn-dark' : 'btn-outline-dark' }}">Vencidas</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($dividas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-modern mb-0">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Descrição</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dividas as $divida)
                                        <tr>
                                            <td>
                                                <a href="{{ route('clientes.show', $divida->cliente) }}" class="text-decoration-none fw-semibold" style="color: #198754;">
                                                    {{ $divida->cliente->nome }}
                                                </a>
                                            </td>
                                            <td class="text-muted">{{ Str::limit($divida->descricao, 30) }}</td>
                                            <td class="fw-bold" style="color: #198754;">R$ {{ number_format($divida->valor, 2, ',', '.') }}</td>
                                            <td>
                                                @switch($divida->status)
                                                    @case('pendente')
                                                        <span class="badge-modern" style="background-color: #fff3cd; color: #664d03;">Pendente</span>
                                                        @break
                                                    @case('pago')
                                                        <span class="badge-modern bg-success text-white">Pago</span>
                                                        @break
                                                    @case('vencido')
                                                        <span class="badge-modern bg-danger text-white">Vencido</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{ route('dividas.show', $divida) }}" class="btn btn-action btn-outline-primary" title="Ver">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-white border-top-0 py-3">
                            {{ $dividas->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #198754; opacity: 0.5;"></i>
                            <p class="text-muted mt-3">Nenhuma dívida cadastrada</p>
                            <a href="{{ route('dividas.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-2"></i> Cadastrar Dívida
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card chart-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0 text-white">
                        <i class="bi bi-trophy me-2"></i> Top Devedores
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($dividasPorCliente) && $dividasPorCliente->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($dividasPorCliente as $item)
                                <a href="{{ route('clientes.show', $item->cliente_id) }}"
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                    <div>
                                        <p class="mb-1 fw-semibold">{{ $item->cliente->nome ?? 'Cliente' }}</p>
                                        <small class="text-muted">{{ $item->total }} dívida(s)</small>
                                    </div>
                                    <span class="badge-modern" style="background-color: rgba(25, 135, 84, 0.15); color: #198754; font-weight: 700;">
                                        R$ {{ number_format($item->valor_total, 2, ',', '.') }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Nenhum dado disponível</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="mb-0 text-white">
                        <i class="bi bi-graph-up me-2"></i> Resumo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <span class="text-muted">Dívidas Pendentes:</span>
                        <span class="fw-bold" style="color: #198754;">{{ $dividas->where('status', 'pendente')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <span class="text-muted">Dívidas Pagas:</span>
                        <span class="fw-bold text-success">{{ $dividas->where('status', 'pago')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Dívidas Vencidas:</span>
                        <span class="fw-bold text-danger">{{ $dividas->where('status', 'vencido')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const evolucaoCtx = document.getElementById('evoluacaoChart').getContext('2d');
    const evolucaoChart = new Chart(evolucaoCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($evolucaoMensal->pluck('mes')) !!},
            datasets: [{
                label: 'Valor das Dívidas (R$)',
                data: {!! json_encode($evolucaoMensal->pluck('total')) !!},
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusLabels) !!},
            datasets: [{
                data: {!! json_encode($statusValues) !!},
                backgroundColor: ['#198754', '#20c997', '#dc3545'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
@endsection
