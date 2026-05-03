@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card shadow text-center">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="fw-bold text-success mb-3">Assinatura Realizada!</h2>
                    <p class="text-muted mb-4">Sua assinatura foi processada com sucesso. Agora você já pode aproveitar todos os recursos do plano selecionado.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg">
                            <i class="bi bi-speedometer2 me-2"></i> Ir para o Dashboard
                        </a>
                        <a href="{{ route('pricing') }}" class="btn btn-outline-secondary">
                            Ver outros planos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
