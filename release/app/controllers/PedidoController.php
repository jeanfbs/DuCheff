<?php 


class PedidoController extends BaseController{



	public function getIndex(){

		Session::put('flag',11);
		
		$dados["status_notificacao"] = 2;
		$result = DB::table('pedidos')
		->where("status",1)
        ->update($dados);
        
		return View::make("pedidos.pedidos");
	}
	/*******************************************
	*  Ação que retorna a View de Cadastro para 
	*  Tab.
	********************************************/
	public function getCadastro()
	{
		
		return View::make("pedidos.cadastro");
	}

	/*******************************************
	*  Metodo que cadastra as informações de 
	*  pedido via Ajax
	********************************************/
	public function postCadastro()
	{
		if(Input::has("pedido"))
		{
			$dados = Input::get("pedido");
			
			// verifica se o cliente existe
			if(isset($dados["cliente"]) && intval($dados["tipo_pedido"]) == 0)
			{

				$exists = ClientesModel::where("nome","LIKE","%".$dados["cliente"]."%")
				->get();
				$cod_cliente = 0;
				$status = 0;

				if(count($exists) == 0)
				{
					$dados_cliente = array();
					$dados_cliente["nome"] = $dados["cliente"];
					$dados_cliente["endereco"] = $dados["endereco"];
					$dados_cliente["telefone"] = $dados["telefone"];

					$cliente = new ClientesModel($dados_cliente);
					$status = $cliente->save();
					$cod_cliente = $cliente->cod;
				}
				else
				{
					$cod_cliente = $exists[0]->cod;

				}
			}//fim do if do cliente
			
			$dados_pedido = array();
			$dados_pedido["cod_cliente"] = ((isset($cod_cliente) ? $cod_cliente: null));
			$dados_pedido["horario"] = $dados["horario"];
			$explode = explode("/",$dados["data_pedido"]);
			$dd = $explode[0];
			$mm = $explode[1];
			$yy = $explode[2];
			$dados_pedido["data"] = $yy."-".$mm."-".$dd;
			$dados_pedido["nro_mesa"] = $dados["nro_mesa"];
			$dados_pedido["valor_total"] = $dados["valor_total"];
			$dados_pedido["origem"] = $dados["origem"];
			$dados_pedido["observacoes"] = $dados["observacoes"];

			$pedido = new PedidosModel($dados_pedido);
			$status = $pedido->save();
			$cod_pedido = $pedido->cod;

			foreach($dados["itens"] as $key => $item) {

				$dados_item = array();
				$dados_item["cod_pedido"] = $cod_pedido;
				$dados_item["cod_prato"] = intval($item["cod_prato"]);
				$dados_item["quantidade"] = intval($item["quantidade"]);
				
				$item_pedido = new ItemPedidoModel($dados_item);
				$status = $item_pedido->save();
				$cit = $item_pedido->cod_item;
				if(isset($item["variedades"]))
				{
					foreach ($item["variedades"] as $key_variedade => $codv) {
					
						$dados_variedade = array();
						$dados_variedade["cod_item"] = $cit;
						$dados_variedade["cod_prato"] = intval($item["cod_prato"]);
						$dados_variedade["cod_variedade"] = intval($codv);

						$status = ItemPedidoVariedadeModel::saveMultipleKeys($dados_variedade);
					}
				}
				if(isset($item["adicionais"]))
				{
					foreach ($item["adicionais"] as $key_adicional => $codad) {

						$dados_adicional = array();
						$dados_adicional["cod_item"] = $cit;
						$dados_adicional["cod_prato"] = intval($item["cod_prato"]);
						$dados_adicional["cod_adicional"] = intval($codad);
						
						$status = ItemPedidoAdicionalModel::saveMultipleKeys($dados_adicional);
					}
				}

			}// fim do for para os itens

			
			if(isset($dados["bebidas"]))
			{
				foreach ($dados["bebidas"] as $key_bebidas => $item_bebida) {
					
					$dados_bebida = array();
					$dados_bebida["cod_pedido"] = $cod_pedido;
					$dados_bebida["cod_bebida"] = intval($item_bebida["cod"]);
					$dados_bebida["quantidade"] = intval($item_bebida["quantidade"]);
					
					$status = ItemPedidoBebidaModel::saveMultipleKeys($dados_bebida);
				}
			}

			if($status) return 1;
			else 		return 0;

		}//fim do if
		
	}
	/*******************************************
	*  Ação que retorna a View de Pedidos Enviados
	********************************************/
	public function getPedidosenviados()
	{
		return View::make("pedidos.pesquisa");
	}

