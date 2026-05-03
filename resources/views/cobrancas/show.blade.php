@extends('layouts.app')

@section('title', 'Cobrança - CadêMeuPix')

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
            <i class="bi bi-qr-code"></i> Cobrança
        </h2>
        <div>
            <a href="{{ route('dividas.show', $cobranca->divida) }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
            @if($cobranca->status === 'pendente')
                <form action="{{ route('cobrancas.marcar-pago', $cobranca) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Marcar cobrança como paga?')">
                        <i class="bi bi-check-circle"></i> Marcar Pago
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Detalhes da Cobrança</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Cliente:</div>
                        <div class="col-8">{{ $cobranca->divida->cliente->nome }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Descrição:</div>
                        <div class="col-8">{{ $cobranca->divida->descricao }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Valor:</div>
                        <div class="col-8">
                            <strong class="fs-5" style="color: #198754;">R$ {{ number_format($cobranca->valor, 2, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Chave Pix:</div>
                        <div class="col-8">
                            <code>{{ $cobranca->chave_pix }}</code>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-muted">Status:</div>
                        <div class="col-8">
                            @switch($cobranca->status)
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
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if($cobranca->status === 'pendente')
                <div class="card border-dark">
                    <div class="card-header text-white" style="background-color: #000;">
                        <h5 class="mb-0">
                            <i class="bi bi-qr-code"></i> QR Code Pix
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($cobranca->pix_copia_cola) }}" 
                                 alt="QR Code" class="img-fluid" style="max-width: 200px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Chave Pix:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $cobranca->chave_pix }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="navigator.clipboard.writeText('{{ $cobranca->chave_pix }}')">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Pix Copia e Cola:</label>
                            <div class="input-group">
                                <textarea class="form-control" id="pix-copia-cola" rows="3" readonly>{{ $cobranca->pix_copia_cola }}</textarea>
                                <button class="btn btn-outline-secondary" type="button" onclick="copiarPix()">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </div>

                        @if($cobranca->link_pagamento)
                            <div class="mb-3">
                                <label class="form-label text-muted">Link de Pagamento:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $cobranca->link_pagamento }}" readonly>
                                    <a href="{{ $cobranca->link_pagamento }}" target="_blank" class="btn btn-outline-primary">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endif

                        <hr>

                        <a href="{{ $cobranca->link_whatsapp }}" target="_blank" class="btn w-100" style="background-color: #198754; color: #000;">
                            <i class="bi bi-whatsapp"></i> Enviar via WhatsApp
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
