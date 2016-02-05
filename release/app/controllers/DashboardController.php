<?php 

class DashboardController extends BaseController
{

	public function getIndex()
	{
		return Redirect::to('panel-control/dashboard');
	}

	public function getDashboard()
	{
		Session::put('flag',1);
		return View::make("dashboard");
	}

	public function getPerfil()
	{
		$funcionarios = FuncionariosModel::where('cod',Session::get('cod_user'))
		->get();
		if(isset($funcionarios[0]))
			$funcionarios = $funcionarios[0];
		$dados = 
		[
			'dados' => $funcionarios
		];
		return View::make("menu.perfil")->with($dados);
	}
	public function postPerfil()
	{
		$dados = Input::all();
		unset($dados["_token"]);
		unset($dados["confirmacao"]);
		if(!Session::has('cod_user'))
			return 0;
		$codigo = Session::get('cod_user');
		if(isset($dados["senha"]))
			$dados["senha"] = sha1($dados["senha"]);

		$result = DB::table('funcionarios')
        ->where('cod', $codigo)
        ->update($dados);
        
        if($result)
			$msg = "1#".Lang::get('geral.msg_perfil_atualizado_sucesso');
		else
			$msg = "2#".Lang::get('geral.msg_erro');

		Session::flash("msg",$msg);
		return Redirect::back();
	}
	
	public function getLogout()
	{
		Session::forget('cod_user');
		Session::forget('nome_user');
		Session::forget('tipo_user');

		return Redirect::to("/");
	}
}