	/*******************************************
	*  Ação que busca todos os pedidos enviados
	********************************************/
	public function postPedidosenviados()
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

		$recordsTotal = count(PedidosModel::get());

		if($limit == -1)
			$limit = $recordsTotal;

		$pedidos = DB::table("pedidos")
		->leftJoin("clientes","clientes.cod","=","pedidos.cod_cliente")
		->select(DB::raw('SQL_CALC_FOUND_ROWS *'))
		->whereIn("pedidos.status",array(1,2))
		->orderBy("pedidos.cod","asc")
		->take($limit)
		->skip($start)
		->get();
		
		
		$recordsFiltered = DB::select( DB::raw("SELECT FOUND_ROWS() AS total;") );
		$recordsFiltered = $recordsFiltered[0];
		$recordsFiltered = intval($recordsFiltered->total);

		$pedidos = DB::table("pedidos")
		->leftJoin("clientes","clientes.cod","=","pedidos.cod_cliente")
		->whereIn("pedidos.status",array(1,2))
		->select("pedidos.cod","pedidos.nro_mesa","clientes.nome","pedidos.data",
			"pedidos.horario","pedidos.status","pedidos.origem","pedidos.valor_total")
		->orderBy("pedidos.cod","asc")
		->take($limit)
		->skip($start)
		->get();
		$json = [];
		$json["draw"] = intval($dados["draw"]);
		$json["recordsTotal"] = $recordsTotal;
		$json["recordsFiltered"] = $recordsFiltered;
		$json["aaData"] = array();
		foreach ($pedidos as $key => $value) 
		{
			$value = (array)$value;

			switch(intval($value["status"]))
			{
				case 1:
					$value["status"] = "<span cod_status=".intval($value["status"]).">".Lang::get('geral.status_enviado')."</span>";
				break;
				case 2:
					$value["status"] = "<span class='text-primary' cod_status=".intval($value["status"]).">".Lang::get('geral.status_aceito')."</span>";
				break;
				case 3:
					$value["status"] = "<span class='text-primary' cod_status=".intval($value["status"]).">".Lang::get('geral.status_rejeitado')."</span>";
				break;
				case 4:
					$value["status"] = "<span class='text-primary' cod_status=".intval($value["status"]).">".Lang::get('geral.status_pronto')."</span>";
				break;
				case 5:
					$value["status"] = "<span class='text-primary' cod_status=".intval($value["status"]).">".Lang::get('geral.status_pago')."</span>";
				break;
				case 6:
					$value["status"] = "<span class='text-primary' cod_status=".intval($value["status"]).">".Lang::get('geral.status_cancelado')."</span>";
				break;
			}

			if(intval($value["origem"]) == 1)
			{
				$value["origem"] = '<i class="fa fa-cloud"></i> '.Lang::get('geral.org_web');
			}
			else
			{
				$value["origem"] = '<i class="fa fa-mobile"></i> '.Lang::get('geral.org_app');
			}
			
			$value["valor_total"] = Lang::get('geral.rs')." ".number_format((float)$value["valor_total"], 2, '.', '');
			array_push($json["aaData"], array_values($value));
		}
		
