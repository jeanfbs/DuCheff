<?php 

/**
*	TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*	
*	Modelo Variedades do Pedido
*
*	@author: Jean Fabrício <jeanufu21@gmail.com>
*	@since 12/02/2016
*	
*/
class ItemPedidoVariedadeModel extends Eloquent{


	protected $table = 'item_pedido_variedade';
	public  $timestamps = false;
	protected $primaryKey = array('cod_item','cod_prato','cod_variedade');
		
	public static function saveMultipleKeys($controle = array())
	{
		 return DB::table('item_pedido_variedade')->insert($controle);
	}
}