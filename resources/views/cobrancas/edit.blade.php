@extends('layouts.app')

@section('title', 'Editar Cobrança - CadêMeuPix')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil"></i> Editar Cobrança
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle"></i>
                        <strong>Dívida:</strong> {{ $cobranca->divida->descricao }}<br>
                        <strong>Cliente:</strong> {{ $cobranca->divida->cliente->nome }}<br>
                        <strong>Valor:</strong> R$ {{ number_format($cobranca->valor, 2, ',', '.') }}
                    </div>

                    <form method="POST" action="{{ route('cobrancas.update', $cobranca) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="link_pagamento" class="form-label">Link de Pagamento</label>
                            <input type="url" class="form-control @error('link_pagamento') is-invalid @enderror"
                                   id="link_pagamento" name="link_pagamento" value="{{ old('link_pagamento', $cobranca->link_pagamento) }}"
                                   placeholder="https://pagamento.exemplo.com/...">
                            @error('link_pagamento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Adicione um link de pagamento (Mercado Pago, PagSeguro, etc)
                            </small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Salvar
                            </button>
                            <a href="{{ route('cobrancas.show', $cobranca) }}" class="btn btn-secondary">
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
