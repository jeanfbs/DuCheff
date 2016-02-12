<?php 

/**
*	TECHMOB - Empresa Júnior da Faculdade de Computação - UFU 
*	
*	Modelo Pratos
*
*	@author: Jean Fabrício <jeanufu21@gmail.com>
*	@since 12/02/2016
*	
*/
class PratosModel extends Eloquent{


	protected $table = 'pratos';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}