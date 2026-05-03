@extends('layouts.app')

@section('title', 'Nova Senha - CadêMeuPix')

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
                        <p class="text-muted">Definir nova senha</p>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $email) }}" required readonly>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required autofocus>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn w-100 mb-3" style="background-color: #198754; color: #000;">
                            <i class="bi bi-check-circle"></i> Redefinir Senha
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
