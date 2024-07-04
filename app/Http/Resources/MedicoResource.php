<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PacienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'controle' =>               $this->controle,
            'nome' =>                   $this->nome,
            'especialidade' =>          $this->especialidade,
            'cpf' =>                    $this->cpf,
            'crm' =>                    $this->crm,
            'endereco' =>               $this->endereco,
            'bairro' =>                 $this->when($this->bairro, $this->bairro, ''),
            'cep' =>                    $this->when($this->cep, $this->cep, ''),
            'numero' =>                 $this->when($this->numero, $this->numero, ''),
            'complemento' =>            $this->when($this->complemento, $this->complemento, ''),
            'cidade' =>                 $this->when($this->cidade, $this->cidade, ''),
            'uf' =>                     $this->when($this->uf, $this->uf, ''),
            'telefone' =>               $this->telefone,
            'celular' =>                $this->celular,
            'email' =>                  $this->email,
            'ativo' =>                  $this->ativo
        ];
    }
}
