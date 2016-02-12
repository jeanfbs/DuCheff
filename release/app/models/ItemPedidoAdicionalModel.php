<?php 
/**
*	TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*	
*	Modelo Adicionais do Pedido
*
*	@author: Jean Fabrício <jeanufu21@gmail.com>
*	@since 12/02/2016
*	
*/
class ItemPedidoAdicionalModel extends Eloquent{


	protected $table = 'item_pedido_adicional';
	public  $timestamps = false;
	protected $primaryKey = array('cod_item','cod_prato','cod_adicional');
	
	public static function saveMultipleKeys($controle = array())
	{
		 return DB::table('item_pedido_adicional')->insert($controle);
	}
}