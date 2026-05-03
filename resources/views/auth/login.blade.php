@extends('layouts.app')

@section('title', 'Login - CadêMeuPix')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="bi bi-wallet2 text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h1 class="h3 fw-bold text-success">CadêMeuPix</h1>
                        <p class="text-muted">Gerencie suas vendas fiadas com facilidade</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Lembrar-me</label>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mb-3 py-2">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Entrar
                        </button>
                    </form>

                    <div class="text-center">
                        <a href="{{ route('password.request') }}" class="text-muted small text-decoration-underline">
                            Esqueceu a senha?
                        </a>
                    </div>

                    <hr class="my-4">

                    <p class="text-center mb-0">
                        Não tem conta? <a href="{{ route('register') }}" class="fw-semibold">Cadastre-se</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
