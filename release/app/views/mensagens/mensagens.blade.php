@extends('template')

@section('title')   {{trans('geral.titulo_mensagens')}}    @stop
@section('content')

<style type="text/css" media="screen">
	.name{font-size: 18px;}
	.tipo{font-size: 16px;text-transform: uppercase;}
	.margin-left{margin-left: 50px;}
</style>
<!--Start Breadcrumb-->
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<ol class="breadcrumb">
			<li><a href="{{url('panel-control/dashboard')}}">{{trans('geral.breadcrumb_home')}}</a></li>
			<li><a href="#">{{trans('geral.titulo_mensagens')}}</a></li>
			<li><a href="#" id="view_name">{{trans('geral.tab_pesquisar')}}</a></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 page-feed">
		@if(isset($comentarios))
			@foreach($comentarios as $c)
				<div class="box">
					<div class="avatar">
						@if($c->tipo == 2)
							<img src="{{url('img/ic_sad.png')}}" alt="Smile Triste" />
						@else
							<img src="{{url('img/ic_happy.png')}}" alt="Smile Sorrindo" />
						@endif
					</div>
					<div class="page-feed-content">
						@if($c->tipo == 1)
							<span class="tipo text-primary" >{{trans('geral.elogio')}}</span>
						@elseif($c->tipo == 2)
							<span class="tipo text-danger">{{trans('geral.reclamacao')}}</span>
						@elseif($c->tipo == 3)
							<span class="tipo text-warning">{{trans('geral.sugestao')}}</span>
						@endif
						
						<span class="name margin-left">{{$c->nome}}, &lt;{{$c->email}}&gt;</span>
						<small class="time pull-right">{{$c->data}} {{$c->horario}} <i class="fa fa-clock-o"></i></small>
						<br><br>
						<p class="margin-left">{{$c->mensagem}}</p>
					</div>
				</div>
			@endforeach
		@endif
	</div>
</div>


@stop