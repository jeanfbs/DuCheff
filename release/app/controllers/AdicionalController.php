<?php 


class AdicionalController extends BaseController{


	public function getIndex(){

		Session::put('flag',7);
		
		 return View::make("cardapio.adicionais.adicionais");
	}
	/*******************************************
	*  Ação que retorna a View de Cadastro para 
	*  Tab.
	********************************************/
	public function getCadastro()
	{
		
		return View::make("cardapio.adicionais.cadastro");
	}

	/*******************************************
	*  Metodo que cadastra as informações de 
	*  categoria de adicional via Ajax
	********************************************/
	public function postCadastro()
	{
		$dados = Input::all();
		
		$exist = AdicionaisModel::where("cod_produto",$dados["cod_produto"])
		->where("cod_categoria",$dados["cod_categoria"])
		->get();
		if(count($exist) > 0)
			return 2;

		$adicional = new AdicionaisModel($dados);
		$status = $adicional->save();
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
		return View::make("cardapio.adicionais.pesquisa");
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

		$recordsTotal = count(AdicionaisModel::get());

		if($limit == -1)
			$limit = $recordsTotal;
		$tmp = DB::table("adicionais")
		->join("produtos","adicionais.cod_produto","=","produtos.cod")
		->join("categorias","adicionais.cod_categoria","=","categorias.cod")
		->select(DB::raw('SQL_NO_CACHE SQL_CALC_FOUND_ROWS *'))
		->where("adicionais.cod",$search["value"])
		->orWhere("produtos.nome","LIKE","%".$search["value"]."%")
		->orWhere("categorias.nome","LIKE","%".$search["value"]."%")
		->orderBy($columns[$orderIndex]["name"],$order["dir"])
		->take($limit)
		->skip($start)
		->get();

		$recordsFiltered = DB::select( DB::raw("SELECT FOUND_ROWS() AS total;") );
		$recordsFiltered = $recordsFiltered[0];
		$recordsFiltered = intval($recordsFiltered->total);

		$adicionais = DB::table("adicionais")
		->join("produtos","adicionais.cod_produto","=","produtos.cod")
		->join("categorias","adicionais.cod_categoria","=","categorias.cod")
		->where("adicionais.cod",$search["value"])
		->orWhere("produtos.nome","LIKE","%".$search["value"]."%")
		->orWhere("categorias.nome","LIKE","%".$search["value"]."%")
		->select("adicionais.cod","produtos.nome as produto","categorias.nome as categoria","produtos.deletada as produto_deletada","categorias.deletada as categoria_deletada")
		->orderBy($columns[$orderIndex]["name"],$order["dir"])
		->take($limit)
		->skip($start)
		->get();
		
		
		$json = [];
		$json["draw"] = intval($dados["draw"]);
		$json["recordsTotal"] = $recordsTotal;
		$json["recordsFiltered"] = $recordsFiltered;
		$json["aaData"] = array();
		foreach ($adicionais as $key => $value) 
		{
			$value = (array)$value;

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
		$join = AdicionaisModel::where('adicionais.cod',$codigo)
		->get();
		return json_encode($join);
	}
	/*******************************************
	*  Ação de solicitação Ajax que busca os dados
	*  de um adicional juntamente com os joins.
	********************************************/
	public function getVer()
	{
		$codigo = Input::get('codigo');

		$join = DB::table("adicionais")
		->join("produtos","adicionais.cod_produto","=","produtos.cod")
		->join("categorias","adicionais.cod_categoria","=","categorias.cod")
		->where("adicionais.cod",$codigo)
		->select("produtos.nome as adicional","categorias.nome as categoria")
		->get();

		return json_encode($join);
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
		$exist = AdicionaisModel::where("cod_produto",$dados["cod_produto"])
		->where("cod_categoria",$dados["cod_categoria"])
		->get();
		if(isset($exist[0]))
			$cod_antigo = $exist[0]->cod;
		else
			$cod_antigo = 0;

		if(count($exist) > 0 && $codigo != $cod_antigo)
		{
			return 2;
		}
		
		
		$result = DB::table('adicionais')
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
		
		$isForeign = count(DB::table('item_pedido_adicional')
			->where('cod_adicional',$id)->get());
		if($isForeign > 0)
		{
			$dados = array();
			$dados["deletada"] = 1;

			$result = DB::table('adicionais')
			->join('produtos',"adicionais.cod_produto","=","produtos.cod")
	        ->where('adicionais.cod', $id)
	        ->update($dados);
	        
	        if($result) return 1;
	        else return 0;
		}
		DB::table('adicionais')->where('cod',$id)->delete();
		return 1;
	}


}