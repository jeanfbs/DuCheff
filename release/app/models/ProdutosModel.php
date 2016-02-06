<?php 


class ProdutosModel extends Eloquent{


	protected $table = 'produtos';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}