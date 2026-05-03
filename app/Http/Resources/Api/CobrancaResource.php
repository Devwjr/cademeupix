<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CobrancaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'divida_id' => $this->divida_id,
            'divida' => new DividaResource($this->divida),
            'chave_pix' => $this->chave_pix,
            'valor' => (float) $this->valor,
            'status' => $this->status,
            'status_label' => $this->status_options[$this->status] ?? $this->status,
            'link_pagamento' => $this->link_pagamento,
            'pix_copia_e_cola' => $this->pix_copia_e_cola,
            'link_whatsapp' => $this->link_whatsapp,
            'mensagem_whatsapp' => $this->mensagem_whatsapp,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
