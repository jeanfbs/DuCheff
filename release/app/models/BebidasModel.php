<?php 



class BebidasModel extends Eloquent
{
	protected $table = 'bebidas';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}