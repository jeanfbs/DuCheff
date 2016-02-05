<?php 


class PratoVariedadeModel extends Eloquent{


	protected $table = 'prato_variedade';
	public  $timestamps = false;
	protected $primaryKey = array('cod_prato','cod_variedade');
		
		public static function saveMultipleKeys($controle = array())
		{
			 return DB::table('prato_variedade')->insert($controle);
		}
}