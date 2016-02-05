<?php 


class PratoCategoriaModel extends Eloquent{


	protected $table = 'prato_categoria';
	public  $timestamps = false;
	protected $primaryKey = array('cod_prato','cod_categoria');
		
		public static function saveMultipleKeys($controle = array())
		{
			 return DB::table('prato_categoria')->insert($controle);
		}
}