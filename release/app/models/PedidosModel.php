<?php 



class PedidosModel extends Eloquent
{
	protected $table = 'pedidos';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}