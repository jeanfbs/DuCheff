<?php 

/**
*	TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*	
*	Controlador Estoque de Bebidas
*
*	@author: Jean Fabrício <jeanufu21@gmail.com>
*	@since 12/02/2016
*	
*/
class EstoqueBebidaController extends BaseController{


	public function getIndex(){

		Session::put('flag',13);
		
		 return View::make("estoques.bebidas.bebidas");
	}
	/*******************************************
	*  Ação que retorna a View de Cadastro para 
	*  Tab.
	********************************************/
	public function getCadastro()
	{
		return View::make("estoques.bebidas.cadastro");
	}

	/*******************************************
	*  Metodo que cadastra as informações de 
	*  variedades via Ajax
	********************************************/
	public function postCadastro()
	{
		$dados = Input::all();
		
		$explode_1 = explode("/",$dados["data_entrada"]);
		$explode_2 = explode("/",$dados["data_vencimento"]);

		$dados["data_entrada"] = $explode_1[2]."-".$explode_1[1]."-".$explode_1[0];
		$dados["data_vencimento"] = $explode_2[2]."-".$explode_2[1]."-".$explode_2[0];

		$dados["qtd_atual"] = intval($dados["qtd_entrada"]);
		$estoque = new EstoqueBebidaModel($dados);
		$status = $estoque->save();

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
		return View::make("estoques.bebidas.pesquisa");
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
		if(isset($dados["min"]))
			$min = $dados["min"];
		if(isset($dados["max"]))
			$max = $dados["max"];

		$recordsTotal = count(EstoqueBebidaModel::get());

		if($limit == -1)
			$limit = $recordsTotal;

		$estoques = DB::table("estoque_bebidas")
		->join("bebidas","estoque_bebidas.cod_bebida","=","bebidas.cod")
		->select(DB::raw('SQL_CALC_FOUND_ROWS *'))
		->where("estoque_bebidas.cod_estoque",$search["value"])
		->orWhere(function($query) use($min,$max,$search){

			if($min != "" && $max == "")
			$query->where("estoque_bebidas.qtd_atual",">=",$min);
			if($max != "" && $min == "")
				$query->where("estoque_bebidas.qtd_atual","<=",$max);
			if($min != "" && $max != "")
			$query->whereBetween("estoque_bebidas.qtd_atual",array($min,$max));

			$exists = BebidasModel::where("nome","LIKE","%".$search["value"]."%")
					  ->get();

			if(count($exists) > 0)
				$query->where("bebidas.nome","LIKE","%".$search["value"]."%");
			else
				$query->where("estoque_bebidas.data_vencimento","LIKE","%".$search["value"]."%");

		})
		->select("estoque_bebidas.cod_estoque","bebidas.nome",
			"estoque_bebidas.qtd_atual","estoque_bebidas.data_entrada",
			"estoque_bebidas.data_vencimento","bebidas.deletada")
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
		foreach ($estoques as $key => $value) 
		{
			$value = (array)$value;

			if($value["deletada"] == 1)
				continue;

			if(intval($value["qtd_atual"]) == 0)
				$value["qtd_atual"] = "<span class='text-danger'>".$value["qtd_atual"]."</span>";

			if(strtotime($value["data_vencimento"]) && time() > strtotime($value["data_vencimento"]))
			{
				$value["data_vencimento"] = "<span class='text-danger'>".$value["data_vencimento"]."</span>";
			}
			else
			{
				$value["data_vencimento"] = "<span class='text-primary'>".$value["data_vencimento"]."</span>";	
			}

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

		$estoque = DB::table("estoque_bebidas")
		->where("cod_estoque",$codigo)
		->get();
		
		$explode_1 = explode("-",$estoque[0]->data_entrada);
		$explode_2 = explode("-",$estoque[0]->data_vencimento);
		
		$estoque[0]->data_entrada = $explode_1[2]."/".$explode_1[1]."/".$explode_1[0];
		$estoque[0]->data_vencimento = $explode_2[2]."/".$explode_2[1]."/".$explode_2[0];

		return json_encode($estoque);
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
		
		$explode_1 = explode("/",$dados["data_entrada"]);
		$explode_2 = explode("/",$dados["data_vencimento"]);

		$dados["data_entrada"] = $explode_1[2]."-".$explode_1[1]."-".$explode_1[0];
		$dados["data_vencimento"] = $explode_2[2]."-".$explode_2[1]."-".$explode_2[0];

		$result = DB::table('estoque_bebidas')
        ->where('cod_estoque', $codigo)
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
		
		
		DB::table('estoque_bebidas')->where('cod_estoque',$id)->delete();
		return 1;
	}

	/*******************************************
	*  Ação que retorna os dados
	********************************************/
	public function getListar(){

		$estoques = DB::table("estoque_bebidas")
		->join("bebidas","estoque_bebidas.cod_bebida","=","bebidas.cod")
		->orderBy("bebidas.nome","asc")
		->get();
		
		return json_encode($estoques);
	}


}