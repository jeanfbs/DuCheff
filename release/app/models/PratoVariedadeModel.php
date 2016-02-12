<?php 

/**
*	TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*	
*	Modelo Variedades do Prato
*
*	@author: Jean Fabrício <jeanufu21@gmail.com>
*	@since 12/02/2016
*	
*/
class PratoVariedadeModel extends Eloquent{


	protected $table = 'prato_variedade';
	public  $timestamps = false;
	protected $primaryKey = array('cod_prato','cod_variedade');
		
		public static function saveMultipleKeys($controle = array())
		{
			 return DB::table('prato_variedade')->insert($controle);
		}
}