<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;

class LandingController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => 1000,
            'volume' => 'R$ 2M+',
            'satisfaction' => '99%',
        ];

        return view('landing.index', compact('stats'));
    }

    public function pricing()
    {
        $plans = [
            'basic' => [
                'name' => 'Básico',
                'price' => 'Grátis',
                'period' => 'Para sempre',
                'description' => 'Para pequenos lojistas',
                'features' => [
                    'Até 50 clientes',
                    'Até 100 dívidas/mês',
                    'Cobrança via Pix',
                    'WhatsApp ilimitado',
                    'Suporte via e-mail',
                ],
                'stripe_price_id' => null,
                'featured' => false,
            ],
            'professional' => [
                'name' => 'Profissional',
                'price' => 'R$ 9,90',
                'period' => 'por mês',
                'description' => 'Para médias empresas',
                'features' => [
                    'Clientes ilimitados',
                    'Dívidas ilimitadas',
                    'Cobrança via Pix',
                    'WhatsApp ilimitado',
                    'Relatórios avançados',
                    'Suporte prioritário',
                    'API de integração',
                ],
                'stripe_price_id' => env('STRIPE_PRICE_PROFESSIONAL'),
                'featured' => true,
            ],
            'enterprise' => [
                'name' => 'Enterprise',
                'price' => 'R$ 29,90',
                'period' => 'por mês',
                'description' => 'Para grandes redes',
                'features' => [
                    'Tudo do Profissional',
                    'Múltiplos usuários',
                    'API completa',
                    'Suporte prioritário 24/7',
                    'Personalização completa',
                    'Gerente de conta dedicado',
                ],
                'stripe_price_id' => env('STRIPE_PRICE_ENTERPRISE'),
                'featured' => false,
            ],
        ];

        return view('landing.pricing', compact('plans'));
    }

    public function support()
    {
        return view('landing.support');
    }

    public function marketing()
    {
        $testimonials = [
            [
                'name' => 'Maria Silva',
                'business' => 'Mercearia Silva',
                'text' => 'O CadêMeuPix revolucionou minha forma de gerenciar fiado. Antes eu tinha um caderno, hoje tenho tudo organizado no celular!',
                'initials' => 'MS',
            ],
            [
                'name' => 'João Santos',
                'business' => 'Padaria Santos',
                'text' => 'Recuperei mais de R$ 3.000,00 em dívidas que eu já tinha dado como perdidas. O sistema de cobrança via WhatsApp é incrível!',
                'initials' => 'JS',
            ],
            [
                'name' => 'Ana Costa',
                'business' => 'Boutique Ana',
                'text' => 'Meus clientes adoram a praticidade do Pix. Em 3 meses, minhas vendas a prazo aumentaram 40%!',
                'initials' => 'AC',
            ],
        ];

        $steps = [
            ['number' => '1', 'title' => 'Cadastre-se', 'desc' => 'Crie sua conta gratuitamente em menos de 1 minuto.'],
            ['number' => '2', 'title' => 'Adicione Clientes', 'desc' => 'Cadastre seus clientes e suas dívidas de forma simples.'],
            ['number' => '3', 'title' => 'Cobre e Receba', 'desc' => 'Gere cobranças via Pix e WhatsApp instantaneamente.'],
        ];

        return view('landing.marketing', compact('testimonials', 'steps'));
    }

    public function createSubscription(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:professional,enterprise',
        ]);

        if (! env('STRIPE_KEY') || ! env('STRIPE_SECRET')) {
            return redirect()->back()->with('error', 'Stripe não configurado. Entre em contato.');
        }

        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $priceId = $request->plan === 'professional'
            ? env('STRIPE_PRICE_PROFESSIONAL')
            : env('STRIPE_PRICE_ENTERPRISE');

        if (! $priceId) {
            return redirect()->back()->with('error', 'Plano não configurado no Stripe.');
        }

        try {
            $checkoutSession = $stripe->checkout->sessions->create([
                'success_url' => route('subscription.success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('subscription.cancel'),
                'mode' => 'subscription',
                'line_items' => [[
                    'price' => $priceId,
                    'quantity' => 1,
                ]],
                'metadata' => [
                    'plan' => $request->plan,
                ],
            ]);

            return redirect($checkoutSession->url);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao processar pagamento: '.$e->getMessage());
        }
    }

    public function subscriptionSuccess(Request $request)
    {
        return view('landing.subscription-success');
    }

    public function subscriptionCancel()
    {
        return redirect()->route('pricing')->with('error', 'Assinatura cancelada.');
    }
}
