<?php 


class AndroidController extends BaseController{

	/* 
		O Appid é um validador para certificar que apenas o aplicativo tenha
		acesso a rota do Android.
	*/
	protected $appid = 2601201612071423542;

	/*******************************************
	*  Faz a validação dos dados de um cliente
	*  no aplicativo
	********************************************/
	public function postLogin()
	{
		$dados = Input::all();
		
		if(!isset($dados["appid"]) || $this->appid != intval($dados["appid"]))
		{
			$response = array();
			$response['error'] = true;
	        $response['message'] = Lang::get('geral.acesso_negado');
	        return json_encode($response);

		}

		$cliente = ClientesModel::where("login",$dados["login"])
		->where("senha",sha1($dados["senha"]))
		->get();
		
		$response = array();
		$response['error'] = false;
        $response['message'] = "";

        if(count($cliente) > 0)
        {
        	if(isset($cliente[0]))
        	{
        		$cliente = $cliente[0];
	        	$response["error"] = false;
	            $response['cod_usuario'] = $cliente->cod;
	            $response['login'] = $cliente->login;
	            $response['nome'] = $cliente->nome;
	            $response['endereco'] = $cliente->endereco;
	            $response['cidade'] = $cliente->cidade;
	            $response['telefone'] = $cliente->telefone;
	            $response['email'] = $cliente->email;
	           
        	}
            else
            {
            	$response['error'] = true;
            	$response['message'] = Lang::get('geral.msg_user_inexistente');
            }
        }
        else
        {
        	$response['error'] = true;
            $response['message'] = Lang::get('geral.msg_user_inexistente');
        }

        return json_encode($response);
	}


	/*******************************************
	*  Cadastra um novo cliente no aplicativo
	********************************************/
	public function postNovocliente(){

		$json_cliente = Input::get("json_usuario");
		$json_cliente = json_decode($json_cliente);

		$response = array();
		
        $dados = array();
        $dados["login"] = $json_cliente->login;
        $dados["senha"] = sha1($json_cliente->senha);
        $dados["nome"] = $json_cliente->nome;
        $dados["endereco"] = $json_cliente->endereco;
        $dados["cidade"] = $json_cliente->cidade;
        $dados["telefone"] = $json_cliente->telefone;
        $dados["email"] = $json_cliente->email;
        $dados["data"] = date('Y-m-d');
		
        $exists = count(ClientesModel::where("nome",$dados["nome"])->get()) > 0;
        if($exists)
        {
        	$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_ja_existe');
			return json_encode($response); 
        }

		$cliente = new ClientesModel($dados);
		$status = $cliente->save();
		if($status)
		{
			$response['error'] = false;
			$response['message'] = Lang::get('geral.msg_cadastro_sucesso');
			$dados["cod"] = $cliente->cod;
			$response["usuario"] = json_encode($dados);

		}
		else
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro');
		}

