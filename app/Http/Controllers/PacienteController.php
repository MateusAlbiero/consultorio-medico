<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Views\vPaciente;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;

class PacienteController extends Controller
{
    public function index() {
        return view('');   
    }

    public function cadastro($id = null) {
        $paciente = null;

        if($id){
            $paciente = vPaciente::where('controle',$id)->first();
            
            if(!$paciente) 
                abort(404);
        }
        return view('', compact('paciente'));   
    }

    public function buscar($id = null) {
        $query = vPaciente::select('controle', 'nome', 'cpf', 'endereco', 'bairro', 'cidade', 'uf')
                         ->where('ativo', '1');
        
        if (!$id) {
            $d = request()->get('d');
            $d = $query->where(function($query) use($d) {
                $query->where('controle', '=', $d)
                        ->orWhere('nome', 'like', '%'.$d.'%')
                        ->orWhere('email', 'like', '%'.$d.'%');

                preg_match('/([0-9]{2}[\.][0-9]{3}[\.][0-9]{3}[\/][0-9]{4}[\-][0-9]{2})|([0-9]{14})|([0-9]{3}[\.][0-9]{3}[\.][0-9]{3}[\-][0-9]{2})|([0-9]{11})/', $d, $buscaCPF);        
                if (count($buscaCPF) > 0) {
                    $query->orWhere('cpf', 'like', '%'.preg_replace('/[^0-9]/', '', $d).'%');
                }
                
                preg_match("/([\(]?([0-9]{2})?[\)]?[\' ']?[\9]?[\' ']?[0-9]{4}[\-]?[0-9]{4})/", $d, $dTelCel);
                if (count($dTelCel) > 0) {
                    $drep = preg_replace('/[^0-9]/', '', $d);
                    $query->orWhere('telefone', 'like', '%'.$drep.'%')
                            ->orWhere('celular', 'like', '%'.$drep.'%');
                }
            })
            ->limit(10)
            ->get();

            if ($d) {
                return $d;
            }
        } else {
            $d = $query->select('controle', 'nome', 'cpf', 'email')
                        ->where('controle', $id)
                        ->first();
            
            if ($d) {
                return $d;
            }            
        }
    }    

    public function getpaciente() {
        $query = vPaciente::select(
                    'controle',
                    'codsgmaster',
                    'nome',
                    'nomefantasia',
                    'cpf',
                    'codfuncionario'
                )
                ->where('ativo', '1');

        $pacientes = $query->get();
    }

    public function gravar(){
        $dados      = json_decode(request()->get('d'));
        $cpf        = preg_replace('/[^0-9]/', '', $dados->cpf);

        if(!$cpf){
            $camposInvalidos[] = '#cpf';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }
        
        if(isset($dados->controle)) {
            if(Paciente::where('cpf', $cpf)->where('controle', '<>', $dados->controle)->get()->count() > 0){
                $camposInvalidos[] = '#cpf';
                $mensagemInvalidos[] = '* CPF já foi cadastrado';
            }
        } else {
            if(Paciente::where('cpf', $cpf)->get()->count() > 0){
                $camposInvalidos[] = '#cpf';
                $mensagemInvalidos[] = '* CPF já foi cadastrado';
            }
        }
        
        if(!$dados->nome){
            $camposInvalidos[] = '#nome';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }
        
        if(!$dados->cep){
            $camposInvalidos[] = '#cep';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }
        
        if(!$dados->uf){
            $camposInvalidos[] = '#uf';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }
        
        if(!$dados->cidade){
            $camposInvalidos[] = '#cidade';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }
        
        if(!$dados->endereco){
            $camposInvalidos[] = '#endereco';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }
        
        if(!$dados->bairro){
            $camposInvalidos[] = '#bairro';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }

        if(!$dados->email){
            $camposInvalidos[] = '#email';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }

        if(isset($camposInvalidos)) 
            return Response::json(createError($camposInvalidos, $mensagemInvalidos));

        try {
            $paciente = vPaciente::find($dados->controle);
            if(!$paciente){
                $paciente = new vPaciente();
            }
            
            $paciente->nome                     = $dados->nome;
            $paciente->cpf                      = $dados->cpf;
            $paciente->endereco                 = $dados->endereco;
            $paciente->bairro                   = $dados->bairro;
            $paciente->cep                      = preg_replace('/[^0-9]/', '', $dados->cep);
            $paciente->numero                   = $dados->numero;
            $paciente->complemento              = $dados->complemento;
            $paciente->cidade                   = $dados->cidade;
            $paciente->uf                       = $dados->uf;
            $paciente->telefone                 = $dados->telefone;
            $paciente->celular                  = $dados->celular;
            $paciente->email                    = $dados->email;
            $paciente->observacao               = $dados->observacao;
            $paciente->ativo                    = '1';
            $paciente->save();

            return Response::json([
                'status' => 'success',
                'message' => 'Dados salvos com sucesso.'
            ]);
        } catch (\Exception $e) {
            return Response::json([
                'status' => 'Error',
                'message' => 'Falha ao gravar os dados.'. $e->getMessage(),
            ]);
        }
    }
}