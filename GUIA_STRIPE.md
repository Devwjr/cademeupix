# Guia de Configuração do Stripe - CadêMeuPix

## Passo a Passo para Receber Pagamentos

### 1. Criar Conta no Stripe

1. Acesse: https://stripe.com/br
2. Clique em "Começar" e crie sua conta
3. Confirme seu e-mail e ative sua conta

### 2. Configurar Dados Bancários (Receber Dinheiro)

1. No Dashboard do Stripe, vá em **Configurações** (Settings)
2. Clique em **Dados Bancários** (Bank accounts)
3. Adicione sua conta bancária brasileira:
   - Titular da conta
   - Banco
   - Agência e Conta
   - Tipo de conta (Pessoa Física ou Jurídica)

> ⚠️ **Importante**: O dinheiro das assinaturas será depositado nesta conta automaticamente pelo Stripe.

### 3. Obter as Chaves de API

1. No Dashboard, vá em **Desenvolvedores** (Developers) > **Chaves de API** (API keys)
2. Copie as chaves:
   - **Chave publicável** (começa com `pk_test_` ou `pk_live_`)
   - **Chave secreta** (começa com `sk_test_` ou `sk_live_`)

### 4. Criar os Produtos e Preços

1. Vá em **Produtos** (Products) no menu lateral
2. Clique em **Adicionar produto** (Add product)

**Plano Profissional:**
- Nome: `CadêMeuPix Profissional`
- Descrição: `Para médias empresas`
- Preço: `R$ 9,90` por `mês`
- Após criar, copie o **Price ID** (ex: `price_123abc...`)

**Plano Enterprise:**
- Nome: `CadêMeuPix Enterprise`
- Descrição: `Para grandes redes`
- Preço: `R$ 29,90` por `mês`
- Copie o **Price ID**

### 5. Configurar Webhook (Notificações de Pagamento)

1. Vá em **Desenvolvedores** > **Webhooks**
2. Clique em **Adicionar endpoint**
3. URL do endpoint: `https://seusite.com/stripe/webhook`
   - Se estiver testando local: use [Stripe CLI](https://stripe.com/docs/stripe-cli) ou [ngrok](https://ngrok.com)
4. Events a escutar:
   - `checkout.session.completed`
   - `invoice.payment_succeeded`
   - `customer.subscription.deleted`
5. Copie o **Signing secret** (ex: `whsec_abc123...`)

### 6. Atualizar o Arquivo .env

Edite o arquivo `.env` do seu projeto:

```env
STRIPE_KEY=pk_test_xxxxxxxxxxxxxxxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxxxxxxxxxxxxxxx
STRIPE_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxxxx
STRIPE_PRICE_PROFESSIONAL=price_xxxxxxxxxxxxxxxxxx
STRIPE_PRICE_ENTERPRISE=price_xxxxxxxxxxxxxxxxxx
```

### 7. Ativar Modo de Produção (Quando For Virar Site Real)

1. No Stripe, ative sua conta para **Live Mode** (Modo Real)
2. Preencha os dados fiscais/documentação da sua empresa
3. Substitua as chaves `test_` por `live_` no `.env`
4. O dinheiro real começará a cair na sua conta bancária

### Comandos Úteis

```bash
# Limpar cache das configurações
php artisan config:clear

# Verificar se as rotas estão ok
php artisan route:list
```

### Testando Localmente

Use os cartões de teste do Stripe:
- **Cartão válido**: 4242 4242 4242 4242
- **Data**: qualquer data futura (ex: 12/30)
- **CVV**: qualquer 3 dígitos (ex: 123)

---

## Dúvidas Frequentes

**Q: O dinheiro cai na hora?**
R: O Stripe paga conforme o ciclo (geralmente semanal ou mensal) na sua conta bancária.

**Q: Tem taxa do Stripe?**
R: Sim, o Stripe cobra 3,99% + R$ 0,39 por transação no Brasil.

**Q: Posso cancelar a assinatura do cliente?**
R: Sim, pelo Dashboard do Stripe em **Clientes** > selecione o cliente > **Cancelar assinatura**.

**Suporte Stripe Brasil**: https://support.stripe.com
