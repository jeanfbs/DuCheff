<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    
    <title>@yield('title')</title>
    <meta name="description" content="Sistem de Gestão e Controle de rebanho bovino">
    <meta name="author" content="TechMob">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{url('plugins/bootstrap/bootstrap.css')}}" rel="stylesheet">
    <link href="{{url('plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet">
    <link href="{{url('css/font-awesome.min.css')}}" rel="stylesheet">
    
    <link href="{{url('css/style.css')}}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
        <script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
    <![endif]-->

    <!-- Scripts -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="http://code.jquery.com/jquery.js"></script>-->
    <script src="{{url('plugins/jquery/jquery-2.1.0.min.js')}}"></script>
    <script src="{{url('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{url('plugins/bootstrap/bootstrap.min.js')}}"></script>
    <!-- All functions for this theme + document.ready processing -->
    <script>
    $(document).ready(function(){

      $(document).tooltip({selector:'*[data-toggle="tooltip"]'});
    });
    </script> 
    <script src="{{url('js/devoops.js')}}"></script>
  </head>
<body>
<!--Start Header-->
<div id="screensaver">
  <canvas id="canvas"></canvas>
  <i class="fa fa-lock" id="screen_unlock"></i>
</div>
<header class="navbar">
  <div class="container-fluid expanded-panel">
    <div class="row">
      <!-- Divisão da Logomarca -->
      <div id="logo" class="col-xs-12 col-sm-2">
        <img class="pull-left" src="{{url('/img/logo.png')}}" alt="Logo DuCheff" width="40">
        <a href="{{url('/panel-control/dashboard')}}">DuCheff</a>
      </div>
      <div id="top-panel" class="col-xs-12 col-sm-10">
        <div class="row">
          <!-- Caixa de pesquisa a direita Nav-Bar -->
          <div class="col-xs-8 col-sm-4">
            <a href="#" class="show-sidebar">
              <i class="fa fa-bars"></i>
            </a>
            <!-- <div id="search">
              <input type="text" placeholder="search"/>
              <i class="fa fa-search"></i>
            </div> -->
          </div>
              <!-- Fim da caixa de pesquisa -->
          <div class="col-xs-4 col-sm-8 top-panel-right">
            <ul class="nav navbar-nav pull-right panel-menu">
              <li class="hidden-xs">
                <a href="{{url('panel-control/pedidos')}}">
                  <i class="fa fa-bell"></i>
                  <span class="badge" id="qtd_pedidos"></span>
                </a>
              </li>
              <li class="hidden-xs">
                <a href="{{url('panel-control/mensagens')}}">
                  <i class="fa fa-envelope"></i>
                  <span class="badge" id="qtd_comentarios"></span>
                </a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle account" data-toggle="dropdown">
                  <div class="avatar">
                    <img src="{{((Session::get('foto_url') == null) ? url('img/avatar.png'):Session::get('foto_url'))}}" class="img-rounded" alt="avatar" />
                  </div>
                  <i class="fa fa-angle-down pull-right"></i>
                  <div class="user-mini pull-right">
                    <span class="welcome">{{trans('geral.hello')}},</span>
                    <span>{{Session::get('nome_user')}}</span>
                  </div>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="{{url('panel-control/perfil')}}">
                      <i class="fa fa-user"></i>
                      <span>{{trans('geral.menu_perfil')}}</span>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-bell"></i>
                      <span>{{trans('geral.menu_notif')}}</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{url('panel-control/logout')}}">
                      <i class="fa fa-support"></i>
                      <span>{{trans('geral.menu_suport')}}</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{url('panel-control/logout')}}">
                      <i class="fa fa-power-off"></i>
                      <span>{{trans('geral.menu_sair')}}</span>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!--End Header-->