		return json_encode($json);
	}

	/*******************************************
	*  Ação de solicitação Ajax que retorna
	*  todos os dados de um pedido
	********************************************/
	public function getPedido()
	{

		$codigo = Input::get('codigo');

		$ped = DB::table("pedidos")
		->leftJoin("clientes","clientes.cod","=","pedidos.cod_cliente")
		->where("pedidos.cod",$codigo)
		->select("pedidos.cod as cod_pedido","clientes.cod as cod_cliente","clientes.nome",
			"clientes.endereco","clientes.telefone","pedidos.data",
			"pedidos.status","pedidos.horario","pedidos.nro_mesa","pedidos.valor_total",
			"pedidos.observacoes")
		->get();

		if(isset($ped[0]))
			$ped = $ped[0];

		$json = array();

		$cod_pedido = intval($ped->cod_pedido);
		$json["cod_pedido"] = $cod_pedido;
		$json["status"] = $ped->status;
		$json["cliente"] = $ped->nome;
		$json["endereco"] = $ped->endereco;
		$json["telefone"] = $ped->telefone;
		
		$explode_1 = explode("-",$ped->data);
		$json["data"] = $explode_1[2]."/".$explode_1[1]."/".$explode_1[0];
		
		$json["horario"] = $ped->horario;
		$json["nro_mesa"] = $ped->nro_mesa;
		$json["valor_total"] = $ped->valor_total;
		$json["observacoes"] = $ped->observacoes;

		$json["bebidas"] = array();

		// bebidas do pedido
		$itb = DB::table("itens_pedido_bebida")
		->join("bebidas","itens_pedido_bebida.cod_bebida","=","bebidas.cod")
		->where("itens_pedido_bebida.cod_pedido",$cod_pedido)
		->orderBy("bebidas.nome","asc")
		->get();

		foreach ($itb as $key => $value) {
			array_push($json["bebidas"], $value->nome);
		}

		$json["itens"] = array();

		// recupera todos os itens do pedido
		$itsp = DB::table("item_pedido")
		->join("pratos","item_pedido.cod_prato","=","pratos.cod")
		->where("item_pedido.cod_pedido",$cod_pedido)
		->orderBy("item_pedido.cod_item","asc")
		->get();

		foreach ($itsp as $key => $value) 
		{
			$item = array();


			$item["prato"] = $value->nome;
			$item["quantidade"] = $value->quantidade;
			$item["variedades"] = array();
			$itpv = DB::table("item_pedido_variedade")
			->join("variedades","item_pedido_variedade.cod_variedade","=","variedades.cod")
			->where("item_pedido_variedade.cod_item",$value->cod_item)
			->get();

			foreach ($itpv as $key_v => $value_v) {

				array_push($item["variedades"],$value_v->nome);
			}

			$item["adicionais"] = array();

			$itpcat = DB::table("item_pedido_adicional")
			->join("adicionais","item_pedido_adicional.cod_adicional","=","adicionais.cod")
			->join("produtos","produtos.cod","=","adicionais.cod_produto")
			->join("categorias","categorias.cod","=","adicionais.cod_categoria")
			->select("produtos.nome as produto","categorias.nome as categoria")
			->where("item_pedido_adicional.cod_item",$value->cod_item)
			->get();
			$cat = array();
			foreach ($itpcat as $key_cat => $value_cat) {
				if(!isset($cat[$value_cat->categoria]))
					$cat[$value_cat->categoria] = array();
				array_push($cat[$value_cat->categoria],$value_cat->produto);				
			}
			$item["adicionais"] = $cat;
			array_push($json["itens"], $item);


		}//fim do for de itens

		return json_encode($json);
	}

	/*******************************************
	*  Modifica o status do pedido de acordo
	*  com o parametro informado
	********************************************/
	public function postStatus()
	{

		$dados = Input::all();
		$codigo = $dados["codigo"];
		$dados["status"] = 3;
		unset($dados["codigo"]);
		unset($dados["_token"]);
		$result = DB::table('pedidos')
        ->where('cod', $codigo)
        ->update($dados);
        
        if($result)
			return 1;
		else
			return 0;
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
		
		$isForeign = count(DB::table('relacao_pedido_bebida')->where('cod_bebida',$id)->get());
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
	*  Busca todos os adicionais com suas categorias
	*  de um prato especifico juntamente com as variedades
	********************************************/
	public function getDetalhes(){

		if(Input::has("cod_prato"))
		{
			$cod_prato = Input::get("cod_prato");

			$categorias = DB::table("prato_categoria")
			->join("categorias","categorias.cod","=","prato_categoria.cod_categoria")
			->where("prato_categoria.cod_prato",$cod_prato)
			->orderBy("categorias.nome","asc")
			->get();

			$tmp = DB::table("prato_categoria")
			->where("prato_categoria.cod_prato",$cod_prato)
			->get();

			$codsc = array();

			foreach ($tmp as $key => $value) {
				array_push($codsc, $value->cod_categoria);
			}

			
			$adicionais = DB::table("adicionais")
			->join("produtos","adicionais.cod_produto","=","produtos.cod")
			->whereIn("adicionais.cod_categoria",$codsc)
			->select("adicionais.cod as cod","produtos.cod as cod_produto","adicionais.cod_categoria",
				"produtos.nome","produtos.deletada")
			->orderBy("adicionais.cod_categoria","asc")
			->get();
			
			$dados = 
			[
				'categorias' => $categorias,
				'adicionais' => $adicionais
			];
			return json_encode($dados);


		}
	}

	public function getNovospedidos(){

		$pedidos = PedidosModel::
		where("status_notificacao",1)
		->get();
		return count($pedidos);
	}
	
}