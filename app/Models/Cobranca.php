<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Cobranca extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'divida_id',
        'chave_pix',
        'valor',
        'status',
        'link_pagamento',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
    ];

    const STATUS_PENDENTE = 'pendente';
    const STATUS_PAGO = 'pago';
    const STATUS_VENCIDO = 'vencido';

    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_PENDENTE => 'Pendente',
            self::STATUS_PAGO => 'Pago',
            self::STATUS_VENCIDO => 'Vencido',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function divida(): BelongsTo
    {
        return $this->belongsTo(Divida::class);
    }

    public static function gerarChavePix(): string
    {
        return (string) Str::uuid();
    }

    public function getPixCopiaEColaAttribute(): string
    {
        $pixKey = config('services.pix.key') ?? $this->chave_pix;
        $merchantName = config('services.pix.merchant_name') ?? 'CadêMeuPix';
        $merchantCity = config('services.pix.merchant_city') ?? 'CIDADE';
        
        $gui = 'BR.GOV.BCB.BRCODE*1.0.0';
        $key = '01' . str_pad(strlen($pixKey), 2, '0', STR_PAD_LEFT) . $pixKey;
        $merchantAccountInfo = 'br.gov.bcb.pix' . '01' . str_pad(strlen($pixKey), 2, '0', STR_PAD_LEFT) . $pixKey;
        $merchantAccountInfo = '00' . str_pad(strlen($merchantAccountInfo), 2, '0', STR_PAD_LEFT) . $merchantAccountInfo;
        $merchantNameField = '02' . str_pad(strlen($merchantName), 2, '0', STR_PAD_LEFT) . $merchantName;
        $merchantCityField = '03' . str_pad(strlen($merchantCity), 2, '0', STR_PAD_LEFT) . $merchantCity;
        
        $guiField = '00' . str_pad(strlen($gui), 2, '0', STR_PAD_LEFT) . $gui;
        $merchantAccountInfoField = '01' . str_pad(strlen($merchantAccountInfo), 2, '0', STR_PAD_LEFT) . $merchantAccountInfo;
        
        $addData = $guiField . $merchantAccountInfoField . $merchantNameField . $merchantCityField;
        $addDataField = '05' . str_pad(strlen($addData), 2, '0', STR_PAD_LEFT) . $addData;
        
        $value = number_format($this->valor, 2, '.', '');
        $amountField = '54' . str_pad(strlen($value), 2, '0', STR_PAD_LEFT) . $value;
        
        $countryCode = 'BR';
        $countryCodeField = '52' . str_pad(strlen($countryCode), 2, '0', STR_PAD_LEFT) . $countryCode;
        
        $currency = '986';
        $currencyField = '53' . str_pad(strlen($currency), 2, '0', STR_PAD_LEFT) . $currency;
        
        $txid = '05' . str_pad(strlen('CADEMEUPIX' . $this->id), 2, '0', STR_PAD_LEFT) . 'CADEMEUPIX' . $this->id;
        $txidField = '05' . str_pad(strlen($txid), 2, '0', STR_PAD_LEFT) . $txid;
        
        $payload = $guiField . $merchantAccountInfoField . $merchantNameField . $merchantCityField . 
                   $txidField . $amountField . $countryCodeField . $currencyField . $txidField . '6304';
        
        return $this->calcularCRC16($payload);
    }

    private function calcularCRC16(string $payload): string
    {
        $crc = 0xFFFF;
        $polynomial = 0x1021;

        $payloadBytes = array_map('ord', str_split($payload));

        foreach ($payloadBytes as $byte) {
            $crc ^= ($byte << 8);
            for ($i = 0; $i < 8; $i++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ $polynomial;
                } else {
                    $crc = $crc << 1;
                }
                $crc &= 0xFFFF;
            }
        }

        return $payload . strtoupper(sprintf('%04X', $crc));
    }

    public function getLinkWhatsAppAttribute(): string
    {
        $divida = $this->divida;
        $cliente = $divida->cliente;
        
        $mensagem = "Olá {$cliente->nome}! 😊\n\n";
        $mensagem .= "Você tem uma cobrança pendente:\n";
        $mensagem .= "📝 *{$divida->descricao}*\n";
        $mensagem .= "💰 *Valor: R$ " . number_format($this->valor, 2, ',', '.') . "*\n\n";
        
        if ($this->link_pagamento) {
            $mensagem .= "🔗 Para pagar via Pix, clique no link:\n{$this->link_pagamento}\n\n";
        }
        
        if ($this->chave_pix) {
            $mensagem .= "📱 Chave Pix: {$this->chave_pix}\n\n";
        }
        
        $mensagem .= "Qualquer dúvida, entre em contato! 👍";
        
        return 'https://wa.me/' . preg_replace('/[^0-9]/', '', $cliente->telefone) . '?text=' . urlencode($mensagem);
    }

    public function isPendente(): bool
    {
        return $this->status === self::STATUS_PENDENTE;
    }

    public function isPago(): bool
    {
        return $this->status === self::STATUS_PAGO;
    }

    public function getMensagemWhatsAppAttribute(): string
    {
        $divida = $this->divida;
        $cliente = $divida->cliente;
        
        $mensagem = "Olá {$cliente->nome}! 😊\n\n";
        $mensagem .= "Você tem uma cobrança pendente:\n";
        $mensagem .= "📝 *{$divida->descricao}*\n";
        $mensagem .= "💰 *Valor: R$ " . number_format($this->valor, 2, ',', '.') . "*\n\n";
        
        if ($this->link_pagamento) {
            $mensagem .= "🔗 Para pagar via Pix, clique no link:\n{$this->link_pagamento}\n\n";
        }
        
        if ($this->chave_pix) {
            $mensagem .= "📱 Chave Pix: {$this->chave_pix}\n\n";
        }
        
        $mensagem .= "Qualquer dúvida, entre em contato! 👍";
        
        return $mensagem;
    }

    public function marcarComoPago(): void
    {
        $this->update(['status' => self::STATUS_PAGO]);
        $this->divida->update(['status' => Divida::STATUS_PAGO]);
    }
}
