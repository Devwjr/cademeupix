<?php $__env->startPush('styles'); ?>
<style>
    .hero-section {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        color: white;
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
        opacity: 0.6;
    }
    .hero-content {
        position: relative;
        z-index: 1;
    }
    .feature-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(25, 135, 84, 0.15);
    }
    .feature-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #198754, #20c997);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        margin-bottom: 1rem;
    }
    .pricing-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .pricing-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 32px rgba(0,0,0,0.1);
    }
    .pricing-card.featured {
        border: 3px solid #198754;
        position: relative;
    }
    .pricing-card.featured::before {
        content: 'MAIS POPULAR';
        position: absolute;
        top: 20px;
        right: -35px;
        background: #198754;
        color: white;
        padding: 5px 40px;
        font-size: 0.75rem;
        font-weight: 600;
        transform: rotate(45deg);
    }
    .pricing-header {
        background: linear-gradient(135deg, #198754, #20c997);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    .price {
        font-size: 3rem;
        font-weight: 700;
        line-height: 1;
    }
    .cta-section {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        color: white;
        padding: 80px 0;
        border-radius: 24px;
        margin: 60px 0;
    }
    .step-number {
        width: 48px;
        height: 48px;
        background: #198754;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        margin: 0 auto 1rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="hero-section">
    <div class="container hero-content">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Gerencie suas vendas fiadas com facilidade</h1>
                <p class="lead mb-4 opacity-75">O CadêMeuPix ajuda você a controlar dívidas, gerar cobranças via Pix e enviar lembretes pelo WhatsApp. Simples, rápido e eficiente.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-lg px-4 py-3 fw-bold" style="color: #198754;">
                        <i class="bi bi-person-plus me-2"></i> Começar Agora
                    </a>
                    <a href="<?php echo e(route('pricing')); ?>" class="btn btn-outline-light btn-lg px-4 py-3">
                        <i class="bi bi-tag me-2"></i> Ver Planos
                    </a>
                </div>
                <div class="d-flex gap-4 mt-5">
                    <div>
                        <h3 class="fw-bold mb-0">1000+</h3>
                        <small class="opacity-75">Usuários ativos</small>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">R$ 2M+</h3>
                        <small class="opacity-75">Em cobranças</small>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">99%</h3>
                        <small class="opacity-75">Satisfação</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="text-center">
                    <i class="bi bi-wallet2" style="font-size: 15rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row g-4 mt-5">
        <div class="col-md-4">
            <div class="card feature-card h-100 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-qr-code"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Pix Instantâneo</h5>
                    <p class="text-muted">Gere QR Codes e Pix Copia e Cola automaticamente para agilizar suas cobranças.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card h-100 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-whatsapp"></i>
                    </div>
                    <h5 class="fw-bold mb-3">WhatsApp Integrado</h5>
                    <p class="text-muted">Envie cobranças diretamente pelo WhatsApp com mensagens personalizadas.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card h-100 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Dashboard Completo</h5>
                    <p class="text-muted">Acompanhe dívidas pendentes, vencidas e visualize seus maiores devedores.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 pt-5">
        <div class="col-12 text-center mb-5">
            <h2 class="fw-bold mb-3">Como funciona</h2>
            <p class="text-muted lead">Comece a usar em apenas 3 passos simples</p>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="text-center">
                <div class="step-number">1</div>
                <h5 class="fw-bold">Cadastre-se</h5>
                <p class="text-muted">Crie sua conta gratuitamente em menos de 1 minuto.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <div class="step-number">2</div>
                <h5 class="fw-bold">Adicione Clientes</h5>
                <p class="text-muted">Cadastre seus clientes e suas dívidas de forma simples.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <div class="step-number">3</div>
                <h5 class="fw-bold">Cobre e Receba</h5>
                <p class="text-muted">Gere cobranças via Pix e WhatsApp instantaneamente.</p>
            </div>
        </div>
    </div>

    <div class="cta-section text-center mt-5">
        <h2 class="fw-bold mb-3">Pronto para simplificar suas cobranças?</h2>
        <p class="lead mb-4 opacity-75">Junte-se a milhares de lojistas que já usam o CadêMeuPix</p>
        <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-lg px-5 py-3 fw-bold" style="color: #198754;">
            <i class="bi bi-rocket-takeoff me-2"></i> Começar Grátis
        </a>
    </div>

    <div class="row mt-5 pt-5">
        <div class="col-12 text-center mb-5">
            <h2 class="fw-bold mb-3">Planos e Preços</h2>
            <p class="text-muted lead">Escolha o plano ideal para o seu negócio</p>
        </div>
    </div>
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="card pricing-card shadow-sm h-100">
                <div class="pricing-header">
                    <h4 class="fw-bold mb-1">Básico</h4>
                    <p class="mb-0 opacity-75">Para pequenos lojistas</p>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <span class="price">Grátis</span>
                        <p class="text-muted mt-2">Para sempre</p>
                    </div>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Até 50 clientes</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Até 100 dívidas/mês</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Cobrança via Pix</li>
                        <li class="mb-2"><i class="bi bi-x-circle text-muted me-2"></i> <span class="text-muted">WhatsApp ilimitado</span></li>
                    </ul>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-success w-100">Começar</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card pricing-card featured shadow-sm h-100">
                <div class="pricing-header">
                    <h4 class="fw-bold mb-1">Profissional</h4>
                    <p class="mb-0 opacity-75">Para médias empresas</p>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <span class="price">R$ 9,90</span>
                        <p class="text-muted mt-2">por mês</p>
                    </div>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Clientes ilimitados</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Dívidas ilimitadas</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Cobrança via Pix</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> WhatsApp ilimitado</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Relatórios avançados</li>
                    </ul>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-success w-100">Assinar Agora</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card pricing-card shadow-sm h-100">
                <div class="pricing-header">
                    <h4 class="fw-bold mb-1">Enterprise</h4>
                    <p class="mb-0 opacity-75">Para grandes redes</p>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <span class="price">R$ 29,90</span>
                        <p class="text-muted mt-2">por mês</p>
                    </div>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Tudo do Profissional</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Múltiplos usuários</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> API completa</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Suporte prioritário</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Personalização</li>
                    </ul>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-success w-100">Falar com Vendas</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-light mt-5 py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <h5 class="fw-bold text-success">CadêMeuPix</h5>
                <p class="text-muted small">A melhor solução para gestão de vendas fiadas e cobranças via Pix e WhatsApp.</p>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Produto</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted small text-decoration-none">Funcionalidades</a></li>
                    <li><a href="<?php echo e(route('pricing')); ?>" class="text-muted small text-decoration-none">Planos</a></li>
                    <li><a href="#" class="text-muted small text-decoration-none">Atualizações</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Suporte</h6>
                <ul class="list-unstyled">
                    <li><a href="<?php echo e(route('support')); ?>" class="text-muted small text-decoration-none">Central de Ajuda</a></li>
                    <li><a href="#" class="text-muted small text-decoration-none">Contato</a></li>
                    <li><a href="#" class="text-muted small text-decoration-none">Status</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Legal</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted small text-decoration-none">Privacidade</a></li>
                    <li><a href="#" class="text-muted small text-decoration-none">Termos</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <small class="text-muted">© 2026 CadêMeuPix. Todos os direitos reservados.</small>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/wesley/cadeMeuPix/resources/views/landing/index.blade.php ENDPATH**/ ?>