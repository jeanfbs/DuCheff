<?php 
/**
*	TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*	
*	Modelo Bebidas do Pedido
*
*	@author: Jean Fabrício <jeanufu21@gmail.com>
*	@since 12/02/2016
*	
*/
class ItemPedidoBebidaModel extends Eloquent{


	protected $table = 'itens_pedido_bebida';
	public  $timestamps = false;
	protected $primaryKey = array('cod_pedido','cod_bebida');
		
		public static function saveMultipleKeys($controle = array())
		{
			 return DB::table('itens_pedido_bebida')->insert($controle);
		}
}