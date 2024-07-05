<?php

namespace App\Http\Controllers;

use App\Models\Views\vMedicamento;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;

class MedicamentoController extends Controller
{
    public function index() {
        return view('');   
    }

    public function cadastro($id = null) {
        $medicamento = null;

        if($id){
            $medicamento = vMedicamento::where('controle',$id)->first();
            
            if(!$medicamento) 
                abort(404);
        }
        return view('', compact('medicamento'));   
    }

    public function busca($id = null) {
        $query = vMedicamento::select('controle', 'descricao', 'classeterapeutica', 'classificacao', 'tarja', 'registroms', 'fabricante');
        
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
            $d = $query->select('controle', 'descricao', 'tarja', 'registroms', 'fabricante')
                        ->where('controle', $id)
                        ->first();
            
            if ($d) {
                return $d;
            }            
        }
    }    

    public function getMedicamento() {
        $query = vMedicamento::select(
                    'controle',
                    'descricao',
                    'tarja',
                    'registroms',
                    'fabricante'
        );

        $medicamentos = $query->get();
    }

    public function gravar(){
        $dados      = json_decode(request()->get('d'));
        
        if(!$dados->descricao){
            $camposInvalidos[] = '#descricao';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }

        if(!$dados->tarja){
            $camposInvalidos[] = '#tarja';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }
        
        if(!$dados->registroms){
            $camposInvalidos[] = '#registroms';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }

        if(!$dados->controlado){
            $camposInvalidos[] = '#controlado';
            $mensagemInvalidos[] = '* Campo obrigatório';
        }
        if(isset($camposInvalidos)) 
            return Response::json(createError($camposInvalidos, $mensagemInvalidos));

        try {
            $medicamento = vMedicamento::find($dados->controle);
            if(!$medicamento){
                $medicamento = new vMedicamento();
            }
            
            $medicamento->descricao             = $dados->descricao;
            $medicamento->classeterapeutica     = $dados->classeterapeutica;
            $medicamento->classificacao         = $dados->classificacao;
            $medicamento->tarja                 = $dados->tarja;
            $medicamento->registroms            = $dados->registroms;
            $medicamento->tipomedicamento       = $dados->tipomedicamento;
            $medicamento->controlado            = $dados->controlado;
            $medicamento->fabricante            = $dados->fabricante;
            $medicamento->save();

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