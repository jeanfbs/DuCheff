<?php 



class FuncionariosModel extends Eloquent
{
	protected $table = 'funcionarios';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}