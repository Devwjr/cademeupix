@extends('layouts.app')

@section('title', 'Recuperar Senha - CadêMeuPix')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold" style="color: #198754;">
                            <i class="bi bi-wallet2"></i> CadêMeuPix
                        </h1>
                        <p class="text-muted">Recuperar senha</p>
                    </div>

                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn w-100 mb-3" style="background-color: #198754; color: #000;">
                            <i class="bi bi-send"></i> Enviar link
                        </button>
                    </form>

                    <p class="text-center mb-0">
                        Lembrou a senha? <a href="{{ route('login') }}">Voltar ao login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