        return json_encode($response);
	}

	/*******************************************
	*  Busca todas as bebidas
	********************************************/
	public function getBebidas()
	{
		$appid = Input::get('appid');

		if(!isset($appid) || $this->appid != intval($appid))
		{
			$response = array();
			$response['error'] = true;
	        $response['message'] = Lang::get('geral.acesso_negado');
	        return json_encode($response);
		}

		$bebidas = DB::select("SELECT bebidas.cod, bebidas.nome, bebidas.valor, 
		bebidas.foto_url,sum(estoque_bebidas.qtd_atual) total_estoque
		FROM `estoque_bebidas` inner join bebidas 
		on bebidas.cod = estoque_bebidas.cod_bebida
		where bebidas.deletada <> 1 and estoque_bebidas.qtd_atual > 0
		group by estoque_bebidas.cod_bebida
		order by bebidas.nome");

		$response = array();
		if(count($bebidas) == 0)
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro');
		}
		else
		{
			$response['error'] = false;
			$response['message'] = "";
			for ($i=0; $i < count($bebidas); $i++) { 
				if($bebidas[$i]->foto_url != null)
				{
					$path = Request::root().$bebidas[$i]->foto_url;
					$foto = file_get_contents($path);
					$bebidas[$i]->foto_url = base64_encode($foto);
				}
			}
			$response['bebidas'] = $bebidas;
		}
		return json_encode($response);
	}

	/*******************************************
	*  Busca todos os Tipos de Pratos
	********************************************/
	public function getCardapio()
	{

		$appid = Input::get('appid');

		if(!isset($appid) || $this->appid != intval($appid))
		{
			$response = array();
			$response['error'] = true;
	        $response['message'] = Lang::get('geral.acesso_negado');
	        return json_encode($response);

		}

		$tipos = TipoPratoModel::
		where("deletada","<>",1)
		->orderBy("nome","asc")->get();
		
		$response = array();
		if(count($tipos) == 0)
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro');
		}
		else
		{
			$response['error'] = false;
			$response['message'] = "";
			for ($i=0; $i < count($tipos); $i++) { 
				if($tipos[$i]->foto_url != null)
				{
					$path = Request::root().$tipos[$i]->foto_url;
					$foto = file_get_contents($path);
					$tipos[$i]->foto_url = base64_encode($foto);
				}
			}
			$response['cardapio'] = $tipos;
		}
		return json_encode($response);

	}
	/*******************************************
	*  Busca todos os pratos por um tipo especifico
	********************************************/
	public function getPratos()
	{
		$cod_tipo_prato = Input::get('cod_tipo_prato');
		$appid = Input::get('appid');

		if(!isset($appid) || $this->appid != intval($appid))
		{
			$response = array();
			$response['error'] = true;
	        $response['message'] = Lang::get('geral.acesso_negado');
	        return json_encode($response);

		}

		if($cod_tipo_prato == null)
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro');
			return json_encode($response);
		}


		$pratos = PratosModel::
		where("deletada","<>",1)
		->where("cod_tipo_prato",$cod_tipo_prato)
		->orderBy("nome","asc")
		->get();

		$response = array();
		if(count($pratos) == 0)
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro');
		}
		else
		{
			$response['error'] = false;
			$response['message'] = "";
			for ($i=0; $i < count($pratos); $i++) { 
				if($pratos[$i]->foto_url != null)
				{
					$path = Request::root().$pratos[$i]->foto_url;
					$foto = file_get_contents($path);
					$pratos[$i]->foto_url = base64_encode($foto);
				}
			}
			$response['pratos'] = $pratos;
		}
		return json_encode($response);
	}

	/**********************************************************
	*  Busca as Variedades e Adicionais de um prato especifico
	***********************************************************/
	public function getDetalhesprato()
	{
		$cod_prato = Input::get('cod_prato');
		$appid = Input::get('appid');

		if(!isset($appid) || $this->appid != intval($appid))
		{
			$response = array();
			$response['error'] = true;
	        $response['message'] = Lang::get('geral.acesso_negado');
	        return json_encode($response);

		}

		if($cod_prato == null)
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro');
			return json_encode($response);
		}


		$variedades = DB::table("prato_variedade")
		->join("variedades","prato_variedade.cod_variedade","=","variedades.cod")
		->where("variedades.deletada","<>",1)
		->where("cod_prato",$cod_prato)
		->orderBy("variedades.nome","asc")
		->get();

		$response = array();
		if(count($variedades) == 0)
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro_variedades');
			return $response;
		}

		$categorias = DB::table("prato_categoria")
		->join("categorias","prato_categoria.cod_categoria","=","categorias.cod")
		->where("categorias.deletada","<>",1)
		->where("cod_prato",$cod_prato)
		->orderBy("categorias.cod","asc")
		->get();


		$response['error'] = false;
		$response['message'] = "";
		$response['variedades'] = $variedades;
		$response['qtd_variedades'] = count($variedades);
		
		$response["categorias"] = array();
		$response['qtd_categorias'] = count($categorias);

		foreach ($categorias as $key_ct => $cat) {
			$ct = array();
			$ct["cod_categoria"] = $cat->cod_categoria;
			$ct["nome_categoria"] = $cat->nome;
			$ct["limite"] = $cat->limite;
			
			$ct["adicionais"] = array();

			$adicionais = DB::table("adicionais")
			->join("produtos","adicionais.cod_produto","=","produtos.cod")
			->where("adicionais.cod_categoria",$cat->cod_categoria)
			->where("produtos.deletada","<>",1)
			->select("adicionais.cod as cod_adicional","produtos.nome as produto")
			->orderBy("adicionais.cod_categoria","asc")
			->orderBy("produtos.nome","asc")
			->get();

			$ct["qtd_adicional"] = count($adicionais);

			foreach ($adicionais as $key_ad => $adc) {
				$ad = array();
				$ad["cod_adicional"] = $adc->cod_adicional;
				$ad["produto"] = $adc->produto;
				array_push($ct["adicionais"], $ad);
			}
			array_push($response["categorias"], $ct);
		}
		
		return json_encode($response);
	}

	/*******************************************
	*  Cadastra um novo pedido
	********************************************/
	public function postNovopedido(){

		$appid = Input::get('appid');
		$response = array();

		if(!isset($appid) || $this->appid != intval($appid))
		{
			$response = array();
			$response['error'] = true;
	        $response['message'] = Lang::get('geral.acesso_negado');
	        return json_encode($response);

		}

		$json_pedido = Input::get("pedido");
		$json_pedido = json_decode($json_pedido);
		// validar se o cliente existe

		$exists = ClientesModel::where("cod",$json_pedido->cod_cliente)->get();
		if(count($exists) == 0)
		{
			$response['error'] = true;
	        $response['message'] = Lang::get('geral.msg_user_inexistente');
	        return json_encode($response);
		}

		$pedido = array();
		$pedido["cod_cliente"] = intval($json_pedido->cod_cliente);
		$pedido["horario"] = $json_pedido->horario;
		$pedido["data"] = $json_pedido->data;
		$pedido["valor_total"] = floatval($json_pedido->valor_total);
		$pedido["status"] = 1;
		$pedido["origem"] = 2;
		$pedido["observacoes"] = $json_pedido->observacoes;

		$p = new PedidosModel($pedido);
		$p->save();
		$cod_pedido = $p->cod;

		// cadastro das bebidas adicionadas no pedido
		$json_bebidas = Input::get("itens_bebida");
		$json_bebidas = json_decode($json_bebidas);
		
		$bebida = array();
		foreach ($json_bebidas as $key => $json) {

			$bebida["cod_pedido"] = $cod_pedido;
			$bebida["cod_bebida"] = $json->cod_bebida;
			$bebida["quantidade"] = $json->quantidade;
			$status = ItemPedidoBebidaModel::saveMultipleKeys($bebida);

			if(!$status)
			{
				$response['error'] = true;
		        $response['message'] = Lang::get('geral.msg_erro');
		        return json_encode($response);
			}

		}

		// cadastro dos pratos adicionados no pedido

		$json_itens_pedido = Input::get("itens_pedido");
		$json_itens_pedido = json_decode($json_itens_pedido);
		
		$item_pedido_variedades = Input::get("item_pedido_variedades");
		$item_pedido_variedades = json_decode($item_pedido_variedades);

		$item_pedido_adicionais = Input::get("item_pedido_adicionais");
		$item_pedido_adicionais = json_decode($item_pedido_adicionais);

		foreach ($json_itens_pedido as $key_1 => $json) {

			$item_pedido = array();
			$item_pedido["cod_pedido"] = $cod_pedido;
			$item_pedido["cod_prato"] = $json->cod_prato;
			$item_pedido["quantidade"] = $json->quantidade;
			
			$iped = new ItemPedidoModel($item_pedido);
			$iped->save();
			$status = $iped->cod_item;

			if(!$status)
			{
				$response['error'] = true;
		        $response['message'] = Lang::get('geral.msg_erro');
		        return json_encode($response);
			}
			
			
			foreach ($item_pedido_variedades as $key_2 => $json_var) {
				
				// cod_item gerado por mim no android (temporário)
				if($json->cod_item == $json_var->cod_item)
				{
					$item_variedade = array();
					$item_variedade["cod_item"] = intval($iped->cod_item);// cod_item gerado no banco de dados
					$item_variedade["cod_prato"] = intval($json->cod_prato);
					$item_variedade["cod_variedade"] = intval($json_var->cod_variedade);

					$status = ItemPedidoVariedadeModel::saveMultipleKeys($item_variedade);
					
					if(!$status)
					{
						$response['error'] = true;
				        $response['message'] = Lang::get('geral.msg_erro');
				        return json_encode($response);
					}
				}	
			}

			foreach ($item_pedido_adicionais as $key_3 => $json_ad) {

				// cod_item gerado por mim no android (temporário)
				if($json->cod_item == $json_ad->cod_item)
				{
					$item_adicional = array();
					$item_adicional["cod_item"] = intval($iped->cod_item);// cod_item gerado no banco de dados
					$item_adicional["cod_prato"] = intval($json->cod_prato);
					$item_adicional["cod_adicional"] = intval($json_ad->cod_adicional);

					$status = ItemPedidoAdicionalModel::saveMultipleKeys($item_adicional);
					
					if(!$status)
					{
						$response['error'] = true;
				        $response['message'] = Lang::get('geral.msg_pedido_enviado');
				        return json_encode($response);
					}
				}	
			}
		}

		$response["error"] = false;
		$response["message"] =  Lang::get('geral.msg_pedido_enviado');
		
        return json_encode($response);
	}

	/**********************************************************
	*  Busca todos os Pedidos e monta um JSON igual ao criado no APP
	***********************************************************/
	public function getPedidos()
	{
		$cod_cliente = Input::get('cod_cliente');
		$appid = Input::get('appid');

		$response = array();

		if(!isset($appid) || $this->appid != intval($appid))
		{
			
			$response['error'] = true;
	        $response['message'] = Lang::get('geral.acesso_negado');
	        return json_encode($response);

		}

		if($cod_cliente == null)
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro');
			return json_encode($response);
		}

		$pedidos = PedidosModel::where("cod_cliente",$cod_cliente)
		->orderBy("cod","desc")
		->take(5)
		->get();

		$response["pedidos"] = $pedidos;
		$response['error'] = false;
		return json_encode($response);
	}

	/**********************************************************
	*  Busca todos os Pedidos e monta um JSON igual ao criado no APP
	***********************************************************/
	public function getPedidoitens()
	{
		$cod_pedido = Input::get('cod_pedido');
		$appid = Input::get('appid');
		$response = array();

		if(!isset($appid) || $this->appid != intval($appid))
		{
			
			$response['error'] = true;
	        $response['message'] = Lang::get('geral.acesso_negado');
	        return json_encode($response);

		}

		if($cod_pedido == null)
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro');
			return json_encode($response);
		}

		$itens = DB::table("item_pedido")
		->join("pratos","item_pedido.cod_prato","=","pratos.cod")
		->where("cod_pedido",$cod_pedido)
		->get();

		$response["itens"] = array();
		foreach ($itens as $key_1 => $item) {
			
			$itmp = array();
			$itmp["prato"] = $item->nome;
			$itmp["quantidade"] = $item->quantidade;
			$itmp["total"] = ($item->valor * $item->quantidade);
			$itmp["variedades"] = array();
			$itmp["adicionais"] = array();

			$variedade = DB::table("item_pedido_variedade")
			->join("variedades","item_pedido_variedade.cod_variedade","=","variedades.cod")
			->where("item_pedido_variedade.cod_item",$item->cod_item)
			->get();
			foreach ($variedade as $key_v => $v) {
				$vtmp = array();
				$vtmp["variedade"] = $v->nome;
				array_push($itmp["variedades"], $vtmp);
			}

			$adicionais = DB::table("item_pedido_adicional")
			->join("adicionais","item_pedido_adicional.cod_adicional","=","adicionais.cod")
			->join("produtos","adicionais.cod_produto","=","produtos.cod")
			->where("item_pedido_adicional.cod_item",$item->cod_item)
			->select("produtos.nome as produto","item_pedido_adicional.cod_adicional")
			->get();

			foreach ($adicionais as $key_ad => $ad) {
				$adtmp = array();
				$adtmp["cod_adicional"] = $ad->cod_adicional;
				$adtmp["produto"] = $ad->produto;
				array_push($itmp["adicionais"], $adtmp);
			}

			array_push($response["itens"], $itmp);
		}

		$response["bebidas"] = array();

		$bebidas = DB::table("itens_pedido_bebida")
		->join("bebidas","itens_pedido_bebida.cod_bebida","=","bebidas.cod")
		->where("itens_pedido_bebida.cod_pedido",$cod_pedido)
		->orderBy("bebidas.nome","asc")
		->get();

		foreach ($bebidas as $key => $bb) {
			$btmp = array();
			$btmp["cod_bebida"] = $bb->cod;
			$btmp["nome"] = $bb->nome;
			$btmp["quantidade"] = $bb->quantidade;
			$btmp["total"] = ($bb->valor * $bb->quantidade);

			array_push($response["bebidas"], $btmp);
		}

		$response['error'] = false;
		$response['update'] = false;
		return json_encode($response);
	}

	/*******************************************
	*  Faz o cancelamento do pedido
	********************************************/
	public function postCancelarpedido(){

		$cod_pedido = Input::get('cod_pedido');
		$appid = Input::get('appid');
		
		$response = array();

		if(!isset($appid) || $this->appid != intval($appid))
		{
			
			$response['error'] = true;
	        $response['message'] = Lang::get('geral.acesso_negado');
	        return json_encode($response);

		}

		if($cod_pedido == null)
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro');
			return json_encode($response);
		}


		$dados = array();
		$dados["status"] = 6;

		$result = DB::table('pedidos')
        ->where('cod', $cod_pedido)
        ->update($dados);
        if($result)
        {
        	$response['error'] = false;
        	$response['update'] = true;
			$response['message'] = Lang::get('geral.msg_pedido_cancelado');
        }
        else
        {
        	$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro');
        }
        
		return json_encode($response);
	}

	/*******************************************
	*  Envia uma sugestão ao sistema
	********************************************/
	public function postMensagem()
	{
		$dados = Input::all();
		$response = array();

		$cm = new ComentarioModel($dados);
		$status = $cm->save();

		if($status)
		{
			$response['error'] = false;
        	$response['message'] = Lang::get('geral.msg_sugestao_enviada');
		}
		else
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro');
		}

		return json_encode($response);
		
	}

	/*******************************************
	*  Envia a atualização do perfil do cliente
	********************************************/
	public function postPerfil()
	{
		$json_cliente = Input::get("json_usuario");
		$json_cliente = json_decode($json_cliente);
		$appid = Input::get('appid');
		
		$response = array();

		if(!isset($appid) || $this->appid != intval($appid))
		{
			
			$response['error'] = true;
	        $response['message'] = Lang::get('geral.acesso_negado');
	        return json_encode($response);

		}

		$codigo = $json_cliente->codigo;
		$dados = array();

		if(isset($json_cliente->senha) && $json_cliente->senha != "")
			$dados["senha"] = sha1($json_cliente->senha);

		$dados["login"] = $json_cliente->login;
		$dados["nome"] = $json_cliente->nome;
		$dados["endereco"] = $json_cliente->endereco;
		$dados["cidade"] = $json_cliente->cidade;
		$dados["telefone"] = $json_cliente->telefone;
		$dados["email"] = $json_cliente->email;

		$result = DB::table('clientes')
        ->where('cod', $codigo)
        ->update($dados);
        if($result)
        {
	        $response['error'] = false;
		    $response['message'] = Lang::get('geral.msg_atualizar_sucesso');
		}
		else
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro_atualizacao');
		}

		return json_encode($response);
		
	}

	public function getSuporteandroid(){

		return View::make("suporte.suporteandroid");
	}

	public function getRecuperar()
	{
		$email = Input::get("email");

		$exists = ClientesModel::where("email",$email)->get();
		$response = array();


		if(count($exists) == 0)
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_email_nao_localizado');
			return json_encode($response);
		}

		if(isset($exists[0]))
			$exists = $exists[0];
		
		$dados = array();
		$dados["senha"] = sha1("123");
		$dados["login"] = "cliente".$exists->cod;

		$result = DB::table('clientes')
        ->where('cod', $exists->cod)
        ->update($dados);

        if($result)
        {
			$data = [
			'nome' => $exists->nome,
			'codigo' => $exists->cod
			];

			/* ENVIA O EMAIL */
				Mail::send('emails.recuperacao',$data , function($m) use($email){
					$m->to($email)->subject("Recuperação de Login e Senha ");
				});

			$response['error'] = false;
			$response['message'] = Lang::get('geral.msg_email_recuperacao');
		}
		else
		{
			$response['error'] = true;
			$response['message'] = Lang::get('geral.msg_erro');
		}
		
		return json_encode($response);
	}



}