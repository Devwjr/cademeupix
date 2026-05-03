@extends('layouts.app')

@section('title', 'Dívidas - CadêMeuPix')

@push('styles')
<style>
    .table-modern thead th {
        background: linear-gradient(135deg, #198754, #157347);
        color: white;
        border: none;
        font-weight: 600;
        padding: 1rem;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table-modern tbody tr {
        transition: all 0.2s;
    }
    .table-modern tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.08);
    }
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .card-modern .card-header {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        border: none;
        border-radius: 16px 16px 0 0;
        padding: 1.25rem 1.5rem;
    }
    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-action:hover {
        transform: scale(1.1);
    }
    .search-box {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        border-radius: 10px;
        padding: 0.5rem 1rem;
    }
    .search-box::placeholder {
        color: rgba(255,255,255,0.7);
    }
    .search-box:focus {
        background: rgba(255,255,255,0.25);
        border-color: rgba(255,255,255,0.5);
        color: white;
        box-shadow: none;
    }
    .filter-select {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        border-radius: 10px;
        padding: 0.5rem 1rem;
    }
    .filter-select:focus {
        background: rgba(255,255,255,0.25);
        border-color: rgba(255,255,255,0.5);
        color: white;
        box-shadow: none;
    }
    .filter-select option {
        color: #000;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold">
                <i class="bi bi-currency-dollar text-success me-2"></i> Dívidas
            </h2>
            <p class="text-muted mb-0">{{ $dividas->total() }} dívida(s) registrada(s)</p>
        </div>
        <a href="{{ route('dividas.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i> Nova Dívida
        </a>
    </div>

    <div class="card card-modern">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 text-white">
                    <i class="bi bi-list me-2"></i> Lista de Dívidas
                </h5>
                <div class="d-flex gap-2 flex-wrap">
                    <form action="{{ route('dividas.index') }}" method="GET" class="d-flex" style="max-width: 300px;">
                        <input type="text" name="search" class="form-control search-box" 
                               placeholder="Buscar..." value="{{ $search }}"
                               style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: white;">
                        <button type="submit" class="btn btn-light btn-sm ms-2" style="border-radius: 8px;">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <select name="status" class="form-select filter-select" onchange="this.form.submit()" style="max-width: 200px;">
                        <option value=">Todos os status</option>
                        @foreach($statusOptions as $key => $label)
                            <option value="{{ $key }}" {{ $status == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
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
                                <th>Vencimento</th>
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
                                    <td class="text-muted">{{ Str::limit($divida->descricao, 40) }}</td>
                                    <td class="fw-bold" style="color: #198754;">R$ {{ number_format($divida->valor, 2, ',', '.') }}</td>
                                    <td class="text-muted">
                                        @if($divida->data_vencimento)
                                            {{ $divida->data_vencimento->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
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
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('dividas.show', $divida) }}" class="btn btn-action btn-outline-primary" title="Ver">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('dividas.edit', $divida) }}" class="btn btn-action btn-outline-secondary" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if($divida->status != 'pago')
                                                <form action="{{ route('dividas.marcar-pago', $divida) }}" method="POST" class="d-inline" onsubmit="return confirm('Marcar como pago?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-action btn-outline-success" title="Marcar Pago">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('dividas.destroy', $divida) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir esta dívida?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-action btn-outline-danger" title="Excluir">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
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
                    <p class="text-muted mt-3">
                        @if($search || $status)
                            Nenhuma dívida encontrada para os filtros aplicados
                        @else
                            Nenhuma dívida registrada
                        @endif
                    </p>
                    <a href="{{ route('dividas.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i> Cadastrar Dívida
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
