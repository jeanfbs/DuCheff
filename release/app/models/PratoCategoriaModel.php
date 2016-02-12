<?php 
/**
*	TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*	
*	Modelo Categorias do Prato
*
*	@author: Jean Fabrício <jeanufu21@gmail.com>
*	@since 12/02/2016
*	
*/
class PratoCategoriaModel extends Eloquent{


	protected $table = 'prato_categoria';
	public  $timestamps = false;
	protected $primaryKey = array('cod_prato','cod_categoria');
		
		public static function saveMultipleKeys($controle = array())
		{
			 return DB::table('prato_categoria')->insert($controle);
		}
}