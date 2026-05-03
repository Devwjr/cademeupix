@extends('layouts.app')

@section('title', 'Dívida - CadêMeuPix')

@push('scripts')
<script>
function copiarPix() {
    const pixCopiaCola = document.getElementById('pix-copia-cola').textContent;
    navigator.clipboard.writeText(pixCopiaCola).then(() => {
        alert('QR Code Pix copiado com sucesso!');
    });
}
</script>
@endpush

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-currency-dollar"></i> Detalhes da Dívida
        </h2>
        <div>
            @if(!$divida->cobranca && !$divida->isPago())
                <a href="{{ route('cobrancas.create', $divida) }}" class="btn btn-success">
                    <i class="bi bi-qr-code"></i> Gerar Cobrança
                </a>
            @endif
            @if(!$divida->isPago())
                <form action="{{ route('dividas.marcar-pago', $divida) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Marcar esta dívida como paga?')">
                        <i class="bi bi-check-circle"></i> Marcar como Pago
                    </button>
                </form>
            @endif
            <a href="{{ route('dividas.edit', $divida) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <form action="{{ route('dividas.destroy', $divida) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Tem certeza que deseja excluir esta dívida?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash"></i> Excluir
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informações da Dívida</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Cliente:</div>
                        <div class="col-8">
                            <a href="{{ route('clientes.show', $divida->cliente) }}">
                                {{ $divida->cliente->nome }}
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Telefone:</div>
                        <div class="col-8">{{ $divida->cliente->telefone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Descrição:</div>
                        <div class="col-8">{{ $divida->descricao }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Valor:</div>
                        <div class="col-8">
                            <strong class="text-danger fs-5">R$ {{ number_format($divida->valor, 2, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Data da Venda:</div>
                        <div class="col-8">{{ $divida->data_venda->format('d/m/Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Vencimento:</div>
                        <div class="col-8">
                            @if($divida->data_vencimento)
                                {{ $divida->data_vencimento->format('d/m/Y') }}
                            @else
                                Não definido
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-muted">Status:</div>
                        <div class="col-8">
                            @switch($divida->status)
                                @case('pendente')
                                    <span class="badge bg-success text-dark">Pendente</span>
                                    @break
                                @case('pago')
                                    <span class="badge bg-success">Pago</span>
                                    @break
                                @case('vencido')
                                    <span class="badge bg-danger">Vencido</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if($divida->cobranca)
            <div class="card border-dark mb-4">
                <div class="card-header text-white" style="background-color: #000;">
                    <h5 class="mb-0">
                        <i class="bi bi-qr-code"></i> Cobrança Pix
                    </h5>
                </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Valor:</span>
                                <strong class="fs-4" style="color: #198754;">R$ {{ number_format($divida->cobranca->valor, 2, ',', '.') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Status:</span>
                                @switch($divida->cobranca->status)
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
                            </div>
                        </div>

                        @if($divida->cobranca->status === 'pendente')
                            <hr>
                            <div class="mb-3">
                                <label class="form-label text-muted">QR Code Pix:</label>
                                <div class="text-center p-3 bg-light rounded">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($divida->cobranca->pix_copia_cola) }}" 
                                         alt="QR Code" class="img-fluid" style="max-width: 200px;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Chave Pix:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $divida->cobranca->chave_pix }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="navigator.clipboard.writeText('{{ $divida->cobranca->chave_pix }}')">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Pix Copia e Cola:</label>
                                <div class="input-group">
                                    <textarea class="form-control" id="pix-copia-cola" rows="2" readonly>{{ $divida->cobranca->pix_copia_cola }}</textarea>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copiarPix()">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </div>
                            @if($divida->cobranca->link_pagamento)
                                <div class="mb-3">
                                    <label class="form-label text-muted">Link de Pagamento:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $divida->cobranca->link_pagamento }}" readonly>
                                        <a href="{{ $divida->cobranca->link_pagamento }}" target="_blank" class="btn btn-outline-primary">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <a href="{{ $divida->cobranca->link_whatsapp }}" target="_blank" class="btn w-100" style="background-color: #198754; color: #000;">
                                <i class="bi bi-whatsapp"></i> Enviar via WhatsApp
                            </a>
                        @endif
                    </div>
                </div>
            @else
                @if(!$divida->isPago())
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-qr-code fs-1 text-muted"></i>
                            <p class="text-muted mt-2">Esta dívida ainda não possui cobrança.</p>
                            <a href="{{ route('cobrancas.create', $divida) }}" class="btn btn-success">
                                <i class="bi bi-qr-code"></i> Gerar Cobrança
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
