<?php 


class PratosModel extends Eloquent{


	protected $table = 'pratos';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}