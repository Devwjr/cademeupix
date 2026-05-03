@extends('layouts.app')

@section('title', 'Enviar via WhatsApp - CadêMeuPix')

@push('scripts')
<script>
function copiarMensagem() {
    const mensagem = document.getElementById('mensagem-whatsapp').textContent;
    navigator.clipboard.writeText(mensagem).then(() => {
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check"></i> Copiado!';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-success');
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-primary');
        }, 2000);
    });
}

function abrirWhatsApp() {
    window.open('{{ $linkWhatsApp }}', '_blank');
}
</script>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #25D366; color: #fff;">
                    <h5 class="mb-0">
                        <i class="bi bi-whatsapp"></i> Enviar Cobrança via WhatsApp
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light border">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Cliente:</strong> {{ $cobranca->divida->cliente->nome }}</p>
                                <p class="mb-1"><strong>Telefone:</strong> {{ $cobranca->divida->cliente->telefone_formatado }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Valor:</strong></p>
                                <h4 class="mb-0" style="color: #198754;">R$ {{ number_format($cobranca->valor, 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Mensagem que será enviada:</label>
                        <div class="p-3 bg-light rounded border" id="mensagem-whatsapp" style="white-space: pre-wrap; font-family: inherit;">{{ $cobranca->mensagem_whatsapp }}</div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-outline-primary" onclick="copiarMensagem()">
                            <i class="bi bi-clipboard"></i> Copiar Mensagem
                        </button>
                        <button type="button" class="btn text-white" style="background-color: #25D366;" onclick="abrirWhatsApp()">
                            <i class="bi bi-whatsapp"></i> Abrir WhatsApp
                        </button>
                        <a href="{{ route('cobrancas.show', $cobranca) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                    </div>

                    <hr>

                    <div class="row text-center">
                        <div class="col-md-6">
                            <h6><i class="bi bi-qr-code"></i> QR Code Pix</h6>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($cobranca->pix_copia_cola) }}" 
                                 alt="QR Code" class="img-fluid rounded" style="max-width: 150px;">
                        </div>
                        <div class="col-md-6">
                            <h6><i class="bi bi-hash"></i> Chave Pix</h6>
                            <code class="d-block p-2 bg-light rounded">{{ $cobranca->chave_pix }}</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
