<?php 
/**
*       TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*       
*       Controlador de Usuarios
*
*       @author: Jean Fabrício <jeanufu21@gmail.com>
*       @since 12/02/2016
*       
*/
 class UsuarioController extends BaseController{


 	public function getIndex()
	{
		Session::put('flag',2);
		return View::make('usuario.usuario');
	}

	/*******************************************
	*  Ação que retorna a View de Cadastro para 
	*  Tab.
	********************************************/
	public function getCadastro()
	{
		return View::make('usuario.cadastro');
	}

	/*******************************************
	*  Ação para Cadastro de Usuarios do Sistema
	********************************************/
	public function postCadastro()
	{
		$dados = Input::all();
		$file = Input::file('foto');
		unset($dados["foto"]);

		if($file != null)
		{
			// salva a foto
			$extension = $file->getClientOriginalExtension();

			$path = "../app/uploads/usuarios/";
			
			if(!is_dir($path))
			{
				
				if(!mkdir($path,0777,true)) return 0;
			}
			$filename = date('Y-m-d-H-i-s').".".$extension;
			$nome_foto = $path.$filename;
			$file->move($path,$filename);
		}

		if(isset($nome_foto))
			$dados["foto_url"] = "../".$nome_foto;
		unset($dados["confirmacao"]);
		
		$dados["senha"] = sha1($dados["senha"]);
		$funcionario = new FuncionariosModel($dados);
		$status = $funcionario->save();

		if($status)
			return 1;
		else
			return 0;
	}

	/*******************************************
	*  Ação que retorna a View de Pesquisa para 
	*  Tab.
	********************************************/
	public function getPesquisa()
	{
		return View::make('usuario.pesquisa');
	}

	/*******************************************
	*  Ação que faz a busca dos dados via Ajax utilizando
	*  o Plugin DataTables
	********************************************/
	public function postPesquisa()
	{
		$dados = Input::all();

		if(isset($dados["columns"]))
			$columns = $dados["columns"];
		if(isset($dados["order"]))
		{
			$order = $dados["order"];
			$order = $order[0];
			$orderIndex = intval($order["column"]);
		}

		if(isset($dados["search"]))
			$search = $dados["search"];
			$limit = intval($dados["length"]);
			$start = intval($dados["start"]);
		$recordsTotal = count(FuncionariosModel::get());

		if($limit == -1)
			$limit = $recordsTotal;
		$funcionarios = FuncionariosModel::
		select(DB::raw('SQL_CALC_FOUND_ROWS *'))
		->where("cod",$search["value"])
		->orWhere("nome","LIKE","%".$search["value"]."%")
		->orWhere("login","LIKE","%".$search["value"]."%")
		->orderBy($columns[$orderIndex]["name"],$order["dir"])
		->take($limit)
		->skip($start)
		->get();
		
		
		$recordsFiltered = DB::select( DB::raw("SELECT FOUND_ROWS() AS total;") );
		$recordsFiltered = $recordsFiltered[0];
		$recordsFiltered = intval($recordsFiltered->total);
		$json = [];
		$json["draw"] = intval($dados["draw"]);
		$json["recordsTotal"] = $recordsTotal;
		$json["recordsFiltered"] = $recordsFiltered;
		$json["aaData"] = array();
		foreach ($funcionarios->toArray() as $key => $value) {
			if($value["nivel"] == 1)
				$value["nivel"] = Lang::get('geral.nivel_admin');
			else if($value["nivel"] == 2)
				$value["nivel"] = Lang::get('geral.nivel_atendente');
			else
				$value["nivel"] = Lang::get('geral.nivel_entregador');

			array_push($json["aaData"], array_values($value));
		}
		return json_encode($json);
	}

	/*******************************************
	*  Ação de solicitação Ajax que auto preenche
	*  os dados para edição
	********************************************/
	public function getEditar()
	{

		$codigo = Input::get('codigo');

		$funcionario = FuncionariosModel::where("cod",$codigo)
		->get();

		return json_encode($funcionario);
	}

	/*******************************************
	*  Ação que faz a edição dos dados
	********************************************/
	public function postEditar()
	{

		$dados = Input::all();
		unset($dados["_token"]);

		$codigo = $dados["cod"];
		unset($dados["cod"]);
		if(isset($dados["senha"]))
			$dados["senha"] = sha1($dados["senha"]);

		$result = DB::table('funcionarios')
        ->where('cod', $codigo)
        ->update($dados);
        
        if($result)
			return 1;
		else
			return 0;
	}

	/*******************************************
	*  Ação que faz a exclusão dos dados
	********************************************/
	public function getDeletar()
	{
		$id = Input::get("id");
		if($id == Session::get('cod_user'))
			return 2;
		
		DB::table('funcionarios')->where('cod',$id)->delete();

		return 1;
	}

 }