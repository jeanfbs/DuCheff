<?php 


class ItemPedidoAdicionalModel extends Eloquent{


	protected $table = 'item_pedido_adicional';
	public  $timestamps = false;
	protected $primaryKey = array('cod_item','cod_prato','cod_adicional');
	
	public static function saveMultipleKeys($controle = array())
	{
		 return DB::table('item_pedido_adicional')->insert($controle);
	}
}