<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DividaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cliente_id' => $this->cliente_id,
            'cliente' => new ClienteResource($this->cliente),
            'descricao' => $this->descricao,
            'valor' => (float) $this->valor,
            'data_venda' => $this->data_venda?->toIso8601String(),
            'data_vencimento' => $this->data_vencimento?->toIso8601String(),
            'status' => $this->status,
            'status_label' => $this->status_options[$this->status] ?? $this->status,
            'is_vencido' => $this->isVencido(),
            'dias_atraso' => $this->getDiasAtraso(),
            'cobranca' => $this->cobranca ? new CobrancaResource($this->cobranca) : null,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }

    private function getDiasAtraso(): ?int
    {
        if (! $this->data_vencimento) {
            return null;
        }

        if ($this->status === 'pago') {
            return null;
        }

        return now()->diffInDays($this->data_vencimento, false);
    }
}
