<?php 


class AdicionaisModel extends Eloquent{


	protected $table = 'adicionais';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}