<?php 

class ComentarioModel extends Eloquent
{
	protected $table = 'comentarios';
	public  $timestamps = false;
	protected $primaryKey = 'cod';
	protected $guarded = array('cod');
}