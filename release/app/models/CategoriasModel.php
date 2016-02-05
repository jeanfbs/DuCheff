<?php 


class CategoriasModel extends Eloquent{


	protected $table = 'categorias';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}