<?php 



class ClientesModel extends Eloquent
{
	protected $table = 'clientes';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}