<?php 



class ItemPedidoModel extends Eloquent
{
	protected $table = 'item_pedido';
	public  $timestamps = false;
	protected $primaryKey = 'cod_item';
	protected $guarded = array('cod_item');
}