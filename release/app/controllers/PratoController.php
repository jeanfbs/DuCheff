<?php 
/**
*       TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*       
*       Controlador de Prato
*
*       @author: Jean Fabrício <jeanufu21@gmail.com>
*       @since 12/02/2016
*       
*/

class PratoController extends BaseController{


	public function getIndex(){

		Session::put('flag',10);
		
		 return View::make("cardapio.pratos.pratos");
	}
	/*******************************************
	*  Ação que retorna a View de Cadastro para 
	*  Tab.
	********************************************/
	public function getCadastro()
	{
		
		return View::make("cardapio.pratos.cadastro");
	}

	/*******************************************
	*  Metodo que cadastra as informações de 
	*  pratos de adicional via Ajax
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

			$path = "../app/uploads/pratos/";
			
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
		
		$prato = new PratosModel($dados);
		$status = $prato->save();

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
		return View::make("cardapio.pratos.pesquisa");
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

		$recordsTotal = count(PratosModel::get());
		
		if($limit == -1)
			$limit = $recordsTotal;

		$pratos = DB::table("pratos")
		->join("tipo_prato","pratos.cod_tipo_prato","=","tipo_prato.cod")
		->select(DB::raw('SQL_CALC_FOUND_ROWS *'))
		->where("pratos.cod",$search["value"])
		->orWhere(function($query) use($min,$max,$search){
			if($min != "" && $max == "")
			$query->where("pratos.valor",">=",$min);
			if($max != "" && $min == "")
				$query->where("pratos.valor","<=",$max);
			if($min != "" && $max != "")
			$query->whereBetween("pratos.valor",array($min,$max));

			$exists = TipoPratoModel::where("nome","LIKE","%".$search["value"]."%")
					  ->get();
			if(count($exists) > 0)
				$query->where("tipo_prato.nome","LIKE","%".$search["value"]."%");
			else
				$query->where("pratos.nome","LIKE","%".$search["value"]."%");

		})
		->orderBy($columns[$orderIndex]["name"],$order["dir"])
		->take($limit)
		->skip($start)
		->get();
		
		$recordsFiltered = DB::select( DB::raw("SELECT FOUND_ROWS() AS total;") );
		$recordsFiltered = $recordsFiltered[0];
		$recordsFiltered = intval($recordsFiltered->total);

		$pratos = DB::table("pratos")
		->join("tipo_prato","pratos.cod_tipo_prato","=","tipo_prato.cod")
		->where("pratos.cod",$search["value"])
		->orWhere(function($query) use($min,$max,$search){
			if($min != "" && $max == "")
			$query->where("pratos.valor",">=",$min);
			if($max != "" && $min == "")
				$query->where("pratos.valor","<=",$max);
			if($min != "" && $max != "")
			$query->whereBetween("pratos.valor",array($min,$max));

			$exists = TipoPratoModel::where("nome","LIKE","%".$search["value"]."%")
					  ->get();
			if(count($exists) > 0)
				$query->where("tipo_prato.nome","LIKE","%".$search["value"]."%");
			else
				$query->where("pratos.nome","LIKE","%".$search["value"]."%");

		})
		->select("pratos.cod","tipo_prato.nome as tipo","pratos.nome as prato","pratos.valor","pratos.foto_url","pratos.deletada as prato_deletado")
		->orderBy($columns[$orderIndex]["name"],$order["dir"])
		->take($limit)
		->skip($start)
		->get();
		$json = [];
		$json["draw"] = intval($dados["draw"]);
		$json["recordsTotal"] = $recordsTotal;
		$json["recordsFiltered"] = $recordsFiltered;
		$json["aaData"] = array();
		foreach ($pratos as $key => $value) 
		{
			$value = (array)$value;

			$value["valor"] = number_format((float)$value["valor"], 2, '.', '');
			
			if($value["prato_deletado"] == 1)
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

		$join = DB::table("pratos")
		->join("tipo_prato","pratos.cod_tipo_prato","=","tipo_prato.cod")
		->where('pratos.cod',$codigo)
		->select("pratos.cod","tipo_prato.cod as cod_tipo_prato",
			"tipo_prato.nome as tipo","pratos.nome as prato",
			"pratos.valor","pratos.descricao as descricao","pratos.foto_url")
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

		$prato = DB::table("pratos")
		->where('pratos.cod',$codigo)
		->get();

		return json_encode($prato);
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

			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			    //deletar a foto antiga no Windows
				unlink($antiga_foto);
			}

			// salva a foto
			$extension = $file->getClientOriginalExtension();

			$path = "../app/uploads/pratos/";
			
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
		
		$result = DB::table('pratos')
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
		
		$isForeign = count(DB::table('item_pedido')
			->where('cod_prato',$id)->get());
		$isForeign = $isForeign || count(DB::table('prato_categoria')
			->where('cod_prato',$id)->get()) > 0;
		if($isForeign > 0)
		{
			$dados = array();
			$dados["deletada"] = 1;

			$result = DB::table('pratos')
			->where('cod', $id)
	        ->update($dados);
	        
	        if($result) return 1;
	        else return 0;
		}
		DB::table('pratos')->where('cod',$id)->delete();
		return 1;
	}

	
	/*******************************************
	*  Ação que retorna os dados para o select2
	********************************************/
	public function getListar(){

		if(Input::has("tipo"))
		{
			$tipo = Input::get("tipo");

			$pratos = DB::table("pratos")
			->where(function($query)use($tipo){
				if($tipo != 0)
					$query->where("cod_tipo_prato",$tipo);
			})
			->where("deletada","<>",1)
			->orderBy("pratos.nome","asc")
			->get();
		}
		
		return json_encode($pratos);
	}
	

}