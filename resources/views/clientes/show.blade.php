@extends('layouts.app')

@section('title', $cliente->nome . ' - CadêMeuPix')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-person"></i> {{ $cliente->nome }}
        </h2>
        <div>
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash"></i> Excluir
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Dados do Cliente</h5>
                </div>
                <div class="card-body">
                    <p><strong><i class="bi bi-telephone"></i> Telefone:</strong><br>{{ $cliente->telefone }}</p>
                    <p><strong><i class="bi bi-credit-card"></i> CPF:</strong><br>{{ $cliente->cpf ?? 'Não informado' }}</p>
                    <p><strong><i class="bi bi-calendar"></i> Cadastrado em:</strong><br>{{ $cliente->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="card text-white" style="background-color: #000;">
                <div class="card-body text-center">
                    <h6 class="card-title text-success">Total Pendente</h6>
                    <h3 class="mb-0 text-success">R$ {{ number_format($cliente->total_dividas, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-currency-dollar"></i> Dívidas
                    </h5>
                    <a href="{{ route('dividas.create', ['cliente_id' => $cliente->id]) }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle"></i> Nova Dívida
                    </a>
                </div>
                <div class="card-body">
                    @if($cliente->dividas->isEmpty())
                        <p class="text-muted text-center mb-0">
                            <i class="bi bi-inbox"></i> Nenhuma dívida registrada
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Valor</th>
                                        <th>Vencimento</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cliente->dividas as $divida)
                                    <tr>
                                        <td>{{ Str::limit($divida->descricao, 30) }}</td>
                                        <td>R$ {{ number_format($divida->valor, 2, ',', '.') }}</td>
                                        <td>
                                            @if($divida->data_vencimento)
                                                {{ $divida->data_vencimento->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @switch($divida->status)
                                                @case('pendente')
                                                    <span class="badge" style="background-color: #198754; color: #000;">Pendente</span>
                                                    @break
                                                @case('pago')
                                                    <span class="badge bg-success">Pago</span>
                                                    @break
                                                @case('vencido')
                                                    <span class="badge bg-danger">Vencido</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('dividas.show', $divida) }}" class="btn btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
