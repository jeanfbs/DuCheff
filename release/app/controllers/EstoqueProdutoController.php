<?php 


class EstoqueProdutoController extends BaseController{


	public function getIndex(){

		Session::put('flag',12);
		
		 return View::make("estoques.produtos.produtos");
	}
	/*******************************************
	*  Ação que retorna a View de Cadastro para 
	*  Tab.
	********************************************/
	public function getCadastro()
	{
		return View::make("estoques.produtos.cadastro");
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
		$estoque = new EstoqueProdutoModel($dados);
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
		return View::make("estoques.produtos.pesquisa");
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

		$recordsTotal = count(EstoqueProdutoModel::get());

		if($limit == -1)
			$limit = $recordsTotal;

		$estoques = DB::table("estoque_produtos")
		->join("produtos","estoque_produtos.cod_produto","=","produtos.cod")
		->select(DB::raw('SQL_CALC_FOUND_ROWS *'))
		->where("estoque_produtos.cod_estoque",$search["value"])
		->orWhere(function($query) use($min,$max,$search){

			if($min != "" && $max == "")
			$query->where("estoque_produtos.qtd_atual",">=",$min);
			if($max != "" && $min == "")
				$query->where("estoque_produtos.qtd_atual","<=",$max);
			if($min != "" && $max != "")
			$query->whereBetween("estoque_produtos.qtd_atual",array($min,$max));

			$exists = ProdutosModel::where("nome","LIKE","%".$search["value"]."%")
					  ->get();
			if(count($exists) > 0)
				$query->where("produtos.nome","LIKE","%".$search["value"]."%");
			else
				$query->where("estoque_produtos.data_vencimento","LIKE","%".$search["value"]."%");

		})
		->select("estoque_produtos.cod_estoque","produtos.nome","estoque_produtos.qtd_atual",
			"estoque_produtos.data_entrada","estoque_produtos.data_vencimento","produtos.deletada")
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

			$explode_1 = explode("-",$value["data_entrada"]);
			$explode_2 = explode("-",$value["data_vencimento"]);

			if(intval($value["qtd_atual"]) == 0)
				$value["qtd_atual"] = "<span class='text-danger'>".$value["qtd_atual"]."</span>";

			$value["data_entrada"] = $explode_1[2]."/".$explode_1[1]."/".$explode_1[0];
			if(strtotime($value["data_vencimento"]) < time())
				$value["data_vencimento"] = "<span class='text-danger'><i class='fa fa-clock-o'></i> ".$explode_2[2]."/".$explode_2[1]."/".$explode_2[0]."</span>";
			else
				$value["data_vencimento"] = "<span class='text-primary'>".$explode_2[2]."/".$explode_2[1]."/".$explode_2[0]."</span>";

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

		$estoque = DB::table("estoque_produtos")
		->where("estoque_produtos.cod_estoque",$codigo)
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

		$result = DB::table('estoque_produtos')
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
		
		
		DB::table('estoque_produtos')->where('cod_estoque',$id)->delete();
		return 1;
	}

	/*******************************************
	*  Ação que retorna os dados
	********************************************/
	public function getListar(){

		$estoques = DB::table("estoque_produtos")
		->join("produtos","estoque_produtos.cod_produto","=","produtos.cod")
		->orderBy("produtos.nome","asc")
		->get();
		
		return json_encode($estoques);
	}


}