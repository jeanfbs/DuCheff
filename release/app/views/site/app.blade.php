@extends('site.pagebase')

@section('title')  Aplicativo   @stop
@section('content')
<style type="text/css" media="screen">
    a:hover{text-decoration: none;color:#ccc;}
    
</style>
<div class="row">
    
    <div class="col-md-12">
    	<div class="col-xs-offset-1 col-md-4">
	        <img width="250" id="app" src="{{url('img/app.jpg')}}" alt="Foto Aplicativo">
	    </div>
    	<div class="col-md-7">
    		<div class="jumbotron">
			  <h1>Simples, Rápido e Fácil</h1>
			  <p>O Macarrão Du Cheff agora está de cara nova, você pode fazer seus pedidos online
			  	pelo aplicativo, e acompanhar todo o processo de seu pedido, até a entrega.
			  	Você também pode salvar suas preferências.</p>
			  <p><a  href="{{url('apk/app-release.apk')}}" download="ducheff.apk"><h2 class="text-primary text-center"><i class="fa fa-download"></i> Download App</h2></a></p>
			</div>
    	</div>
    </div>
</div>
@stop