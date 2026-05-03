<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nome',
        'telefone',
        'cpf',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dividas(): HasMany
    {
        return $this->hasMany(Divida::class);
    }

    public function getDividasPendentesAttribute()
    {
        return $this->dividas()->whereIn('status', ['pendente', 'vencido'])->get();
    }

    public function getTotalDividasAttribute()
    {
        return $this->dividas()->whereIn('status', ['pendente', 'vencido'])->sum('valor');
    }

    public function getTelefoneFormatadoAttribute(): string
    {
        $telefone = preg_replace('/[^0-9]/', '', $this->telefone);

        if (strlen($telefone) === 11) {
            return '('.substr($telefone, 0, 2).') '.substr($telefone, 2, 5).'-'.substr($telefone, 7);
        }

        if (strlen($telefone) === 10) {
            return '('.substr($telefone, 0, 2).') '.substr($telefone, 2, 4).'-'.substr($telefone, 6);
        }

        return $this->telefone;
    }
}
