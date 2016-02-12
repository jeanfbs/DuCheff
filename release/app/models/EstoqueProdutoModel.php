<?php 

/**
*	TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*	
*	Modelo Estoque Produtos
*
*	@author: Jean Fabrício <jeanufu21@gmail.com>
*	@since 12/02/2016
*	
*/
class EstoqueProdutoModel extends Eloquent
{
	protected $table = 'estoque_produtos';
	public  $timestamps = false;
	protected $primaryKey = 'cod_estoque';
	protected $guarded = array('cod_estoque');
}