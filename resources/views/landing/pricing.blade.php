@extends('layouts.app')

@push('styles')
<style>
    .pricing-hero {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        color: white;
        padding: 80px 0;
        border-radius: 0 0 24px 24px;
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
</style>
@endpush

@section('content')
<div class="pricing-hero mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="fw-bold mt-3 mb-3">Planos e Preços</h1>
                <p class="lead opacity-75">Escolha o plano ideal para o seu negócio</p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row g-4 justify-content-center">
        @foreach($plans as $key => $plan)
        <div class="col-md-4">
            <div class="card pricing-card shadow-sm h-100 {{ $plan['featured'] ? 'featured' : '' }}">
                <div class="pricing-header">
                    <h4 class="fw-bold mb-1">{{ $plan['name'] }}</h4>
                    <p class="mb-0 opacity-75">{{ $plan['description'] }}</p>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <span class="price">{{ $plan['price'] }}</span>
                        <p class="text-muted mt-2">{{ $plan['period'] }}</p>
                    </div>
                    <ul class="list-unstyled mb-4">
                        @foreach($plan['features'] as $feature)
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                    @if($key === 'basic')
                    <a href="{{ route('register') }}" class="btn btn-outline-success w-100">Começar Grátis</a>
                    @else
                    <form action="{{ route('subscription.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $key }}">
                        <button type="submit" class="btn btn-success w-100">
                            Assinar Agora
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-5 pt-5 border-top">
        <h3 class="fw-bold mb-3">Perguntas Frequentes sobre Planos</h3>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="accordion" id="pricingFaq">
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            Posso cancelar minha assinatura a qualquer momento?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#pricingFaq">
                        <div class="accordion-body">
                            Sim, você pode cancelar sua assinatura a qualquer momento sem taxas adicionais.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Existe período de teste gratuito?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                        <div class="accordion-body">
                            O plano Básico é gratuito para sempre. Para os planos pagos, oferecemos 7 dias de teste grátis.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Como funciona o pagamento via Stripe?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#pricingFaq">
                        <div class="accordion-body">
                            Utilizamos o Stripe para processar pagamentos com segurança. Aceitamos cartões de crédito, débito e Pix.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
