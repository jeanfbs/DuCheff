<?php 

/**
*       TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*       
*       Controlador de Prato Variedade
*
*       @author: Jean Fabrício <jeanufu21@gmail.com>
*       @since 12/02/2016
*       
*/
class PratoVariedadeController extends BaseController{

	public function getIndex(){

		return View::make("cardapio.pratos.variedades");
	}
	/*******************************************
	*  Faz a busca dos dados armazenados
	********************************************/
	public function getPesquisar(){
		$dados = Input::all();

		$pratos_variedades = DB::table("prato_variedade")
		->join("pratos","pratos.cod","=","prato_variedade.cod_prato")
		->join("variedades","variedades.cod","=","prato_variedade.cod_variedade")
		->where(function($query)use($dados){
			if(isset($dados["filtro"]) && isset($dados["valor_buscado"]))
			{
				$query->where($dados["filtro"],"LIKE","%".$dados["valor_buscado"]."%");
			}
		})
		->select("prato_variedade.cod_prato","prato_variedade.cod_variedade",
			"variedades.nome as variedade","pratos.nome as prato")
		->orderBy("pratos.nome","asc")
		->get();

		return json_encode($pratos_variedades);
	}
	/*******************************************
	*  Faz o cadastro das variedades para um pratos
	********************************************/
	public function postCadastrar(){
		
		$dados = Input::all();
		unset($dados["_token"]);
		$exists = PratoVariedadeModel::where("cod_prato",$dados["cod_prato"])
		->where("cod_variedade",$dados["cod_variedade"])
		->get();
		if(count($exists) > 0)
			return 2;
		
		PratoVariedadeModel::saveMultipleKeys($dados);
		return 1;

	}
	/*******************************************
	*  Ação que faz a exclusão dos dados
	********************************************/
	public function getDeletar(){
		
		$dados = Input::all();
		$explode = explode("#",$dados["codigo"]);
		$cod_prato = intval($explode[0]);
		$cod_variedade = intval($explode[1]);

		DB::table('prato_variedade')
		->where('cod_prato',$cod_prato)
		->where('cod_variedade',$cod_variedade)
		->delete();
		return 1;
	}

}