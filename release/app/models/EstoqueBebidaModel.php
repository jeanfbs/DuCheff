<?php 
/**
*	TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*	
*	Modelo Estoque Bebidas
*
*	@author: Jean Fabrício <jeanufu21@gmail.com>
*	@since 12/02/2016
*	
*/
class EstoqueBebidaModel extends Eloquent
{
	protected $table = 'estoque_bebidas';
	public  $timestamps = false;
	protected $primaryKey = 'cod_estoque';
	protected $guarded = array('cod_estoque');
}