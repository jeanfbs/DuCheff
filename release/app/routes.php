<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/','SiteController@getIndex');
Route::get('/cardapio/{id?}','SiteController@getCardapio');
Route::get('/download-app','SiteController@getAplicativo');
Route::get('/contato','SiteController@getContato');
Route::post('/contato','SiteController@postContato');
Route::get('/login','LoginController@index');
Route::post('auth','LoginController@autenticar');
Route::get('auth',function(){
	return View::make('assets.404');
});



// Android Web Service
Route::controller('/android', "AndroidController");

Route::group(array('prefix' => 'panel-control','before' => 'logado'),function(){
	// Menu Bar routes
	Route::get('dashboard','DashboardController@getDashboard');
	Route::get('logout','DashboardController@getLogout');
	Route::get('perfil','DashboardController@getPerfil');
	Route::get('grafico-pedidos','DashboardController@getGraficopedidos');
	Route::get('grafico-app','DashboardController@getGraficoapp');
	Route::get('grafico-pratos','DashboardController@getGraficopratos');
	Route::get('grafico-nvclientes','DashboardController@getGraficonovosclientes');
	Route::get('historico','DashboardController@getHistorico');
	
	Route::post('perfil','DashboardController@postPerfil');

	Route::controller('/mensagens', "MensagemController");
	Route::controller('/usuario', "UsuarioController");

	Route::controller('/clientes', "ClienteController");

	// Cardapio Routes
	Route::controller('/bebidas', "BebidaController");
	Route::controller('/variedades', "VariedadeController");
	Route::controller('/tipos', "TipoController");
	Route::controller('/produtos', "ProdutoController");
	Route::controller('/categorias', "CategoriaController");
	Route::controller('/adicionais', "AdicionalController");
	Route::controller('/pratos', "PratoController");
	Route::controller('/pratos-variedades', "PratoVariedadeController");
	Route::controller('/pratos-categorias', "PratoCategoriaController");


	Route::controller('/pedidos', "PedidoController");

	Route::controller('/estoque-produtos', "EstoqueProdutoController");
	Route::controller('/estoque-bebidas', "EstoqueBebidaController");
	
	Route::controller('ajuda','SuporteController');


});

// Metodo utilizado igualmente para o
	// missing do controller porém aqui
	// e da propria aplicação

App::missing(function($exception)
{
	return View::make('assets.404');
});