<?php 

class ClienteController extends BaseController{


	public function getIndex(){

		Session::put('flag',3);
		
		 return View::make("clientes.clientes");
	}
	
	public function getCadastro(){

		return View::make("clientes.cadastro");
	}
	/*******************************************
	*  Metodo que cadastra as informações de 
	*  clientes via Ajax
	********************************************/
	public function postCadastro()
	{
		$dados = Input::all();
		
		$dados["senha"] = sha1($dados["senha"]);
		$cliente = new ClientesModel($dados);
		$status = $cliente->save();

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
		return View::make("clientes.pesquisa");
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

		$recordsTotal = count(ClientesModel::get());

		if($limit == -1)
			$limit = $recordsTotal;
		$clientes = ClientesModel::
		select(DB::raw('SQL_CALC_FOUND_ROWS *'))
		->where("cod",$search["value"])
		->orWhere("nome","LIKE","%".$search["value"]."%")
		->orWhere("endereco","LIKE","%".$search["value"]."%")
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
		foreach ($clientes->toArray() as $key => $value) 
		{
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

		$cliente = ClientesModel::
		where(function($query){
			if(Input::has('codigo'))
			{
				$codigo = Input::get('codigo');
				$query->where("cod",$codigo);
			}
			else if(Input::has("nome"))
			{
				$nome = Input::get('nome');
				$query->where("nome",$nome);
			}
				
		})
		->get();
		return json_encode($cliente);
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
		$result = DB::table('clientes')
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
		
		$isForeign = count(DB::table('pedidos')->where('cod_cliente',$id)->get());

		if($isForeign > 0)
		{
			return 2;
		}		
		DB::table('clientes')->where('cod',$id)->delete();
		return 1;
	}

	/*******************************************
	*  Ação que faz a busca dos dados
	********************************************/
	public function getListar()
	{
		$clientes = ClientesModel::
		orderBy("nome","asc")
		->get();

		return json_encode($clientes);
		
	}

}