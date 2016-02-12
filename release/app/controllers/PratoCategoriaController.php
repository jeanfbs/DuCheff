<?php 

/**
*       TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*       
*       Controlador de Prato Categoria
*
*       @author: Jean Fabrício <jeanufu21@gmail.com>
*       @since 12/02/2016
*       
*/
class PratoCategoriaController extends BaseController{

	public function getIndex(){

		return View::make("cardapio.pratos.adicionais");
	}
	/*******************************************
	*  Faz a busca dos dados armazenados
	********************************************/
	public function getPesquisar(){
		$dados = Input::all();
		
		$pratos_categorias = DB::table("prato_categoria")
		->join("pratos","pratos.cod","=","prato_categoria.cod_prato")
		->join("categorias","categorias.cod","=","prato_categoria.cod_categoria")
		->where(function($query)use($dados){
			if(isset($dados["filtro"]) && isset($dados["valor_buscado"]))
			{
				$query->where($dados["filtro"],"LIKE","%".$dados["valor_buscado"]."%");
			}
		})
		->select("prato_categoria.cod_prato","prato_categoria.cod_categoria",
			"categorias.nome as categoria","pratos.nome as prato","prato_categoria.limite")
		->orderBy("pratos.nome","asc")
		->get();

		return json_encode($pratos_categorias);
	}
	/*******************************************
	*  Faz o cadastro das categorias para um pratos
	********************************************/
	public function postCadastrar(){
		
		$dados = Input::all();
		unset($dados["_token"]);
		$exists = PratoCategoriaModel::where("cod_prato",$dados["cod_prato"])
		->where("cod_categoria",$dados["cod_categoria"])
		->get();
		if(count($exists) > 0)
			return 2;
		
		PratoCategoriaModel::saveMultipleKeys($dados);
		return 1;

	}
	/*******************************************
	*  Ação que faz a exclusão dos dados
	********************************************/
	public function getDeletar(){
		
		$dados = Input::all();
		$explode = explode("#",$dados["codigo"]);
		$cod_prato = intval($explode[0]);
		$cod_categoria = intval($explode[1]);

		DB::table('prato_categoria')
		->where('cod_prato',$cod_prato)
		->where('cod_categoria',$cod_categoria)
		->delete();
		return 1;
	}

}