<?php 

/**
*	TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*	
*	Modelo Itens do Pedido (Pratos)
*
*	@author: Jean Fabrício <jeanufu21@gmail.com>
*	@since 12/02/2016
*	
*/
class ItemPedidoModel extends Eloquent
{
	protected $table = 'item_pedido';
	public  $timestamps = false;
	protected $primaryKey = 'cod_item';
	protected $guarded = array('cod_item');
}