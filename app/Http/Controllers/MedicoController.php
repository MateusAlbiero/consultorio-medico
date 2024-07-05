<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Views\vMedico;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;

class MedicoController extends Controller
{
    public function index() {
        return view('');   
    }

    public function cadastro($id = null) {
        $medico = null;

        if($id){
            $medico = vMedico::where('controle',$id)->first();
            
            if(!$medico) 
                abort(404);
        }
        return view('', compact('medico'));   
    }

    public function busca($id = null) {
        $query = vMedico::select('controle', 'nome', 'cpf', 'endereco', 'bairro', 'cidade', 'uf')
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

    public function getMedico() {
        $query = vMedico::select(
                    'controle',
                    'codsgmaster',
                    'nome',
                    'nomefantasia',
                    'cpf',
                    'codfuncionario'
                )
                ->where('ativo', '1');

        $medicos = $query->get();
    }

    public function gravar(){
        $dados      = json_decode(request()->get('d'));
        $cpf        = preg_replace('/[^0-9]/', '', $dados->cpf);

        if(!$cpf){
            $camposInvalidos[] = '#cpf';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }
        
        if(isset($dados->controle)) {
            if(Medico::where('cpf', $cpf)->where('controle', '<>', $dados->controle)->get()->count() > 0){
                $camposInvalidos[] = '#cpf';
                $mensagemInvalidos[] = '* CPF já foi cadastrado';
            }
        } else {
            if(Medico::where('cpf', $cpf)->get()->count() > 0){
                $camposInvalidos[] = '#cpf';
                $mensagemInvalidos[] = '* CPF já foi cadastrado';
            }
        }
        
        if(!$dados->nome){
            $camposInvalidos[] = '#nome';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }

        if(!$dados->especialidade){
            $camposInvalidos[] = '#especialidade';
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
            $medico = vMedico::find($dados->controle);
            if(!$medico){
                $medico = new vMedico();
            }
            
            $medico->nome                     = $dados->nome;
            $medico->especialidade            = $dados->especialidade;
            $medico->cpf                      = $dados->cpf;
            $medico->crm                      = $dados->crm;
            $medico->endereco                 = $dados->endereco;
            $medico->bairro                   = $dados->bairro;
            $medico->cep                      = preg_replace('/[^0-9]/', '', $dados->cep);
            $medico->numero                   = $dados->numero;
            $medico->complemento              = $dados->complemento;
            $medico->cidade                   = $dados->cidade;
            $medico->uf                       = $dados->uf;
            $medico->telefone                 = $dados->telefone;
            $medico->celular                  = $dados->celular;
            $medico->email                    = $dados->email;
            $medico->ativo                    = '1';
            $medico->save();

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