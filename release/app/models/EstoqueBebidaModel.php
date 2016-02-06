<?php 

class EstoqueBebidaModel extends Eloquent
{
	protected $table = 'estoque_bebidas';
	public  $timestamps = false;
	protected $primaryKey = 'cod_estoque';
	protected $guarded = array('cod_estoque');
}