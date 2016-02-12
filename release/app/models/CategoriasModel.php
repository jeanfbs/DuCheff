<?php 
/**
*	TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*	
*	Modelo Categorias
*
*	@author: Jean Fabrício <jeanufu21@gmail.com>
*	@since 12/02/2016
*	
*/
class CategoriasModel extends Eloquent{


	protected $table = 'categorias';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}