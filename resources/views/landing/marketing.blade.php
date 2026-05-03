@extends('layouts.app')

@push('styles')
<style>
    .marketing-hero {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        color: white;
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }
    .testimonial-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(25, 135, 84, 0.15);
    }
    .step-circle {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #198754, #20c997);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        margin: 0 auto 1rem;
    }
</style>
@endpush

@section('content')
<div class="marketing-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">O jeito mais fácil de gerenciar suas vendas fiadas</h1>
                <p class="lead mb-4 opacity-75">Junte-se a milhares de lojistas que já simplificaram suas cobranças com Pix e WhatsApp.</p>
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 py-3 fw-bold" style="color: #198754;">
                    <i class="bi bi-rocket-takeoff me-2"></i> Começar Grátis
                </a>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <i class="bi bi-graph-up" style="font-size: 15rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        @foreach($steps as $step)
        <div class="col-md-4 text-center">
            <div class="step-circle">{{ $step['number'] }}</div>
            <h5 class="fw-bold">{{ $step['title'] }}</h5>
            <p class="text-muted">{{ $step['desc'] }}</p>
        </div>
        @endforeach
    </div>
</div>

<div class="bg-light py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">O que dizem nossos clientes</h2>
        <div class="row g-4">
            @foreach($testimonials as $testimonial)
            <div class="col-md-4">
                <div class="card testimonial-card shadow-sm h-100 p-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="bi bi-quote text-success" style="font-size: 2rem;"></i>
                        </div>
                        <p class="text-muted mb-4">"{{ $testimonial['text'] }}"</p>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; font-weight: 700;">
                                {{ $testimonial['initials'] }}
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $testimonial['name'] }}</h6>
                                <small class="text-muted">{{ $testimonial['business'] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-3 text-center">
            <h3 class="fw-bold text-success">1000+</h3>
            <p class="text-muted">Usuários ativos</p>
        </div>
        <div class="col-md-3 text-center">
            <h3 class="fw-bold text-success">R$ 2M+</h3>
            <p class="text-muted">Em cobranças</p>
        </div>
        <div class="col-md-3 text-center">
            <h3 class="fw-bold text-success">99%</h3>
            <p class="text-muted">Satisfação</p>
        </div>
        <div class="col-md-3 text-center">
            <h3 class="fw-bold text-success">24/7</h3>
            <p class="text-muted">Suporte</p>
        </div>
    </div>
</div>

<div class="container text-center mb-5">
    <h2 class="fw-bold mb-3">Pronto para começar?</h2>
    <p class="lead text-muted mb-4">Cadastre-se agora e comece a usar em minutos</p>
    <a href="{{ route('register') }}" class="btn btn-success btn-lg px-5 py-3 fw-bold">
        <i class="bi bi-person-plus me-2"></i> Criar Conta Grátis
    </a>
</div>
@endsection
