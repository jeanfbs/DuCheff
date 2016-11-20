@extends('site.pagebase')

@section('title')  Contato   @stop
@section('content')
<style type="text/css" media="screen">
    #social a {margin-left: 20px; color: #444;}
</style>
<div class="row">
@if(isset($msg))
    <div class="alert alert-success" role="alert">{{$msg}}</div>
@endif
    <div class="container">
        <div class="col-md-12">
            <div class="col-md-5">
                <img width="280" src="{{url('img/mapicon.png')}}" alt="Ícone Mapa">
            </div>
            <div class="col-md-7">
                {{Form::open(array('url' => 'contato','id' => 'form_mensagem'))}}
                    <h3>Fale Conosco</h3>
                  <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <label for="assunto">Assunto</label>
                    <input type="text" class="form-control" name="assunto" id="assunto" placeholder="Assunto">
                  </div>
                  <div class="form-group">
                    <label>Mensagem</label>
                    <textarea class="form-control" name="msg" rows="3"></textarea>
                  </div>
                  <button type="submit" class="btn btn-lg btn-primary">Enviar</button>
                {{Form::close()}}
                <br>
            </div>
        </div>
        <div class="col-md-12 well">
            <div class="col-lg-6">
                <strong>Endereço</strong>
                <address>Avenida Mato Grosso, 1202 - Nossa Senhora Aparecida<br>
                 Uberlândia - MG, 38400-724 <br>
                 Telefone: (034) 3234-0633
                </address>
            </div>
            <div class="col-lg-6" id="social">
                <span>Redes Sociais</span> 
                <a href='https://www.facebook.com/pages/Macarrao-Du-Cheff/477159149025964'>
                    <i class="fa fa-facebook-square fa-2x"></i>
                </a>
                <a href='#'>
                    <i class="fa fa-google-plus fa-2x"></i>
                </a>
                <a href='#'>
                    <i class="fa fa-twitter fa-2x"></i>
                </a>
            </div>
            <br><hr>
            <div class="col-md-12">
                <h4 class="text-center">Horário de Funcionamento Segunda a Sábado das 19:00 às 23:30 hs</h4>
            </div>
        </div>

    </div>

</div>
@stop