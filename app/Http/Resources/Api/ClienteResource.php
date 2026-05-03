<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "telefone" => $this->telefone,
            "telefone_formatado" => $this->telefone_formatado,

            "cpf" => $this->cpf,
            "total_dividas" => (float) $this->total_dividas,
            "dividas_pendentes" => $this->dividas_pendentes->count(),
            "created_at" => $this->created_at->toIso8601String(),
            "updated_at" => $this->updated_at->toIso8601String(),
        ];
    }
}
