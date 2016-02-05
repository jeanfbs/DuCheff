<?php 



class GuarnicoesModel extends Eloquent
{
	protected $table = 'guarnicoes';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}