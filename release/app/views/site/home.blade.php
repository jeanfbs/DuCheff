@extends('site.pagebase')

@section('title')  Home   @stop
@section('content')
<div class="row">

    <div class="col-md-offset-1 col-md-10">

        <div class="row carousel-holder">

            <div class="col-md-12">
                <div id="chamariz_carroucel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#chamariz_carroucel" data-slide-to="0" class="active"></li>
                        <li data-target="#chamariz_carroucel" data-slide-to="1"></li>
                        <li data-target="#chamariz_carroucel" data-slide-to="2"></li>
                        <li data-target="#chamariz_carroucel" data-slide-to="3"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <img class="slide-image" src="{{url('img/esp_drawable.jpg')}}" alt="">
                        </div>
                        <div class="item">
                            <img class="slide-image" src="{{url('img/mf_drawable.jpg')}}" alt="">
                        </div>
                        <div class="item">
                            <img class="slide-image" src="{{url('img/mx_drawable.jpg')}}" alt="">
                        </div>
                        <div class="item">
                            <img class="slide-image" src="{{url('img/pq_drawable.jpg')}}" alt="">
                        </div>
                    </div>
                    <a class="left carousel-control" href="#chamariz_carroucel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#chamariz_carroucel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="color-primary">
              <h3>Categorias do Cardápio</h3>
            </div>
            @if(isset($cardapio))
                @foreach($cardapio as $c)
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="{{$c->foto_url}}" alt="{{$c->foto_url}}">
                            <h4 class="text-center">
                                <a href='{{url("cardapio/{$c->cod}")}}'>{{$c->nome}}</a>
                            </h4>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>

</div>
@stop