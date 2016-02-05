<?php 



class EstoqueProdutoModel extends Eloquent
{
	protected $table = 'estoque_produtos';
	public  $timestamps = false;
	protected $primaryKey = 'cod_estoque';
	protected $guarded = array('cod_estoque');
}