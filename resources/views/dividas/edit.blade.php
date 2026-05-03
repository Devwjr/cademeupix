@extends('layouts.app')

@section('title', 'Editar Dívida - CadêMeuPix')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil"></i> Editar Dívida
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dividas.update', $divida) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="cliente_id" class="form-label">Cliente *</label>
                            <select class="form-select @error('cliente_id') is-invalid @enderror" 
                                    id="cliente_id" name="cliente_id" required>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $divida->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nome }} - {{ $cliente->telefone }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição *</label>
                            <input type="text" class="form-control @error('descricao') is-invalid @enderror"
                                   id="descricao" name="descricao" value="{{ old('descricao', $divida->descricao) }}" required>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="valor" class="form-label">Valor *</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="number" class="form-control @error('valor') is-invalid @enderror"
                                       id="valor" name="valor" value="{{ old('valor', $divida->valor) }}" 
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
                                           id="data_venda" name="data_venda" value="{{ old('data_venda', $divida->data_venda->format('Y-m-d')) }}" required>
                                    @error('data_venda')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                                    <input type="date" class="form-control @error('data_vencimento') is-invalid @enderror"
                                           id="data_vencimento" name="data_vencimento" 
                                           value="{{ old('data_vencimento', $divida->data_vencimento?->format('Y-m-d')) }}">
                                    @error('data_vencimento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Salvar
                            </button>
                            <a href="{{ route('dividas.show', $divida) }}" class="btn btn-secondary">
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
