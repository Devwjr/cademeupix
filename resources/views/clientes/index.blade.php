@extends('layouts.app')

@section('title', 'Clientes - CadêMeuPix')

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
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold">
                <i class="bi bi-people text-success me-2"></i> Clientes
            </h2>
            <p class="text-muted mb-0">{{ $clientes->total() }} cliente(s) cadastrado(s)</p>
        </div>
        <a href="{{ route('clientes.create') }}" class="btn btn-success">
            <i class="bi bi-person-plus me-2"></i> Novo Cliente
        </a>
    </div>

    <div class="card card-modern">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">
                    <i class="bi bi-list me-2"></i> Lista de Clientes
                </h5>
                <form action="{{ route('clientes.index') }}" method="GET" class="d-flex" style="max-width: 400px;">
                    <input type="text" name="search" class="form-control search-box" 
                           placeholder="Buscar cliente..." value="{{ $search }}"
                           style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: white;">
                    <button type="submit" class="btn btn-light btn-sm ms-2" style="border-radius: 8px;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            @if($clientes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>CPF</th>
                                <th>Dívidas</th>
                                <th>Total Devedor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente)
                                <tr>
                                    <td>
                                        <a href="{{ route('clientes.show', $cliente) }}" class="text-decoration-none fw-semibold" style="color: #198754;">
                                            {{ $cliente->nome }}
                                        </a>
                                    </td>
                                    <td class="text-muted">{{ $cliente->telefone_formatado }}</td>
                                    <td class="text-muted">{{ $cliente->cpf ?? '-' }}</td>
                                    <td>
                                        <span class="badge-modern" style="background-color: rgba(25, 135, 84, 0.15); color: #198754;">
                                            {{ $cliente->dividas->count() }}
                                        </span>
                                    </td>
                                    <td class="fw-bold" style="color: #198754;">R$ {{ number_format($cliente->total_dividas, 2, ',', '.') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-action btn-outline-primary" title="Ver">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-action btn-outline-secondary" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('dividas.create', ['cliente_id' => $cliente->id]) }}" class="btn btn-action btn-outline-success" title="Nova Dívida">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este cliente?')">
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
                    {{ $clientes->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-people" style="font-size: 3rem; color: #198754; opacity: 0.5;"></i>
                    <p class="text-muted mt-3">
                        @if($search)
                            Nenhum cliente encontrado para "{{ $search }}"
                        @else
                            Nenhum cliente cadastrado
                        @endif
                    </p>
                    <a href="{{ route('clientes.create') }}" class="btn btn-success">
                        <i class="bi bi-person-plus me-2"></i> Cadastrar Cliente
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
