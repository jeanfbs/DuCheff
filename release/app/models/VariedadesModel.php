<?php 


class VariedadesModel extends Eloquent{


	protected $table = 'variedades';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}