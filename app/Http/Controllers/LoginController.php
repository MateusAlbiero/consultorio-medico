<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function redirecionarLogin() {
        return redirect()->route('');
    }

    public function index() {
        return view('');
    }

    public function entrar(Request $request) {
        $regras = [
            'login' => 'required',
            'senha' => 'required',
        ];

        $mensagens = [
            '' => 'Campo obrigatório',
            '' => 'Campo obrigatório',
        ];

        $request->validate($regras, $mensagens);

        $credentials = [
            'cpf' => preg_replace('/[^0-9]/', '', $request->get('login')),
            'password' => $request->get('senha'),
        ];

        
        $user = User::where('cpf', $credentials['cpf'])->first();
        if(!$user)
            return redirect()->back()->withInput()->withErrors(['login' => 'Conta não encontrada']);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->ativo != '1') {
                Auth::logout();
                return redirect()->back()->withInput()->withErrors(['login' => 'Conta desativada']);
            }
            Session::put('admin', true);
            Session::put('usercontrole', Auth::user()->controle);        
            
            return redirect()->route('inicio');
        }
        else {
            Auth::loginUsingId($user->controle);
            Session::put('admin', false);
            return redirect()->route('inicio');
        }
    }

    public function sair() {
        Auth::logout();
        Session::put('admin', false);
        Session::put('usercontrole', '-1');
        return redirect()->route('inicio');
    }
}