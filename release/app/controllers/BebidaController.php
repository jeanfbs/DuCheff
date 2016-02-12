<?php 

/**
*	TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*	
*	Controlador Bebidas
*
*	@author: Jean Fabrício <jeanufu21@gmail.com>
*	@since 12/02/2016
*	
*/
class BebidaController extends BaseController{


	public function getIndex(){

		Session::put('flag',4);
		
		 return View::make("cardapio.bebidas.bebidas");
	}
	/*******************************************
	*  Ação que retorna a View de Cadastro para 
	*  Tab.
	********************************************/
	public function getCadastro()
	{
		
		return View::make("cardapio.bebidas.cadastro");
	}

	/*******************************************
	*  Metodo que cadastra as informações de 
	*  bebidas via Ajax
	********************************************/
	public function postCadastro()
	{
		sleep(5);
		$dados = Input::all();
		$file = Input::file('foto');
		unset($dados["foto"]);

		if($file != null)
		{
			// salva a foto da bebida
			$extension = $file->getClientOriginalExtension();

			$path = "../app/uploads/bebidas/";
			
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

		
		$bebida = new BebidasModel($dados);
		$status = $bebida->save();

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
		return View::make("cardapio.bebidas.pesquisa");
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

		$recordsTotal = count(BebidasModel::get());

		if($limit == -1)
			$limit = $recordsTotal;
		$bebidas = BebidasModel::
		select(DB::raw('SQL_CALC_FOUND_ROWS *'))
		->where("cod",$search["value"])
		->orWhere("nome","LIKE","%".$search["value"]."%")
		->orWhere("valor",$search["value"])
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
		foreach ($bebidas->toArray() as $key => $value) 
		{
			if($value["deletada"] == 1)
				continue;
			if($value["foto_url"] != null)
			{
				$img = "<a class='fancybox' rel='gallery1' href='".$value["foto_url"]."'>";
				$img .= "<img src='".$value["foto_url"]."' alt='".$value["foto_url"]."'/>";
				$img .= "</a>";
				$value["foto_url"] = $img;
			}
			else $value["foto_url"] = "<img class='nophoto' src='../img/noimage.png' />";

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

		$bebida = BebidasModel::where("cod",$codigo)
		->get();
		return json_encode($bebida);
	}
	/*******************************************
	*  Ação que faz a edição dos dados
	********************************************/
	public function postEditar()
	{

		$dados = Input::all();
		$file = Input::file("foto");
		unset($dados["_token"]);

		$codigo = $dados["cod"];
		unset($dados["cod"]);
		unset($dados["foto"]);
		$antiga_foto = $dados["antiga_foto"];
		unset($dados["antiga_foto"]);
		if($file != null)
		{
			if(file_exists($antiga_foto)) return 0;

			if (strtoupper(substr(PHP_OS, 0, 3)) === 'LIN') {
			    //deletar a foto antiga no Windows
				unlink($antiga_foto);
			}

			// salva a foto da bebida
			$extension = $file->getClientOriginalExtension();

			$path = "../app/uploads/bebidas/";
			
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
		
		$result = DB::table('bebidas')
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
		
		$isForeign = count(DB::table('itens_pedido_bebida')->where('cod_bebida',$id)->get());
		if($isForeign > 0)
		{
			$dados = array();
			$dados["deletada"] = 1;

			$result = DB::table('bebidas')
	        ->where('cod', $id)
	        ->update($dados);
	        
	        if($result) return 1;
	        else return 0;
		}		
		DB::table('bebidas')->where('cod',$id)->delete();
		return 1;
	}

	/*******************************************
	*  Ação que faz a busca dos dados
	********************************************/
	public function getListar()
	{
		$bebidas = BebidasModel::
		where("deletada","<>",1)
		->orderBy("nome","asc")
		->get();

		return json_encode($bebidas);
		
	}
}