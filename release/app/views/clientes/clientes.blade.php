@extends('template')

@section('title')   {{trans('geral.titulo_clientes')}}    @stop
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('css/alertas.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('css/file.css')}}">
<!-- ALERTA DE MENSAGEM -->
<!-- Alert favor seguir esse padrao e importar a folha de estilo -->
<!-- 
  * Abaixo esta a caixa de alert que tras as mensagens de validação tanto
  * do jquery quanto do php por tras do servidor, se a variavel $msg existir
  * então a mensagem e passada ao atributo message pelo qual via jquery
  * eu remonto dentro do paragrafo                                    -->
@if(Session::has('msg'))
    <div class="panel-alert" id="msg" message="{{Session::get('msg')}}"></div>
@else
<div class="panel-alert" id="msg"></div>
@endif
<br>
<!--Start Breadcrumb-->
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<ol class="breadcrumb">
			<li><a href="{{url('panel-control/dashboard')}}">{{trans('geral.breadcrumb_home')}}</a></li>
			<li><a href="#">{{trans('geral.titulo_clientes')}}</a></li>
			<li><a href="#" id="view_name">{{trans('geral.tab_pesquisar')}}</a></li>
		</ol>
	</div>
</div>
<!--End Breadcrumb-->
<div class="col-xs-12 col-sm-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-users"></i>
					<span>{{trans('geral.titulo_clientes')}}</span>
				</div>
				<div class="box-icons pull-right">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
					<a href="#help">
						<i class="fa fa-question-circle"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content">
				<div id="tabs">
					<ul>
						<li><a href="{{url('panel-control/clientes/cadastro')}}">{{trans('geral.tab_cadastro')}}</a></li>
						<li><a href="{{url('panel-control/clientes/pesquisa')}}">{{trans('geral.tab_pesquisar')}}</a></li>
					</ul>
					<div id="tabs-2">
						
					</div>
				</div>
			</div>
		</div>
	</div>

<div style="height: 40px;"></div>
<script src="{{url('plugins/bootstrapvalidator/bootstrapValidator.min.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{url('js/alertas.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{url('js/utilidades.js')}}" type="text/javascript" charset="utf-8"></script>
<script>
$(document).ready(function() {

	$("#tabs").tabs({active: 1});

	$( "#tabs" ).tabs({
		beforeLoad: function( event, ui ) {
			title = $(ui.tab).text();
			$("#view_name").text(title);

			ui.jqXHR.fail(function() {
				ui.panel.html(
					"Ocorreu um erro ao tentar carregar conteúdo" );
			});
		}
	});

WinMove();
/*------------------------------------------------------------------------
|	A função abaixo verifica a cada vez que o 
|	documento HTML e carregado se foi enviado
|	uma mensagem do servidor de erro ou de
|	alguma operação feita
|------------------------------------------------------------------------*/
		setTimeout(function(){
			alerta();
		},1000);

});
</script>
@stop