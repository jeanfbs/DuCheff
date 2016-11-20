@extends('site.pagebase')

@section('title')  Cardápio   @stop
@section('content')
<!-- Introduction Row -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Cardápio</h1>
                <p>O Macarrão Du Cheff possuí os melhores pratos italianos da região,
                    com diversos tipos e categorias de massas. Você pode fazer seu pedido
                    utilizando nosso Aplicativo disponível para Android.
                </p>
            </div>
        </div>
        
        @if(isset($resultado))
            @foreach($resultado as $r)
            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" name="cod_tipo_prato" value="{{$r['cod']}}">
                    <h2 class="page-header text-danger">{{$r["nome"]}}</h2>
                </div>
                @if(count($r["pratos"]) == 0)
                    <h4>Nenhum resultado encontrado</h4>
                @endif
                    @foreach($r["pratos"] as $p)
                        <div class="col-lg-4 col-sm-6 ">
                            <img class=" img-responsive img-center" src="{{(($p['foto_url'] != null)? Request::root().'/'.$p['foto_url']:Request::root().'/img/noimage.png')}}" alt="{{(($p['foto_url'] != null)? $p['foto_url']:'img/noimage.png')}}">
                            <h4>{{$p['nome']}}
                                <span class="text-primary valor">R$ {{$p["valor"]}}</span>
                            </h4>
                            <p>{{$p["descricao"]}}</p>
                            <h4><a href="{{url('download-app')}}" title="Baixar aplicativo"><i class="fa fa-mobile"></i> Baixe o aplicativo e faça já seu pedido!</a></h4>
                            <hr>
                        </div>
                    @endforeach
            </div>
            @endforeach
        @endif
@stop