<?php 


class ItemPedidoVariedadeModel extends Eloquent{


	protected $table = 'item_pedido_variedade';
	public  $timestamps = false;
	protected $primaryKey = array('cod_item','cod_prato','cod_variedade');
		
	public static function saveMultipleKeys($controle = array())
	{
		 return DB::table('item_pedido_variedade')->insert($controle);
	}
}