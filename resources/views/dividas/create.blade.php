@extends('layouts.app')

@section('title', 'Nova Dívida - CadêMeuPix')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle"></i> Nova Dívida
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dividas.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="cliente_id" class="form-label">Cliente *</label>
                            <select class="form-select @error('cliente_id') is-invalid @enderror" 
                                    id="cliente_id" name="cliente_id" required>
                                <option value=">Selecione um cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $clienteId) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nome }} - {{ $cliente->telefone }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <a href="{{ route('clientes.create') }}" target="_blank">
                                    <i class="bi bi-plus-circle"></i> Cadastrar novo cliente
                                </a>
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição *</label>
                            <input type="text" class="form-control @error('descricao') is-invalid @enderror"
                                   id="descricao" name="descricao" value="{{ old('descricao') }}" 
                                   placeholder="Ex: Camisa social azul" required>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="valor" class="form-label">Valor *</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control @error('valor') is-invalid @enderror"
                                       id="valor" name="valor" value="{{ old('valor') }}" 
                                       step="0.01" min="0.01" required>
                                @error('valor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="data_venda" class="form-label">Data da Venda *</label>
                                    <input type="date" class="form-control @error('data_venda') is-invalid @enderror"
                                           id="data_venda" name="data_venda" value="{{ old('data_venda', date('Y-m-d')) }}" required>
                                    @error('data_venda')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                                    <input type="date" class="form-control @error('data_vencimento') is-invalid @enderror"
                                           id="data_vencimento" name="data_vencimento" value="{{ old('data_vencimento') }}">
                                    @error('data_vencimento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Registrar
                            </button>
                            <a href="{{ route('dividas.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