<!--Start Container-->
<div id="main" class="container-fluid">
  <div class="row">
    <div id="sidebar-left" class="col-xs-2 col-sm-2">
      <ul class="nav main-menu">
        <li>
          <a href="{{url('panel-control/dashboard')}}" class="{{((Session::get('flag') == 1) ? 'active':'')}}">
            <i class="fa fa-dashboard"></i>
            <span class="hidden-xs">{{trans('geral.menu_side_dashboard')}}</span>
          </a>
        </li>
        @if(Session::get('nivel_user') == 1)
        <li class="dropdown">
          <a href="{{url('panel-control/usuario')}}" class="{{((Session::get('flag') == 2) ? 'active':'')}}">
            <i class="fa fa-user"></i>
            <span class="hidden-xs">{{trans('geral.menu_side_usuario')}}</span>
          </a>
        </li>
        @endif
        <li>
          <a href="{{url('panel-control/clientes')}}" class="{{((Session::get('flag') == 3) ? 'active':'')}}">
            <i class="fa fa-users"></i>
            <span class="hidden-xs">{{trans('geral.menu_side_cliente')}}</span>
          </a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle {{((Session::get('flag') > 3 && (Session::get('flag') <= 10)) ? 'active':'')}}">
            <i class="fa fa-cutlery"></i>
             <span class="hidden-xs">{{trans('geral.menu_side_cardapio')}}</span>
             <i class="fa fa-caret-down pull-right"></i>
          </a>
          <ul class="dropdown-menu" style="{{((Session::get('flag') > 3 && (Session::get('flag') <= 10)) ? 'display:block;':'display:none;')}}">
            <li><a  href="{{url('panel-control/bebidas')}}" class="{{((Session::get('flag') == 4) ? 'active':'')}}">{{trans('geral.menu_side_cardapio_bebidas')}} <i class="fa fa-angle-right pull-right"></i></a></li>
            <li><a  href="{{url('panel-control/produtos')}}" class="{{((Session::get('flag') == 5) ? 'active':'')}}">{{trans('geral.menu_side_cardapio_produtos')}} <i class="fa fa-angle-right pull-right"></i></a></li>
            <li><a  href="{{url('panel-control/categorias')}}" class="{{((Session::get('flag') == 6) ? 'active':'')}}">{{trans('geral.menu_side_cardapio_categorias')}} <i class="fa fa-angle-right pull-right"></i></a></li>
            <li><a  href="{{url('panel-control/adicionais')}}" class="{{((Session::get('flag') == 7) ? 'active':'')}}">{{trans('geral.menu_side_cardapio_adicionais')}} <i class="fa fa-angle-right pull-right"></i></a></li>
            <li role="presentation" class="divider"></li>
            <li><a  href="{{url('panel-control/variedades')}}" class="{{((Session::get('flag') == 8) ? 'active':'')}}">{{trans('geral.menu_side_cardapio_variedades')}} <i class="fa fa-angle-right pull-right"></i></a></li>
            <li><a  href="{{url('panel-control/tipos')}}" class="{{((Session::get('flag') == 9) ? 'active':'')}}">{{trans('geral.menu_side_cardapio_tipos')}} <i class="fa fa-angle-right pull-right"></i></a></li>
            <li><a  href="{{url('panel-control/pratos')}}" class="{{((Session::get('flag') == 10) ? 'active':'')}}">{{trans('geral.menu_side_cardapio_pratos')}} <i class="fa fa-angle-right pull-right"></i></a></li>
          </ul>
        </li>
        <li>
          <a href="{{url('panel-control/pedidos')}}" class="{{((Session::get('flag') == 11) ? 'active':'')}}">
            <i class="fa fa-paper-plane"></i>
             <span class="hidden-xs">{{trans('geral.menu_side_pedido')}}</span>
          </a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle {{((Session::get('flag') > 11 && (Session::get('flag') <= 13)) ? 'active':'')}}">
            <i class="fa fa-cubes"></i>
             <span class="hidden-xs">{{trans('geral.menu_side_estoque')}}</span>
             <i class="fa fa-caret-down pull-right"></i>
          </a>
          <ul class="dropdown-menu" style="{{((Session::get('flag') > 11 && (Session::get('flag') <= 13)) ? 'display:block;':'display:none;')}}">
            <li><a  href="{{url('panel-control/estoque-produtos')}}" class="{{((Session::get('flag') == 12) ? 'active':'')}}">{{trans('geral.menu_side_cardapio_produtos')}} <i class="fa fa-angle-right pull-right"></i></a></li>
            <li><a  href="{{url('panel-control/estoque-bebidas')}}" class="{{((Session::get('flag') == 13) ? 'active':'')}}">{{trans('geral.menu_side_cardapio_bebidas')}} <i class="fa fa-angle-right pull-right"></i></a></li>
          </ul>
        </li>
      </ul>
    </div>
    <!--Start Content-->
    <div id="content" class="col-xs-12 col-sm-10">
      
      <div id="ajax-content">
        @yield('content')
      </div>
    </div>
    <!--End Content-->
  </div>
</div>
<!--End Container-->
<!-- Get Translate File -->
@if(App::getLocale() == 'pt-br')
<script src="{{url('js/locale/pt_br.js')}}"></script>
@endif

<script>
$(document).ready(function(){

  $.ajax({
        type: "GET",
        url : pt_br.absolute_url+"/panel-control/mensagens/novoscomentarios",
        data : {d:0}
    }).done(function(quantidade){
      if(quantidade != 0)
      $("#qtd_comentarios").text(quantidade);
      else
        $("#qtd_comentarios").text("");

    });

    $.ajax({
        type: "GET",
        url : pt_br.absolute_url+"/panel-control/pedidos/novospedidos",
        data : {d:0}
    }).done(function(quantidade){
      if(quantidade != 0)
      $("#qtd_pedidos").text(quantidade);
      else
        $("#qtd_pedidos").text("");

    });

  setInterval(function(){
    $.ajax({
        type: "GET",
        url : pt_br.absolute_url+"/panel-control/mensagens/novoscomentarios",
        data : {d:0}
    }).done(function(quantidade){
      if(quantidade != 0)
      $("#qtd_comentarios").text(quantidade);
      else
        $("#qtd_comentarios").text("");

    });

  },60000);

  setInterval(function(){
    $.ajax({
        type: "GET",
        url : pt_br.absolute_url+"/panel-control/pedidos/novospedidos",
        data : {d:0}
    }).done(function(quantidade){
      if(quantidade != 0)
      $("#qtd_pedidos").text(quantidade);
      else
        $("#qtd_pedidos").text("");

    });

  },60000);
});
</script>
</body>
</html>
