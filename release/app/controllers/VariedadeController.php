<?php 


class VariedadeController extends BaseController{


	public function getIndex(){

		Session::put('flag',8);
		
		 return View::make("cardapio.variedades.variedades");
	}
	/*******************************************
	*  Ação que retorna a View de Cadastro para 
	*  Tab.
	********************************************/
	public function getCadastro()
	{
		
		return View::make("cardapio.variedades.cadastro");
	}

	/*******************************************
	*  Metodo que cadastra as informações de 
	*  variedades via Ajax
	********************************************/
	public function postCadastro()
	{
		$dados = Input::all();
		
		$exists = count(VariedadesModel::where("nome",$dados["nome"])->get()) > 0;
		if($exists)
		{
			return 2;
		}


		$variedade = new VariedadesModel($dados);
		$status = $variedade->save();

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
		return View::make("cardapio.variedades.pesquisa");
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

		$recordsTotal = count(VariedadesModel::get());

		if($limit == -1)
			$limit = $recordsTotal;
		$variedade = VariedadesModel::
		select(DB::raw('SQL_CALC_FOUND_ROWS *'))
		->where("cod",$search["value"])
		->orWhere("nome","LIKE","%".$search["value"]."%")
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
		foreach ($variedade->toArray() as $key => $value) 
		{
			if($value["deletada"] == 1)
				continue;
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

		$variedade = VariedadesModel::where("cod",$codigo)
		->get();
		return json_encode($variedade);
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
		
		$result = DB::table('variedades')
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
		
		$isForeign = count(DB::table('prato_variedade')->where('cod_variedade',$id)->get());
		if($isForeign > 0)
		{
			$dados = array();
			$dados["deletada"] = 1;

			$result = DB::table('variedades')
	        ->where('cod', $id)
	        ->update($dados);
	        
	        if($result) return 1;
	        else return 0;
		}

		DB::table('variedades')->where('cod',$id)->delete();
		return 1;
	}

	/*******************************************
	*  Ação que retorna os dados para o select2
	********************************************/
	public function getListar(){

		$varidades = VariedadesModel::
		where("deletada","<>",1)
		->orderBy("nome","asc")->get();
		
		return json_encode($varidades);
	}


}