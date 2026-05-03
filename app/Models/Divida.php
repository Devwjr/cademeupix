<?php

namespace App\Models;

use App\Notifications\DividaVencidaNotification;
use App\Notifications\PagamentoRecebidoNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Divida extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cliente_id',
        'descricao',
        'valor',
        'data_venda',
        'data_vencimento',
        'status',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_venda' => 'date',
        'data_vencimento' => 'date',
        'deleted_at' => 'datetime',
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

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cobranca(): HasOne
    {
        return $this->hasOne(Cobranca::class);
    }

    public function isPendente(): bool
    {
        return $this->status === self::STATUS_PENDENTE;
    }

    public function isPago(): bool
    {
        return $this->status === self::STATUS_PAGO;
    }

    public function isVencido(): bool
    {
        if ($this->status === self::STATUS_VENCIDO) {
            return true;
        }

        if ($this->data_vencimento && $this->status === self::STATUS_PENDENTE) {
            return now()->greaterThan($this->data_vencimento);
        }

        return false;
    }

    public function verificarEAtualizarStatus(): void
    {
        if (!$this->isPago() && $this->isVencido()) {
            $this->update(['status' => self::STATUS_VENCIDO]);
            $this->user->notify(new DividaVencidaNotification($this));
        }
    }

    public function marcarComoPaga(): void
    {
        $this->update(['status' => self::STATUS_PAGO]);
        $this->user->notify(new PagamentoRecebidoNotification($this));
        
        if ($this->cobranca) {
            $this->cobranca->update(['status' => Cobranca::STATUS_PAGO]);
        }
    }
}
