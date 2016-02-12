<?php 

class SuporteController extends BaseController{

	public function getIndex()
	{
		
		return View::make("suporte.suporte");
	}
}