<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use App\Models\Views\vReceita;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;

class ReceitaController extends BaseController
{
    public function index() {
        return view('');   
    }

    public function cadastro($id = null) {
        $receita                       = null;

        if($id){
            $receita                   = vReceita::where('controle',$id)->first();
            
            if(!$receita) 
                abort(404);
        }
        return view('', compact('Receita'));   
    }

    public function busca($id = null) {
        $query = vReceita::select('controle', 'prescricao', 'dosagem')
                         ->where('ativo', '1');
        
        if (!$id) {
            $d = request()->get('d');
            $d = $query->where(function($query) use($d) {
                $query->where('controle', '=', $d);
            })
            ->limit(10)
            ->get();

            if ($d) {
                return $d;
            }
        } else {
            $d = $query->select('controle', 'prescricao', 'dosagem')
                        ->where('controle', $id)
                        ->first();
            
            if ($d) {
                return $d;
            }            
        }
    }    

    public function getReceita() {
        $query = vReceita::select(
                    'controle',
                    'prescricao',
                    'dosagem'
                )
                ->where('ativo', '1');

        $receitas = $query->get();
    }

    public function gravar(){
        $dados      = json_decode(request()->get('d'));
        
        if(!$dados->prescricao){
            $camposInvalidos[] = '#prescricao';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }

        if(!$dados->dataprescricao){
            $camposInvalidos[] = '#dataprescricao';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }
        
        if(!$dados->dosagem){
            $camposInvalidos[] = '#dosagem';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }
        
        if(isset($camposInvalidos)) 
            return Response::json(createError($camposInvalidos, $mensagemInvalidos));

        try {
            $receita = vReceita::find($dados->controle);
            if(!$receita){
                $receita = new vReceita();
            }
            
            $receita->prescricao                = $dados->prescricao;
            $receita->especialidade             = $dados->especialidade;
            $receita->codpaciente               = $dados->codpaciente;
            $receita->codmedico                 = $dados->codmedico;
            $receita->codmedicamento            = $dados->codmedicamento;
            $receita->dataprescricao            = $dados->dataprescricao;
            $receita->dosagem                   = $dados->dosagem;
            $receita->save();

            return Response::json([
                'status' => 'success',
                'message' => 'Dados gravados com sucesso.'
            ]);
        } catch (\Exception $e) {
            return Response::json([
                'status' => 'Error',
                'message' => 'Falha ao gravar os dados.'. $e->getMessage(),
            ]);
        }
    }
}