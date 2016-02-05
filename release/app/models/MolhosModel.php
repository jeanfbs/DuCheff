<?php 


class MolhosModel extends Eloquent
{

	protected $table = 'molhos';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}