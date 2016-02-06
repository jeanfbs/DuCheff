<?php 


class LoginController extends BaseController
{

	/*
	* Index do sistema com tela de login
	* Tipo: GET
	*/
	public function index()
	{
		return View::make('login.login');
	}

	/*
	* Autenticador do usuario
	* Lê login e senha do formulário
	* Tipo: POST
	*/
	public function autenticar()
	{
		$dados = Input::all();
		/* *
		*   Qualquer busca no Model irá retornar um objeto model
		*	para acessar os dados do banco é necessario localizar o 
		*	array que contem os dados corretos, dessa forma passei
		*	a posição [0] que correponde aos dados
		*/

		$funcionarios = FuncionariosModel::where('login',$dados['login'])
			->where('senha',sha1($dados['senha']))->get();

		if(count($funcionarios) > 0)
		{
			$funcionario = $funcionarios[0];
			Session::put('cod_user',$funcionario->cod);
			$explode = explode(" ",$funcionario->nome);
			$nome = $explode[0];
			if(count($explode) > 1)
				$nome .= " ".$explode[1];

			Session::put('nome_user',$nome);
			Session::put('nivel_user',$funcionario->nivel);
			Session::put('foto_url',$funcionario->foto_url);
			return Redirect::to('panel-control/dashboard');
		}
		else
		{
			$msg = "2#".Lang::get("geral.msg_error_login");
			Session::flash("msg",$msg);
			return Redirect::back();
		}		
	}


}