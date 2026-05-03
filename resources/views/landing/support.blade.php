@extends('layouts.app')

@push('styles')
<style>
    .support-hero {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        color: white;
        padding: 80px 0;
        border-radius: 0 0 24px 24px;
    }
    .faq-card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s;
        overflow: hidden;
    }
    .faq-card:hover {
        box-shadow: 0 8px 24px rgba(25, 135, 84, 0.15);
    }
    .faq-header {
        background: #198754;
        color: white;
        border-radius: 12px 12px 0 0;
        padding: 1rem 1.25rem;
        font-weight: 600;
    }
    .contact-card {
        border: none;
        border-radius: 16px;
        background: linear-gradient(135deg, #f8fff9, #e8f5e9);
        overflow: hidden;
    }
    .icon-wrapper {
        width: 48px;
        height: 48px;
        background: #198754;
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
</style>
@endpush

@section('content')
<div class="support-hero mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <i class="bi bi-headset" style="font-size: 4rem; opacity: 0.3;"></i>
                <h1 class="fw-bold mt-3 mb-3">Central de Suporte</h1>
                <p class="lead opacity-75">Estamos aqui para ajudar você a aproveitar ao máximo o CadêMeuPix</p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row g-4">
        <div class="col-lg-8">
            <h3 class="fw-bold mb-4">Perguntas Frequentes</h3>
            
            <div class="accordion mb-5" id="faqAccordion">
                <div class="accordion-item faq-card mb-3 border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button faq-header" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            <i class="bi bi-question-circle me-2"></i> Como cadastrar um novo cliente?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>Para cadastrar um novo cliente, acesse o menu <strong>Clientes</strong> e clique no botão <span class="badge bg-success">Novo Cliente</span>. Preencha os dados obrigatórios como nome, telefone e CPF (opcional).</p>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item faq-card mb-3 border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed faq-header" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            <i class="bi bi-currency-dollar me-2"></i> Como registrar uma dívida?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>No menu <strong>Dívidas</strong>, clique em <span class="badge bg-success">Nova Dívida</span>. Selecione o cliente, informe a descrição, valor e data de vencimento. O sistema gera automaticamente a cobrança.</p>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item faq-card mb-3 border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed faq-header" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            <i class="bi bi-qr-code me-2"></i> Como funciona o Pix Copia e Cola?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>Após criar uma dívida, você pode gerar uma cobrança Pix. O sistema cria automaticamente um QR Code e o código Pix Copia e Cola. Basta compartilhar com o cliente via WhatsApp ou copiar o código.</p>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item faq-card mb-3 border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed faq-header" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            <i class="bi bi-whatsapp me-2"></i> Como enviar cobranças pelo WhatsApp?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>Na tela de uma cobrança, clique no botão <span class="badge bg-success"><i class="bi bi-whatsapp"></i> Enviar via WhatsApp</span>. Uma mensagem formatada será gerada com os detalhes da dívida e link de pagamento (se houver).</p>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item faq-card mb-3 border-0 shadow-sm">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed faq-header" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            <i class="bi bi-calendar-x me-2"></i> O que acontece com dívidas vencidas?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <p>O sistema verifica automaticamente as dívidas vencidas diariamente. Quando uma dívida vence, o status é atualizado para "Vencida" e você recebe uma notificação por e-mail para tomar as providências.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <h3 class="fw-bold mb-4 mt-5">Guias Rápidos</h3>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper me-3">
                                    <i class="bi bi-play-circle"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Primeiros Passos</h5>
                            </div>
                            <p class="text-muted small mb-0">Aprenda a configurar sua conta e começar a usar em 5 minutos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper me-3">
                                    <i class="bi bi-phone"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">WhatsApp Business</h5>
                            </div>
                            <p class="text-muted small mb-0">Como integrar com seu WhatsApp Business API.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper me-3">
                                    <i class="bi bi-bar-chart"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Relatórios</h5>
                            </div>
                            <p class="text-muted small mb-0">Como gerar e interpretar relatórios financeiros.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper me-3">
                                    <i class="bi bi-gear"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Configurações</h5>
                            </div>
                            <p class="text-muted small mb-0">Personalize sua conta e preferências.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card contact-card border-0 shadow-sm p-4 mb-4">
                <h4 class="fw-bold mb-4">
                    <i class="bi bi-chat-dots text-success me-2"></i> Fale Conosco
                </h4>
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper me-3">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">E-mail</h6>
                            <p class="text-muted small mb-0">suporte@cademeupix.com</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper me-3">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">WhatsApp</h6>
                            <p class="text-muted small mb-0">(11) 99999-9999</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper me-3">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Horário de Atendimento</h6>
                            <p class="text-muted small mb-0">Segunda à Sexta, 9h às 18h</p>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-success">
                        <i class="bi bi-whatsapp me-2"></i> Chamar no WhatsApp
                    </a>
                    <a href="#" class="btn btn-outline-success">
                        <i class="bi bi-envelope me-2"></i> Enviar E-mail
                    </a>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-lightbulb me-2"></i> Dica do Dia</h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-0">Use o filtro de status no Dashboard para visualizar rapidamente as dívidas pendentes, pagas ou vencidas.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
