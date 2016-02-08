<?php 

class DashboardController extends BaseController
{

	public function getIndex()
	{
		return Redirect::to('panel-control/dashboard');
	}

	public function getDashboard()
	{	Session::put('flag',1);

		$d = date("Y-m-d");
		$pdias = PedidosModel::where("data",$d)->get();
		$pmes = DB::select("SELECT * FROM `pedidos` WHERE MONTH(data) LIKE MONTH('{$d}')");
		$ppp = DB::table("item_pedido")
		->join("pratos","item_pedido.cod_prato","=","pratos.cod")
		->select(DB::raw("count(cod_prato) as qtd_prato,cod_prato,nome"))
		->groupBy("item_pedido.cod_prato")
		->get();

		$prato_mais_pedido = "";
		$aux = 0;
		foreach ($ppp as $key => $value) {
			if($aux < $value->qtd_prato)
			{
				$aux = $value->qtd_prato;
				$prato_mais_pedido = $value->nome;
			}
		}
		$qtd_pdias = count($pdias);
		$qtd_pmes = count($pmes);

		$table_clientes = DB::select(
		"SELECT count(pedidos.cod) as qtd_pedidos,max(pedidos.data) as ultimo_pedido,clientes.nome FROM `pedidos` 
		inner join clientes on pedidos.cod_cliente = clientes.cod 
		inner join item_pedido on item_pedido.cod_pedido = pedidos.cod 
		inner join pratos on item_pedido.cod_prato = pratos.cod 
		group by pedidos.cod_cliente 
		order by qtd_pedidos desc limit 10");


		$dados = 
		[
			"qtd_pdias" => $qtd_pdias,
			"qtd_pmes" => $qtd_pmes,
			"ppp" => $prato_mais_pedido,
			"tclientes" => $table_clientes
		];
		return View::make("dashboard")->with($dados);
	}

	public function getPerfil()
	{
		$funcionarios = FuncionariosModel::where('cod',Session::get('cod_user'))
		->get();
		if(isset($funcionarios[0]))
			$funcionarios = $funcionarios[0];
		$dados = 
		[
			'dados' => $funcionarios
		];
		return View::make("menu.perfil")->with($dados);
	}
	public function postPerfil()
	{
		$dados = Input::all();
		unset($dados["_token"]);
		unset($dados["confirmacao"]);
		if(!Session::has('cod_user'))
			return 0;
		$codigo = Session::get('cod_user');
		if(isset($dados["senha"]))
			$dados["senha"] = sha1($dados["senha"]);

		$result = DB::table('funcionarios')
        ->where('cod', $codigo)
        ->update($dados);
        
        if($result)
			$msg = "1#".Lang::get('geral.msg_perfil_atualizado_sucesso');
		else
			$msg = "2#".Lang::get('geral.msg_erro');

		Session::flash("msg",$msg);
		return Redirect::back();
	}
	
	public function getLogout()
	{
		Session::forget('cod_user');
		Session::forget('nome_user');
		Session::forget('tipo_user');

		return Redirect::to("/");
	}
}